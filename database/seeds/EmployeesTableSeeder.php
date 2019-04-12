<?php

use App\Shop\Employees\Employee;
use App\Shop\Permissions\Permission;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        $createProductPerm = factory(Permission::class)->create([
            'name' => 'create-product',
            'display_name' => 'Create product'
        ]);

        $viewProductPerm = factory(Permission::class)->create([
            'name' => 'view-product',
            'display_name' => 'View product'
        ]);

        $updateProductPerm = factory(Permission::class)->create([
            'name' => 'update-product',
            'display_name' => 'Update product'
        ]);

        $deleteProductPerm = factory(Permission::class)->create([
            'name' => 'delete-product',
            'display_name' => 'Delete product'
        ]);

        $updateOrderPerm = factory(Permission::class)->create([
            'name' => 'update-order',
            'display_name' => 'Update order'
        ]);

         // ===============
        $createStudentPerm = factory(Permission::class)->create([
            'name' => 'create-student',
            'display_name' => 'Create student'
        ]);

        $viewStudentPerm = factory(Permission::class)->create([
            'name' => 'view-student',
            'display_name' => 'View student'
        ]);

        $updateStudentPerm = factory(Permission::class)->create([
            'name' => 'update-student',
            'display_name' => 'Update student'
        ]);

        $deleteStudentPerm = factory(Permission::class)->create([
            'name' => 'delete-student',
            'display_name' => 'Delete student'
        ]);
        
        // =========================

        $employee = factory(Employee::class)->create([
            'email' => 'john@doe.com'
        ]);

        $super = factory(Role::class)->create([
            'name' => 'superadmin',
            'display_name' => 'Super Admin'
        ]);
        

        $roleSuperRepo = new RoleRepository($super);
        $roleSuperRepo->attachToPermission($createProductPerm);
        $roleSuperRepo->attachToPermission($viewProductPerm);
        $roleSuperRepo->attachToPermission($updateProductPerm);
        $roleSuperRepo->attachToPermission($deleteProductPerm);
        $roleSuperRepo->attachToPermission($updateOrderPerm);

        $employee->roles()->save($super);

        $employee = factory(Employee::class)->create([
            'email' => 'admin@doe.com'
        ]);

        $admin = factory(Role::class)->create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);

        $roleAdminRepo = new RoleRepository($admin);
        $roleAdminRepo->attachToPermission($createProductPerm);
        $roleAdminRepo->attachToPermission($viewProductPerm);
        $roleAdminRepo->attachToPermission($updateProductPerm);
        $roleAdminRepo->attachToPermission($deleteProductPerm);
        $roleAdminRepo->attachToPermission($updateOrderPerm);

        $employee->roles()->save($admin);

        $employee = factory(Employee::class)->create([
            'email' => 'professor@doe.com'
        ]);

        $professor = factory(Role::class)->create([
            'name' => 'Professor',
            'display_name' => 'Professor'
        ]);

        $roleProfessorRepo = new RoleRepository($professor);
        
        $roleProfessorRepo->attachToPermission($createStudentPerm);
        $roleProfessorRepo->attachToPermission($viewStudentPerm);
        $roleProfessorRepo->attachToPermission($updateStudentPerm);
        $roleProfessorRepo->attachToPermission($deleteStudentPerm);
        /*$roleClerkRepo->attachToPermission($createProductPerm);
        $roleClerkRepo->attachToPermission($viewProductPerm);
        $roleClerkRepo->attachToPermission($updateProductPerm);*/

        $employee->roles()->save($professor);
    }
}
