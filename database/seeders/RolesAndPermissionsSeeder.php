<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage referentials',

            'view event requests',
            'create event requests',
            'update own event requests',
            'submit event requests',
            'review event requests',
            'request revision event requests',
            'approve event requests',
            'reject event requests',

            'view events',
            'create events',
            'update events',
            'schedule events',
            'publish events',
            'unpublish events',
            'complete events',
            'archive events',

            'view event reports',
            'create event reports',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $superAdmin = Role::findOrCreate('super_admin');
        $commissionMember = Role::findOrCreate('commission_member');
        $instanceManager = Role::findOrCreate('instance_manager');
        $viewer = Role::findOrCreate('viewer');

        $superAdmin->syncPermissions(Permission::all());

        $commissionMember->syncPermissions([
            'view event requests',
            'review event requests',
            'request revision event requests',
            'approve event requests',
            'reject event requests',

            'view events',

            'view event reports',
        ]);

        $instanceManager->syncPermissions([
            'view event requests',
            'create event requests',
            'update own event requests',
            'submit event requests',

            'view events',
            'create events',
            'update events',
            'schedule events',
            'publish events',
            'unpublish events',
            'complete events',
            'archive events',

            'view event reports',
            'create event reports',
        ]);

        $viewer->syncPermissions([
            'view event requests',
            'view events',
            'view event reports',
        ]);

        $admin = User::query()->first();

        if ($admin) {
            $admin->syncRoles(['super_admin']);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
