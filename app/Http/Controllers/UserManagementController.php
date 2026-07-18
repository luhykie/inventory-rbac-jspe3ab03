<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(
            $request->user()?->hasPermission('can_manage_users'),
            403
        );

        $search = trim(
            (string) $request->query('search', '')
        );

        $users = User::query()
            ->with([
                'role.permissions',
                'permissions',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $roles = Role::query()
            ->with('permissions')
            ->orderBy('name')
            ->get();

        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact(
            'users',
            'roles',
            'permissions',
            'search'
        ));
    }

    public function updateRole(Request $request, User $user)
    {
        abort_unless(
            $request->user()?->hasPermission('can_manage_users'),
            403
        );

        $validated = $request->validate([
            'role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
        ]);

        /*
         * Prevent the logged-in administrator from removing
         * their own System Administrator role.
         */
        if ($request->user()->id === $user->id) {
            $systemAdministratorRole = Role::query()
                ->where('slug', 'system-administrator')
                ->first();

            if (
                $systemAdministratorRole &&
                (int) $validated['role_id'] !==
                (int) $systemAdministratorRole->id
            ) {
                return back()->withErrors([
                    'role_id' =>
                        'You cannot remove the System Administrator role from your own account.',
                ]);
            }
        }

        $user->update([
            'role_id' => $validated['role_id'],
        ]);

        /*
         * Remove old user permission overrides after changing
         * a role. The new role permissions become the defaults.
         */
        $user->permissions()->detach();

        return back()->with(
            'status',
            "{$user->name}'s role was updated successfully."
        );
    }

    public function updatePermissions(
        Request $request,
        User $user
    ) {
        abort_unless(
            $request->user()?->hasPermission('can_manage_users'),
            403
        );

        $validated = $request->validate([
            'permissions' => [
                'nullable',
                'array',
            ],
            'permissions.*' => [
                'integer',
                'distinct',
                'exists:permissions,id',
            ],
        ]);

        $selectedPermissionIds = collect(
            $validated['permissions'] ?? []
        )
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        /*
         * Always retain the logged-in administrator's
         * User Management permission.
         */
        if ($request->user()->id === $user->id) {
            $manageUsersPermissionId = Permission::query()
                ->where('slug', 'can_manage_users')
                ->value('id');

            if ($manageUsersPermissionId) {
                $selectedPermissionIds->push(
                    (int) $manageUsersPermissionId
                );

                $selectedPermissionIds =
                    $selectedPermissionIds
                        ->unique()
                        ->values();
            }
        }

        $rolePermissionIds = $user->role
            ? $user->role->permissions()
                ->pluck('permissions.id')
                ->map(fn ($id) => (int) $id)
            : collect();

        $allPermissionIds = Permission::query()
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        $syncData = [];

        foreach ($allPermissionIds as $permissionId) {
            $isSelected = $selectedPermissionIds
                ->contains($permissionId);

            $isInherited = $rolePermissionIds
                ->contains($permissionId);

            /*
             * Permission was selected but is not provided
             * by the role, so save it as a direct permission.
             */
            if ($isSelected && ! $isInherited) {
                $syncData[$permissionId] = [
                    'denied' => false,
                ];
            }

            /*
             * Permission is provided by the role but was
             * unchecked, so save a user-specific denial.
             */
            if (! $isSelected && $isInherited) {
                $syncData[$permissionId] = [
                    'denied' => true,
                ];
            }
        }

        $user->permissions()->sync($syncData);

        return back()->with(
            'status',
            "{$user->name}'s permissions were updated successfully."
        );
    }
}