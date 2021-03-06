<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($i=1; $i <50; $i++){
           $user = User::create([
               'name' => 'test' . $i,
               'email' => 'test' . $i.'@test.com',
               'is_admin' => 0,
               'email_verified_at' => now(),
               'password' => Hash::make('password'),
               'remember_token' => str::random(10),
           ]);
           $role = Role::where('id', 5)->first();
            $permission = Permission::where('name', 'N/A')->first();
            $user->syncRoles($role)->syncPermissions($permission);

       }
    }
}
