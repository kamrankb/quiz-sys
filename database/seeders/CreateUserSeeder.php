<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name' => 'admin', 
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'status' => 1
        ]);

        $teacher = User::create([
            'first_name' => 'Teacher', 
            'last_name' => 'Kim',
            'email' => 'kim@gmail.com',
            'password' => bcrypt('12345678'),
            'created_by' => 1,
            'status' => 1
        ]);

        $student = User::create([
            'first_name' => 'Vivek', 
            'last_name' => 'Pinjani',
            'email' => 'vivek@gmail.com',
            'password' => bcrypt('12345678'),
            'created_by' => 1,
            'status' => 1
        ]);

        $adminRole = Role::create(['name' => 'Admin']);
        $teacherRole = Role::create(['name' => 'Teacher']);
        $studentRole = Role::create(['name' => 'Student']);

        //Assigning roles to users
        $admin->assignRole([$adminRole->id]);
        $teacher->assignRole([$teacherRole->id]);
        $student->assignRole([$studentRole->id]);

        //Permissions Module Wise
        $Userpermission1 = Permission::create(['name'=>'User-Create','guard_name'=>'web']);
        $Userpermission2 = Permission::create([ 'name'=>'User-Edit','guard_name'=>'web', ]);
        $Userpermission3 = Permission::create([ 'name'=>'User-View', 'guard_name'=>'web', ]);
        $Userpermission4 = Permission::create([ 'name'=>'User-Delete', 'guard_name'=>'web', ]);
        
        //Allot Permissions
        $Permission1 = Permission::create(['name' => 'Permission-Create','guard_name' => 'web']);
        $Permission2 = Permission::create(['name' => 'Permission-Edit','guard_name' => 'web']);
        $Permission3 = Permission::create(['name' => 'Permission-View','guard_name' => 'web']);
        $Permission4 = Permission::create(['name' => 'Permission-Delete','guard_name' => 'web']);
        
        //Role Permissions
        $Role1 = Permission::create(['name' => 'Role-Create','guard_name' => 'web']);
        $Role2 = Permission::create(['name' => 'Role-Edit','guard_name' => 'web']);
        $Role3 = Permission::create(['name' => 'Role-View','guard_name' => 'web']);
        $Role4 = Permission::create(['name' => 'Role-Delete','guard_name' => 'web']);
        
        //Quiz Create
        $Quiz1 = Permission::create(['name' => 'Quiz-Create','guard_name' => 'web']);
        $Quiz2 = Permission::create(['name' => 'Quiz-Edit','guard_name' => 'web']);
        $Quiz3 = Permission::create(['name' => 'Quiz-View','guard_name' => 'web']);
        $Quiz4 = Permission::create(['name' => 'Quiz-Delete','guard_name' => 'web']);

        //Questions Create
        $question1 = Permission::create(['name' => 'Question-Create','guard_name' => 'web']);
        $question2 = Permission::create(['name' => 'Question-Edit','guard_name' => 'web']);
        $question3 = Permission::create(['name' => 'Question-View','guard_name' => 'web']);
        $question4 = Permission::create(['name' => 'Question-Delete','guard_name' => 'web']);

        //Subject Create
        $Subject1 = Permission::create(['name' => 'Subject-Create','guard_name' => 'web']);
        $Subject2 = Permission::create(['name' => 'Subject-Edit','guard_name' => 'web']);
        $Subject3 = Permission::create(['name' => 'Subject-View','guard_name' => 'web']);
        $Subject4 = Permission::create(['name' => 'Subject-Delete','guard_name' => 'web']);


        //Add Permissions to adminRole 
        $adminRole->givePermissionTo([$Userpermission1, $Userpermission2, $Userpermission3, $Userpermission4]);
        $adminRole->givePermissionTo([$Permission1, $Permission2, $Permission3, $Permission4]);
        $adminRole->givePermissionTo([$Role1, $Role2, $Role3, $Role4]);
        $adminRole->givePermissionTo([$Quiz1, $Quiz2, $Quiz3, $Quiz4]);
        $adminRole->givePermissionTo([$question1, $question2, $question3, $question4]);
        $adminRole->givePermissionTo([$Subject1, $Subject2, $Subject3, $Subject4]);
        
        //Add Permissions to TeacherRole 
        $teacherRole->givePermissionTo([$Userpermission1, $Userpermission2, $Userpermission3, $Userpermission4]);
        $teacherRole->givePermissionTo([$Role1, $Role2, $Role3, $Role4]);
        $teacherRole->givePermissionTo([$Quiz1, $Quiz2, $Quiz3, $Quiz4]);
        $adminRole->givePermissionTo([$question1, $question2, $question3, $question4]);
        $teacherRole->givePermissionTo([$Subject1, $Subject2, $Subject3, $Subject4]);
        
        //Add Permissions to Student 
        $studentRole->givePermissionTo([$Quiz1]);
        $studentRole->givePermissionTo([$Subject1]);
    }
}