<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('documents');
        $table->truncate();

        $document = new Document();
        $document->title = 'تابلو';
        $document->save();

        $document = new Document();
        $document->title = 'مجوز';
        $document->save();

        $document = new Document();
        $document->title = 'اجاره نامه';
        $document->save();

        $document = new Document();
        $document->title = 'بیمه نامه';
        $document->save();

        $document = new Document();
        $document->title = 'تصویر محیط 1';
        $document->save();

        $document = new Document();
        $document->title = 'تصویر محیط 2';
        $document->save();

        $document = new Document();
        $document->title = 'تصویر محیط 3';
        $document->save();
    }
}
