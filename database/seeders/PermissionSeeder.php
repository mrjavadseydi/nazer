<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PermissionSeeder extends Seeder
{
    protected $table;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->table = DB::table('permissions');
        $this->table->truncate();

        $permission = new Permission();
        $permission->name = 'reports';
        $permission->title = 'گزارشات';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'file-submit';
        $permission->title = 'ثبت پرونده';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'plans';
        $permission->title = 'لیست طرح ها';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'observes';
        $permission->title = 'لیست بازدید ها';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'done-observes';
        $permission->title = 'لیست بازدید های انجام شده';
        $permission->save();


//        $roles = ['admin', 'daneshjooyar', 'organization', 'observer', 'great-observer'];
//        foreach ($roles as $role) {
//            $menuItems = Config::get('dashboard.primary-' . $role);
//            if( !is_null($menuItems) ){
//                foreach ($menuItems as $groupOrItem){
//                    $name = Str::lower($groupOrItem['permission']);
//                    $title = Str::lower($groupOrItem['title']);
//
//                    if( $groupOrItem['type'] == 'group' ){
//                        $savedItems = false;
//
//                        foreach ($groupOrItem['items'] as $items){
//                            $name = Str::lower($items['permission']);
//                            $title = Str::lower($items['title']);
//                            if(!$savedItems) {
//                                $this->savePermission($name, $title);
//                            }
//
//                            $this->savePermission($name, $title, true);
//                        }
//                    }
//                    else{
//                        $this->savePermission($name, $title);
//                    }
//                }
//            }
//        }

//        $now = now();
//        $this->table->insert(
//            [
//                'name' => 'steps',
//                'title' => 'مراحل طی شده',
//                'created_at' => $now,
//                'updated_at' => $now,
//            ]
//        );
//
//        $this->table->insert(
//            [
//                'name' => 'change-business-status',
//                'title' => 'تغییر وضعیت طرح',
//                'created_at' => $now,
//                'updated_at' => $now,
//            ]
//        );
    }

//    private function savePermission($name, $title, $isGroup = false){
//        $now = now();
//
//        if( $isGroup ){
//            $namePrefixes = ['all', 'new', 'edit', 'delete'];
//            $titlePrefixes = ['همه', 'افزودن', 'ویرایش', 'حذف'];
//
//            foreach ($namePrefixes as $index => $prefix) {
//                $tmpName = $prefix . '-' . $name;
//                $permissionNotExist = Permission::where('name', $tmpName)->get()->isEmpty();
//
//                if( $permissionNotExist ){
//                    if( $titlePrefixes[$index] != 'همه' ){
//                        $title = str_replace('ها', '', $title);
//                        $tmpName = $prefix . '-' . Str::singular($name);
//                    }
//                    $tmpTitle = $titlePrefixes[$index] . ' ' . $title;
//
//                    $this->table->insert(
//                        [
//                            'name' => $tmpName,
//                            'title' => $tmpTitle,
//                            'created_at' => $now,
//                            'updated_at' => $now,
//                        ]
//                    );
//                }
//            }
//        }
//        else{
//            $permissionNotExist = Permission::where('name', $name)->get()->isEmpty();
//
//            if( $permissionNotExist ) {
//                $this->table->insert(
//                    [
//                        'name' => $name,
//                        'title' => $title,
//                        'created_at' => $now,
//                        'updated_at' => $now,
//                    ]
//                );
//            }
//        }
//    }
}
