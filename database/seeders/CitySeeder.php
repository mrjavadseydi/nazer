<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $table = DB::table('cities');
//        $table->truncate();

        $city = new City();
        $city->title = 'بیرجند';
        $city->save();

        $city->areas()->attach([1, 2, 3, 4]);
    }
}
