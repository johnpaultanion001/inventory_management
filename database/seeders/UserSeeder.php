<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\LayoutStyle;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' ,//password

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id'             => 2,
                'name'           => 'Data Admin',
                'email'          => 'data_admin@admin.com',
                'password'       => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' ,//password

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id'             => 3,
                'name'           => 'Desk Admin',
                'email'          => 'desk_admin@admin.com',
                'password'       => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' ,//password

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id'             => 4,
                'name'           => 'Employee Admin',
                'email'          => 'employee_admin@admin.com',
                'password'       => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' ,//password

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],


        ];


        User::insert($users);

        $roles = [
            [
                'title' => 'SYSTEM ADMIN',
            ],
            [
                'title' => 'DATA ADMIN',
            ],
            [
                'title' => 'DESK ADMIN',
            ],
            [
                'title' => 'EMPLOYEE',
            ],
        ];

        Role::insert($roles);

        $permissions = [
            [
                'title' => 'dashboard_access',
            ],
            [
                'title' => 'inventories_access',
            ],
            [
                'title' => 'categories_access',
            ],
            [
                'title' => 'salesforcast_access',
            ],
            [
                'title' => 'activities_access',
            ],
            [
                'title' => 'roles_access',
            ],
            [
                'title' => 'accounts_access',
            ],

        ];

        Permission::insert($permissions);

        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        Role::findOrFail(2)->permissions()->sync([1]);
        Role::findOrFail(3)->permissions()->sync([1]);
        Role::findOrFail(4)->permissions()->sync([1]);

        User::findOrFail(1)->roles()->sync(1);
        User::findOrFail(2)->roles()->sync(2);
        User::findOrFail(3)->roles()->sync(3);
        User::findOrFail(4)->roles()->sync(4);


    }
}
