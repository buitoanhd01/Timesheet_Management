<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('1234567890'),
            'role_id' => '1'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'emloyee',
            'email' => 'emloyee@mail.com',
            'password' => bcrypt('1234567890'),
            'role_id' => '2'
        ]);
        // Tạo role
        $role = Role::create(['name' => 'admin']);

        // Tạo permission
        $permission = Permission::create(['name' => 'manage-users']);

        // Gán permission cho role
        $role->givePermissionTo($permission);

        $role2 = Role::create(['name' => 'employee']);

        // Tạo permission
        $permission2 = Permission::create(['name' => 'using']);

        // Gán permission cho role
        $role2->givePermissionTo($permission2);
    }
}
