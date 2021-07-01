<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'School Admin'
            ],
            [
                'name' => 'Teacher'
            ],
            [
                'name' => 'Student'
            ]
        ];
        $createrole = Role::insert($role);
        // \App\Models\User::factory(10)->create();
    }
}
