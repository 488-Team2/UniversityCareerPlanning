<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_student = Role::where('name', 'student')->first();
        $role_manager  = Role::where('name', 'admin')->first();
        $role_user = Role::where('name', 'user')->first();

        $student = new User();
        $student->name = 'Student Name';
        $student->email = 'student@example.com';
        $student->password = bcrypt('123456');
        $student->email_verified_at = now();
        $student->department_id = 1;
        //$student->username = 'student';
        $student->account_type = 'student';
        $student->save();
        $student->roles()->attach($role_student);

        $user = new User();
        $user->name = 'User Name';
        $user->email = 'user@example.com';
        $user->password = bcrypt('123456');
        $user->email_verified_at = now();
        $user->department_id = 1;
        //$user->username = 'user';
        $user->account_type = 'user';
        $user->save();
        $user->roles()->attach($role_user);

        $manager = new User();
        $manager->name = 'Admin Name';
        $manager->email = 'admin@example.com';
        $manager->password = bcrypt('123456');
        $manager->email_verified_at = now();
        $manager->department_id = 3;
        //$manager->username = 'admin';
        $manager->account_type = 'admin';
        $manager->save();
        $manager->roles()->attach($role_manager);
    }
}
