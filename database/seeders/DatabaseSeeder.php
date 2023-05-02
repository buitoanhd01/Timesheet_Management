<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use App\Models\User;
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

        // \App\Models\User::factory()->create([
        //     'username' => 'admin',
        //     'password' => bcrypt('1234567890'),
        //     'role_id' => '1'
        // ]);
        // \App\Models\User::factory()->create([
        //     'username' => 'emloyee',
        //     'password' => bcrypt('1234567890'),
        //     'status' => 'active',
        // ]);

        $user = new User([
            'username' => 'admin',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
        ]);

        $user2 = new User([
            'username' => 'employee',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
        ]);
        $user->save();
        $user2->save();
        $employee = new Employee([
            'first_name'    =>  'Toan',
            'last_name'     =>  'Bui',
            'full_name'     =>  'Bui Toan',
            'email'         =>  'toan@mail.com',
            'employee_code' =>  'NV001',
            'tax_code'      =>  '15121711',
            'phone'         =>  '0383388222',
            'address'       =>  'HD',
            'birthday'      =>  '2001-12-15',
            'gender'        =>  'male',
            'start_time'    =>  '2001-12-15',
            'employee_type' =>  'official',
            'position_id'   =>  1,
            'department_id' =>  1,
            'status'        => 'working',
            'user_id'       =>  1, 
        ]);
        $employee->save();
        $employee2 = new Employee([
            'first_name'    =>  'Phan',
            'last_name'     =>  'Truong',
            'full_name'     =>  'Phan Truong',
            'email'         =>  'truong@mail.com',
            'employee_code' =>  'NV002',
            'tax_code'      =>  '151217111',
            'phone'         =>  '03833882222',
            'address'       =>  'HD',
            'birthday'      =>  '2001-12-15',
            'gender'        =>  'male',
            'start_time'    =>  '2001-12-15',
            'employee_type' =>  'official',
            'position_id'   =>  2,
            'department_id' =>  1,
            'status'        => 'working',
            'user_id'       =>  2, 
        ]);
        $employee2->save();
        Permission::create(['name' => 'manage-request']);
        Permission::create(['name' => 'manage-general']);
        Permission::create(['name' => 'manage-calendar']);
        Permission::create(['name' => 'manage-employee']);
        Permission::create(['name' => 'manage-user']);
        Permission::create(['name' => 'manage-department']);
        Permission::create(['name' => 'manage-salary']);
        Permission::create(['name' => 'using']);
        Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'employee']);
        $user->assignRole('super-admin');
        $user2->assignRole('employee');
        $user->givePermissionTo(Permission::all());
        $user2->givePermissionTo('using');
    }
}
