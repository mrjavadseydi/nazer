<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Courses extends LivewireDatatable
{
    private $counter = 1;

    public function builder()
    {
        return Course::query();
    }

    public function columns()
    {
        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            }),
            Column::name('title')->label("عنوان دوره")->alignRight()->headerAlignCenter(),
            Column::name('description')->label("توضیحات")->alignRight()->headerAlignCenter(),
            Column::callback(['id'], function ($id){
                return view('livewire.courses-datatable', compact('id'));
            })->label("عملیات")->alignRight()->headerAlignCenter()
        ];
    }
}
