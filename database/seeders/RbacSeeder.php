<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        /* 1. Permissions ------------------------------------------------ */
        $permissions = [
            'can_create' => 'Create inventory entries',
            'can_update' => 'Update inventory entries',
            'can_view'   => 'View individual item details',
            'can_remove' => 'Remove inventory entries',
            'can_print'  => 'Generate reports for printing',
        ];

        foreach ($permissions as $slug => $name) {
            Permission::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        /* 2. Roles and their permissions -------------------------------- */
        $roles = [
            'system-administrator' => [
                'name' => 'System Administrator',
                // Bypasses all checks via Gate::before(); no rows needed.
                'permissions' => [],
            ],
            'receiving-clerk' => [
                'name' => 'Inventory Receiving Clerk',
                'permissions' => ['can_create', 'can_update', 'can_view'],
            ],
            'inventory-manager' => [
                'name' => 'Inventory Manager',
                'permissions' => ['can_view'],
            ],
            'inventory-supervisor' => [
                'name' => 'Inventory Supervisor',
                'permissions' => ['can_view', 'can_remove'],
            ],
            'reports-officer' => [
                'name' => 'Inventory Reports Officer',
                'permissions' => ['can_print'],
            ],
        ];

        foreach ($roles as $slug => $definition) {
            $role = Role::firstOrCreate(['slug' => $slug], ['name' => $definition['name']]);
            $ids = Permission::whereIn('slug', $definition['permissions'])->pluck('id');
            $role->permissions()->sync($ids);
        }

        /* 3. Assign roles to the seeded demo users ---------------------- */
        $assignments = [
            'admin@inventory.test'      => 'system-administrator',
            'clerk@inventory.test'      => 'receiving-clerk',
            'manager@inventory.test'    => 'inventory-manager',
            'supervisor@inventory.test' => 'inventory-supervisor',
            'reports@inventory.test'    => 'reports-officer',
        ];

        foreach ($assignments as $email => $roleSlug) {
            User::where('email', $email)->update([
                'role_id' => Role::where('slug', $roleSlug)->value('id'),
            ]);
        }
    }
}