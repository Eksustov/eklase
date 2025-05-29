<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Create Permissions
        $viewSelf = Permission::firstOrCreate(['name' => 'view-self']);
        $interactWithStudents = Permission::firstOrCreate(['name' => 'interact-with-students']);
        $manageUsers = Permission::firstOrCreate(['name' => 'manage-users']);

        // Assign Permissions to Roles
        $studentRole->givePermissionTo($viewSelf);

        $teacherRole->givePermissionTo([
            $viewSelf,
            $interactWithStudents,
        ]);

        $adminRole->givePermissionTo([
            $viewSelf,
            $interactWithStudents,
            $manageUsers,
        ]);

        // Assign roles to users
        $adminUser = User::find(1); // Example admin user
        if ($adminUser && !$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
        }

        $teacherUser = User::find(2); // Example teacher
        if ($teacherUser && !$teacherUser->hasRole('teacher')) {
            $teacherUser->assignRole('teacher');
        }

        $studentUser = User::find(3); // Example student
        if ($studentUser && !$studentUser->hasRole('student')) {
            $studentUser->assignRole('student');
        }
    }
}
