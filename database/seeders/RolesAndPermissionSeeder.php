<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        //user model
        $userPermission1 = Permission::Create(['name'=> 'create:user','description' => 'create user']);
        $userPermission2 = Permission::Create(['name'=> 'read:user','description' => 'read user']);
        $userPermission3 = Permission::Create(['name'=> 'update:user','description' => 'update user']);
        $userPermission4 = Permission::Create(['name'=> 'delete:user','description' => 'delete user']);
        //role model
        $rolePermission1 = Permission::Create(['name'=> 'create:role','description' => 'create role']);
        $rolePermission2 = Permission::Create(['name'=> 'read:role','description' => 'read role']);
        $rolePermission3 = Permission::Create(['name'=> 'update:role','description' => 'update role']);
        $rolePermission4 = Permission::Create(['name'=> 'delete:role','description' => 'delete role']);
        //permission model
        $Permission1 = Permission::Create(['name'=> 'create:permission','description' => 'create permission']);
        $Permission2 = Permission::Create(['name'=> 'read:permission','description' => 'read permission']);
        $Permission3 = Permission::Create(['name'=> 'update:permission','description' => 'update permission']);
        $Permission4 = Permission::Create(['name'=> 'delete:permission','description' => 'delete permission']);
        //admin model 
        $adminPermission1 = Permission::Create(['name'=> 'read:admin','description' => 'read admin']);
        $adminPermission2 = Permission::Create(['name'=> 'update:admin','description' => 'update admin']);
        
        

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $moderatorRole = Role::Create(['name' => 'moderator']);
        $developerRole = Role::Create(['name' => 'developer']);
        $userRole = Role::Create(['name' => 'user']);
        $miscPermission = Permission::create(['name' => 'N/A', 'description' => 'N/A']);

        $superAdminRole->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $Permission1,
            $Permission2,
            $Permission3,
            $Permission4,
            $adminPermission1,
            $adminPermission2,
            $userPermission1,
        ]);

         $adminRole->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $Permission1,
            $Permission2,
            $Permission3,
            $Permission4,
            $adminPermission1,
            $adminPermission2,
            $userPermission1,
        ]);

        $moderatorRole->syncPermissions([
            $userPermission2,
            $rolePermission2,
            $Permission2,
            $adminPermission1,
        ]);

        $developerRole->syncPermissions([
            $adminPermission1,
        ]);

        $userRole->syncPermissions([
            $miscPermission,
        ]);

        $superAdmin = User::create([
            'name' => 'super admin',
            'is_admin' => 1,
            'email' => 'super@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('hakim123'),
            'remember_token' => Str::random(10),
        ]);

        $admin = User::create([
            'name' => 'admin',
            'is_admin' => 1,
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $moderator = User::create([
            'name' => 'moderator',
            'is_admin' => 1,
            'email' => 'moderator@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $developer = User::create([
            'name' => 'developer',
            'is_admin' => 1,
            'email' => 'developer@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $user = User::create([
            'name' => 'test',
            'is_admin' => 0,
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $superAdmin->syncRoles([$superAdminRole]);

        $admin->syncRoles([$adminRole]);

        $moderator->syncRoles($moderatorRole);

        $developer->syncRoles($developerRole);

        $user->syncRoles($userRole);
    }
}
