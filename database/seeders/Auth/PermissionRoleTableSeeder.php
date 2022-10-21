<?php

namespace Database\Seeders\Auth;

use Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use \Database\Seeders\Traits\DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        $admin = Role::create(['name' => config('access.users.admin_role'), 'ref' => md5(config('access.users.admin_role'))]);
        $teacher = Role::create(['name' => 'teacher', 'ref' => md5('teacher')]);
        $instructor = Role::create(['name' => 'instructor', 'ref' => md5('instructor')]);
        $supplier = Role::create(['name' => 'supplier', 'ref' => md5('supplier')]);
        $seller = Role::create(['name' => 'seller', 'ref' => md5('seller')]);
        $staff = Role::create(['name' => 'staff', 'ref' => md5('staff')]);
        // $designer = Role::create(['name' => 'designer']);
        $moderator = Role::create(['name' => 'moderator', 'ref' => md5('moderator')]);
        $customer = Role::create(['name' => 'customer', 'ref' => md5('customer')]);
        $student = Role::create(['name' => 'student', 'ref' => md5('student')]);
        $user = Role::create(['name' => 'user', 'ref' => md5('user')]);
        $editor = Role::create(['name' => 'editor', 'ref' => md5('editor')]);


        $permissions = [

            ['id' => 1, 'name' => 'user_management_access',],
            ['id' => 2, 'name' => 'user_management_create',],
            ['id' => 3, 'name' => 'user_management_edit',],
            ['id' => 4, 'name' => 'user_management_view',],
            ['id' => 5, 'name' => 'user_management_delete',],

            ['id' => 6, 'name' => 'permission_access',],
            ['id' => 7, 'name' => 'permission_create',],
            ['id' => 8, 'name' => 'permission_edit',],
            ['id' => 9, 'name' => 'permission_view',],
            ['id' => 10, 'name' => 'permission_delete',],

            ['id' => 11, 'name' => 'role_access',],
            ['id' => 12, 'name' => 'role_create',],
            ['id' => 13, 'name' => 'role_edit',],
            ['id' => 14, 'name' => 'role_view',],
            ['id' => 15, 'name' => 'role_delete',],

            ['id' => 16, 'name' => 'user_access',],
            ['id' => 17, 'name' => 'user_create',],
            ['id' => 18, 'name' => 'user_edit',],
            ['id' => 19, 'name' => 'user_view',],
            ['id' => 20, 'name' => 'user_delete',],

            ['id' => 21, 'name' => 'formation_access',],
            ['id' => 22, 'name' => 'formation_create',],
            ['id' => 23, 'name' => 'formation_edit',],
            ['id' => 24, 'name' => 'formation_view',],
            ['id' => 25, 'name' => 'formation_delete',],

            ['id' => 26, 'name' => 'module_access',],
            ['id' => 27, 'name' => 'module_create',],
            ['id' => 28, 'name' => 'module_edit',],
            ['id' => 29, 'name' => 'module_view',],
            ['id' => 30, 'name' => 'module_delete',],

            ['id' => 31, 'name' => 'question_access',],
            ['id' => 32, 'name' => 'question_create',],
            ['id' => 33, 'name' => 'question_edit',],
            ['id' => 34, 'name' => 'question_view',],
            ['id' => 35, 'name' => 'question_delete',],

            ['id' => 36, 'name' => 'questions_option_access',],
            ['id' => 37, 'name' => 'questions_option_create',],
            ['id' => 38, 'name' => 'questions_option_edit',],
            ['id' => 39, 'name' => 'questions_option_view',],
            ['id' => 40, 'name' => 'questions_option_delete',],

            ['id' => 41, 'name' => 'test_access',],
            ['id' => 42, 'name' => 'test_create',],
            ['id' => 43, 'name' => 'test_edit',],
            ['id' => 44, 'name' => 'test_view',],
            ['id' => 45, 'name' => 'test_delete',],

            ['id' => 46, 'name' => 'order_access',],

            ['id' => 47, 'name' => 'view backend',],

            ['id' => 48, 'name' => 'category_access',],
            ['id' => 49, 'name' => 'category_create',],
            ['id' => 50, 'name' => 'category_edit',],
            ['id' => 51, 'name' => 'category_view',],
            ['id' => 52, 'name' => 'category_delete',],

            ['id' => 53, 'name' => 'blog_access',],
            ['id' => 54, 'name' => 'blog_create',],
            ['id' => 55, 'name' => 'blog_edit',],
            ['id' => 56, 'name' => 'blog_view',],
            ['id' => 57, 'name' => 'blog_delete',],

            ['id' => 58, 'name' => 'quotation_access',],
            ['id' => 59, 'name' => 'quotation_create',],
            ['id' => 60, 'name' => 'quotation_edit',],
            ['id' => 61, 'name' => 'quotation_view',],
            ['id' => 62, 'name' => 'quotation_delete',],

            ['id' => 63, 'name' => 'page_access',],
            ['id' => 64, 'name' => 'page_create',],
            ['id' => 65, 'name' => 'page_edit',],
            ['id' => 66, 'name' => 'page_view',],
            ['id' => 67, 'name' => 'page_delete',],

            ['id' => 68, 'name' => 'bundle_access',],
            ['id' => 69, 'name' => 'bundle_create',],
            ['id' => 70, 'name' => 'bundle_edit',],
            ['id' => 71, 'name' => 'bundle_view',],
            ['id' => 72, 'name' => 'bundle_delete',],

            ['id' => 73, 'name' => 'tutorial_access',],
            ['id' => 74, 'name' => 'tutorial_create',],
            ['id' => 75, 'name' => 'tutorial_edit',],
            ['id' => 76, 'name' => 'tutorial_view',],
            ['id' => 77, 'name' => 'tutorial_delete',],

            ['id' => 78, 'name' => 'product_access',],
            ['id' => 79, 'name' => 'product_create',],
            ['id' => 80, 'name' => 'product_edit',],
            ['id' => 81, 'name' => 'product_view',],
            ['id' => 82, 'name' => 'product_delete',],

            ['id' => 83, 'name' => 'tipstricks_access',],
            ['id' => 84, 'name' => 'tipstricks_create',],
            ['id' => 85, 'name' => 'tipstricks_edit',],
            ['id' => 86, 'name' => 'tipstricks_view',],
            ['id' => 87, 'name' => 'tipstricks_delete',],

            ['id' => 88, 'name' => 'staffing_access',],
            ['id' => 89, 'name' => 'staffing_create',],
            ['id' => 90, 'name' => 'staffing_edit',],
            ['id' => 91, 'name' => 'staffing_view',],
            ['id' => 92, 'name' => 'staffing_delete',],

            ['id' => 93, 'name' => 'member_access',],
            ['id' => 94, 'name' => 'member_create',],
            ['id' => 95, 'name' => 'member_edit',],
            ['id' => 96, 'name' => 'member_view',],
            ['id' => 97, 'name' => 'member_delete',],

            ['id' => 98, 'name' => 'premium_access',],
            ['id' => 99, 'name' => 'premium_create',],
            ['id' => 100, 'name' => 'premium_edit',],
            ['id' => 101, 'name' => 'premium_view',],
            ['id' => 102, 'name' => 'premium_delete',],

            ['id' => 103, 'name' => 'porfolio_access',],
            ['id' => 104, 'name' => 'porfolio_create',],
            ['id' => 105, 'name' => 'porfolio_edit',],
            ['id' => 106, 'name' => 'porfolio_view',],
            ['id' => 107, 'name' => 'porfolio_delete',],

            ['id' => 108, 'name' => 'supplier_access',],
            ['id' => 109, 'name' => 'supplier_create',],
            ['id' => 110, 'name' => 'supplier_edit',],
            ['id' => 111, 'name' => 'supplier_view',],
            ['id' => 112, 'name' => 'supplier_delete',],

            ['id' => 113, 'name' => 'media_access',],
            ['id' => 114, 'name' => 'media_create',],
            ['id' => 115, 'name' => 'media_edit',],
            ['id' => 116, 'name' => 'media_view',],
            ['id' => 117, 'name' => 'media_delete',],


        ];


        foreach ($permissions as $item) {
            Permission::create(array_merge($item, array('ref' => md5($item['name']))));
        }

        //        $admin_permissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67];

        $teacher_permissions = [1, 21, 22, 23, 24, 26, 29, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 68, 69, 70, 71, 72];

        $student_permission = [47];


        $instructor_permission = $teacher_permissions;

        $supplier_permission = [78, 79, 80, 81, 82, 108, 110, 111, 112];

        $seller_permission = [108, 109, 110, 111, 112, 46, 58, 59, 61, 78, 79, 80, 81, 82, 93, 96, 98, 101, 108, 109, 110, 111];

        $staff_permission = [1, 21, 24, 26, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 68, 71, 73, 76, 78, 79, 80, 81, 83, 86, 88, 91, 93, 96, 98, 101, 103, 104, 105, 106, 107, 108, 109, 110, 111];
        // $designer_permission = ;
        $moderator_permission = [1, 21, 24, 26, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 63, 64, 65, 66, 67, 68, 71, 73, 76, 78, 79, 80, 81, 82, 83, 86, 88, 91, 93, 96, 98, 101, 103, 104, 105, 106, 107, 108, 109, 110, 111];
        $customer_permission = [46];
        $editor_permission = [31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 48, 49, 50, 51, 53, 54, 55, 56, 57, 63, 64, 65, 66, 67, 68, 71, 73, 76, 78, 79, 80, 81, 83, 84, 85, 86, 87, 103, 104, 105, 106];



        $admin->syncPermissions(Permission::all());
        $teacher->syncPermissions($teacher_permissions);
        $student->syncPermissions($student_permission);

        $instructor->syncPermissions($instructor_permission);
        $supplier->syncPermissions($supplier_permission);
        $seller->syncPermissions($seller_permission);
        $staff->syncPermissions($staff_permission);
        // $designer->syncPermissions($designer_permission);
        $moderator->syncPermissions($moderator_permission);
        $customer->syncPermissions($customer_permission);
        $editor->syncPermissions($editor_permission);

        $this->enableForeignKeys();
    }
}
