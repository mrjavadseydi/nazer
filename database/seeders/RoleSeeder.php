<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('roles');
        $table->truncate();

        $role = new Role();
        $role->name = 'admin';
        $role->title = 'ادمین';
        $role->save();
        $role->permissions()->attach([1, 2, 3]);

        $role = new Role();
        $role->name = 'daneshjooyar';
        $role->title = 'همکار دانشجویار';
        $role->save();
        $role->permissions()->attach([1, 2, 3]);

        $role = new Role();
        $role->name = 'organization';
        $role->title = 'همکار سازمان';
        $role->save();
        $role->permissions()->attach([1, 2, 3]);

        $role = new Role();
        $role->name = 'supervisor';
        $role->title = 'کارشناس فنی';
        $role->save();
        $role->permissions()->attach([1, 2, 3]);

        $role = new Role();
        $role->name = 'great-supervisor';
        $role->title = 'کارشناس فنی عالیه';
        $role->save();
        $role->permissions()->attach([1, 2, 3]);

//        DB::table('permission_role')->truncate();

//        $permissions = Permission::all();
//        foreach ($permissions as $permission) {
//            Role::find(1)->permissions()->save($permission);
//        }

//        $permissionIDs = [1, 42, 43, 45, 46, 67, 68, 69, 70, 71, 72, 73];
//        $permissionNames = [
//            'dashboard', 'businesses', 'all-businesses', 'edit-business', 'delete-business', 'accept-plan', 'consulting-businesses',
//            'feasibility-businesses', 'to-bank-businesses', 'need-execution-businesses', 'need-periodic-businesses', 'steps',
//            'change-business-status'
//        ];
//        $permissionIDs = [];
//        foreach ($permissionNames as $name)
//            $permissionIDs[] = Permission::where('name', $name)->first()->id;
//
//        $permissions = Permission::whereIn('id', $permissionIDs)->get();
//        foreach ($permissions as $permission) {
//            Role::find(2)->permissions()->save($permission);
//        }

//        $table->insert(
//            [
//                'name' => 'organization',
//                'title' => 'همکار سازمان',
//                'created_at' => $now,
//                'updated_at' => $now,
//            ]
//        );

//        $permissions = Permission::whereIn('id', $permissionIDs)->get();
//        foreach ($permissions as $permission) {
//            Role::find(3)->permissions()->save($permission);
//        }

//        $table->insert(
//            [
//                'name' => 'observer',
//                'title' => 'کارشناس فنی',
//                'created_at' => $now,
//                'updated_at' => $now,
//            ]
//        );
//        $table->insert(
//            [
//                'name' => 'great-observer',
//                'title' => 'کارشناس فنی عالیه',
//                'created_at' => $now,
//                'updated_at' => $now,
//            ]
//        );
    }
}
