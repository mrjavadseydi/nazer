<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('courses');
        $table->truncate();

        $course = new Course();
        $course->title = 'بازاریابی';
        $course->save();

        $course = new Course();
        $course->title = 'قوانین کار';
        $course->save();

        $course = new Course();
        $course->title = 'مدیریت نیروی انسانی';
        $course->save();

        $course = new Course();
        $course->title = 'مدیریت منابع مالی و حسابداری';
        $course->save();

        $course = new Course();
        $course->title = 'تولید محتوا و مدیریت پیج اینستاگرام';
        $course->save();
    }
}
