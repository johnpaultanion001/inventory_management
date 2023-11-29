<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Forcast;

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
                'title' => 'dashboard',
            ],
            [
                'title' => 'inventories',
            ],
            [
                'title' => 'categories',
            ],
            [
                'title' => 'salesforcast',
            ],
            [
                'title' => 'activities',
            ],
            [
                'title' => 'roles',
            ],
            [
                'title' => 'accounts',
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


        $forcasts = [
            //BEVERAGES
            [
                'month'           => 1,
                'category'           => 'BEVERAGES',
                'total' => 540,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 2,
                'category'           => 'BEVERAGES',
                'total' => 140,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 3,
                'category'           => 'BEVERAGES',
                'total' => 40,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 4,
                'category'           => 'BEVERAGES',
                'total' => 640,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 5,
                'category'           => 'BEVERAGES',
                'total' => 301,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 6,
                'category'           => 'BEVERAGES',
                'total' => 304,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 7,
                'category'           => 'BEVERAGES',
                'total' => 121,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 8,
                'category'           => 'BEVERAGES',
                'total' => 323,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 9,
                'category'           => 'BEVERAGES',
                'total' => 600,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 10,
                'category'           => 'BEVERAGES',
                'total' => 441,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 11,
                'category'           => 'BEVERAGES',
                'total' => 142,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 12,
                'category'           => 'BEVERAGES',
                'total' => 110,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],

            //CANNED FOODS
                [
                    'month'           => 1,
                    'category'           => 'CANNED FOODS',
                    'total' => 540,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 2,
                    'category'           => 'CANNED FOODS',
                    'total' => 140,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 3,
                    'category'           => 'CANNED FOODS',
                    'total' => 40,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 4,
                    'category'           => 'CANNED FOODS',
                    'total' => 640,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 5,
                    'category'           => 'CANNED FOODS',
                    'total' => 301,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 6,
                    'category'           => 'CANNED FOODS',
                    'total' => 304,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 7,
                    'category'           => 'CANNED FOODS',
                    'total' => 121,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 8,
                    'category'           => 'CANNED FOODS',
                    'total' => 323,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 9,
                    'category'           => 'CANNED FOODS',
                    'total' => 600,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 10,
                    'category'           => 'CANNED FOODS',
                    'total' => 441,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 11,
                    'category'           => 'CANNED FOODS',
                    'total' => 142,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'month'           => 12,
                    'category'           => 'CANNED FOODS',
                    'total' => 110,

                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],

            //CONDIMENTS
            [
                'month'           => 1,
                'category'           => 'CONDIMENTS',
                'total' => 540,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 2,
                'category'           => 'CONDIMENTS',
                'total' => 140,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 3,
                'category'           => 'CONDIMENTS',
                'total' => 40,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 4,
                'category'           => 'CONDIMENTS',
                'total' => 640,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 5,
                'category'           => 'CONDIMENTS',
                'total' => 301,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 6,
                'category'           => 'CONDIMENTS',
                'total' => 304,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 7,
                'category'           => 'CONDIMENTS',
                'total' => 121,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 8,
                'category'           => 'CONDIMENTS',
                'total' => 323,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 9,
                'category'           => 'CONDIMENTS',
                'total' => 600,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 10,
                'category'           => 'CONDIMENTS',
                'total' => 441,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 11,
                'category'           => 'CONDIMENTS',
                'total' => 142,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 12,
                'category'           => 'CONDIMENTS',
                'total' => 110,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],

            //FOOD AREA
            [
                'month'           => 1,
                'category'           => 'FOOD AREA',
                'total' => 540,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 2,
                'category'           => 'FOOD AREA',
                'total' => 140,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 3,
                'category'           => 'FOOD AREA',
                'total' => 40,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 4,
                'category'           => 'FOOD AREA',
                'total' => 640,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 5,
                'category'           => 'FOOD AREA',
                'total' => 301,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 6,
                'category'           => 'FOOD AREA',
                'total' => 304,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 7,
                'category'           => 'FOOD AREA',
                'total' => 121,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 8,
                'category'           => 'FOOD AREA',
                'total' => 323,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 9,
                'category'           => 'FOOD AREA',
                'total' => 600,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 10,
                'category'           => 'FOOD AREA',
                'total' => 441,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 11,
                'category'           => 'FOOD AREA',
                'total' => 142,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 12,
                'category'           => 'FOOD AREA',
                'total' => 110,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],

             //PERSONAL CARE
            [
                'month'           => 1,
                'category'           => 'PERSONAL CARE',
                'total' => 540,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 2,
                'category'           => 'PERSONAL CARE',
                'total' => 140,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 3,
                'category'           => 'PERSONAL CARE',
                'total' => 40,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 4,
                'category'           => 'PERSONAL CARE',
                'total' => 640,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 5,
                'category'           => 'PERSONAL CARE',
                'total' => 301,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 6,
                'category'           => 'PERSONAL CARE',
                'total' => 304,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 7,
                'category'           => 'PERSONAL CARE',
                'total' => 121,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 8,
                'category'           => 'PERSONAL CARE',
                'total' => 323,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 9,
                'category'           => 'PERSONAL CARE',
                'total' => 600,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 10,
                'category'           => 'PERSONAL CARE',
                'total' => 441,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 11,
                'category'           => 'PERSONAL CARE',
                'total' => 142,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 12,
                'category'           => 'PERSONAL CARE',
                'total' => 110,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],

            //SOAP AREA
            [
                'month'           => 1,
                'category'           => 'SOAP AREA',
                'total' => 540,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 2,
                'category'           => 'SOAP AREA',
                'total' => 140,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 3,
                'category'           => 'SOAP AREA',
                'total' => 40,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 4,
                'category'           => 'SOAP AREA',
                'total' => 640,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 5,
                'category'           => 'SOAP AREA',
                'total' => 301,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 6,
                'category'           => 'SOAP AREA',
                'total' => 304,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 7,
                'category'           => 'SOAP AREA',
                'total' => 121,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 8,
                'category'           => 'SOAP AREA',
                'total' => 323,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 9,
                'category'           => 'SOAP AREA',
                'total' => 600,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 10,
                'category'           => 'SOAP AREA',
                'total' => 441,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 11,
                'category'           => 'SOAP AREA',
                'total' => 142,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 12,
                'category'           => 'SOAP AREA',
                'total' => 110,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],

             //OTHERS
             [
                'month'           => 1,
                'category'           => 'OTHERS',
                'total' => 540,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 2,
                'category'           => 'OTHERS',
                'total' => 140,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 3,
                'category'           => 'OTHERS',
                'total' => 40,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 4,
                'category'           => 'OTHERS',
                'total' => 640,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 5,
                'category'           => 'OTHERS',
                'total' => 301,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 6,
                'category'           => 'OTHERS',
                'total' => 304,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 7,
                'category'           => 'OTHERS',
                'total' => 121,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 8,
                'category'           => 'OTHERS',
                'total' => 323,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 9,
                'category'           => 'OTHERS',
                'total' => 600,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 10,
                'category'           => 'OTHERS',
                'total' => 441,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 11,
                'category'           => 'OTHERS',
                'total' => 142,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'month'           => 12,
                'category'           => 'OTHERS',
                'total' => 110,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],

        ];
        Forcast::insert($forcasts);


    }
}
