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
            $request->user()?->hasRole('system-administrator'),
            403
        );

        $search = trim((string) $request->query('search', ''));

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
            $request->user()?->hasRole('system-administrator'),
            403
        );

        $validated = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $user->update([
            'role_id' => $validated['role_id'],
        ]);

        return back()->with(
            'status',
            "{$user->name}'s role was updated successfully."
        );
    }

    public function updatePermissions(Request $request, User $user)
    {
        abort_unless(
            $request->user()?->hasRole('system-administrator'),
            403
        );

        if ($user->hasRole('system-administrator')) {
            return back()->withErrors([
                'permissions' => 'The System Administrator already has full access.',
            ]);
        }

        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'integer',
                'distinct',
                'exists:permissions,id',
            ],
        ]);

        $user->permissions()->sync(
            $validated['permissions'] ?? []
        );

        return back()->with(
            'status',
            "{$user->name}'s permissions were updated successfully."
        );
    }
}