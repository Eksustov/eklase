<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        echo "Roles created or found.\n";

        // Create Permissions
        $viewSelf = Permission::firstOrCreate(['name' => 'view-self']);
        $interactWithStudents = Permission::firstOrCreate(['name' => 'interact-with-students']);
        $manageUsers = Permission::firstOrCreate(['name' => 'manage-users']);

        // New permissions your routes use:
        $viewStudentsDashboard = Permission::firstOrCreate(['name' => 'view-students-dashboard']);
        $viewTeachersDashboard = Permission::firstOrCreate(['name' => 'view-teachers-dashboard']);
        $viewAdminsDashboard = Permission::firstOrCreate(['name' => 'view-admins-dashboard']);

        // Assign Permissions to Roles
        $studentRole->syncPermissions([$viewSelf, $viewStudentsDashboard]);

        $teacherRole->syncPermissions([
            $viewSelf,
            $interactWithStudents,
            $viewStudentsDashboard,
            $viewTeachersDashboard,
        ]);

        $adminRole->syncPermissions([
            $viewSelf,
            $interactWithStudents,
            $manageUsers,
            $viewStudentsDashboard,
            $viewTeachersDashboard,
            $viewAdminsDashboard,
        ]);

        echo "Permissions assigned to roles.\n";

        // Create or find users
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password')]
        );

        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@example.com'],
            ['name' => 'Teacher User', 'password' => Hash::make('password')]
        );

        $studentUser = User::firstOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Student User', 'password' => Hash::make('password')]
        );

        echo "Users created or found.\n";

        // Assign roles if not already assigned
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
            echo "Assigned admin role to admin user.\n";
        }

        if (!$teacherUser->hasRole('teacher')) {
            $teacherUser->assignRole('teacher');
            echo "Assigned teacher role to teacher user.\n";
        }

        if (!$studentUser->hasRole('student')) {
            $studentUser->assignRole('student');
            echo "Assigned student role to student user.\n";
        }
    }
}
