<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area = new Area();
        $area->title = 'شمال شهر';
        $area->description = 'شعبانیه، کارگران، مهرشهر';
        $area->save();


        $area = new Area();
        $area->title = 'شرق و مرکز';
        $area->description = 'دستگرد، بلوار ناصری، بلوار صیاد، 17 شهریور، حکیم نزاری، سه راه اسدی، انقلاب، مطهری';
        $area->save();

        $area = new Area();
        $area->title = 'جنوب شهر';
        $area->description = 'غفاری تا سجاد شهر';
        $area->save();

        $area = new Area();
        $area->title = 'غرب';
        $area->description = 'معصومیه تا سمش آباد';
        $area->save();
    }
}
