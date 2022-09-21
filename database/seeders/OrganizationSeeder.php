<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('organizations');
        $table->truncate();

        $organization = new Organization();
        $organization->code = 1;
        $organization->title = 'بیرجند منطقه 1';
        $organization->latitude = '32.873387';
        $organization->longitude = '59.206211';
        $organization->save();

        $organization = new Organization();
        $organization->code = 2;
        $organization->title = 'بیرجند منطقه 2';
        $organization->latitude = '32.865493';
        $organization->longitude = '59.227454';
        $organization->save();

        $organization = new Organization();
        $organization->code = 3;
        $organization->title = 'آرین شهر';
        $organization->save();

        $organization = new Organization();
        $organization->code = 4;
        $organization->title = 'نهبندان';
        $organization->save();

        $organization = new Organization();
        $organization->code = 5;
        $organization->title = 'بشرویه';
        $organization->save();

        $organization = new Organization();
        $organization->code = 6;
        $organization->title = 'سرایان';
        $organization->save();

        $organization = new Organization();
        $organization->code = 7;
        $organization->title = 'سربیشه';
        $organization->save();

        $organization = new Organization();
        $organization->code = 8;
        $organization->title = 'قاین';
        $organization->save();

        $organization = new Organization();
        $organization->code = 9;
        $organization->title = 'طبس';
        $organization->save();
    }
}
