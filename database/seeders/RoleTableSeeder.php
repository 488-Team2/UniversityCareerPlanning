<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $role_student = new Role();
       $role_student->name = 'student';
       $role_student->description = 'A Student User';
       $role_student->save();

       $role_user = new Role();
       $role_user->name = 'user';
       $role_user->description = 'A Regular User';
       $role_user->save();

       $role_manager = new Role();
       $role_manager->name = 'admin';
       $role_manager->description = 'A Admin User';
       $role_manager->save();
        
    }
}
