<?php

namespace App\Http\Livewire;

use App\Models\Document;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Documents extends LivewireDatatable
{
    private $counter = 1;
    public $perPage = 50;

    public function builder()
    {
        return Document::query();
    }

    public function columns()
    {
        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->alignRight()->headerAlignCenter(),

            Column::name('title')->label('عنوان مدرک')->alignRight()->headerAlignCenter(),
            Column::callback('required', function ($required){
                return $required ? 'اجباری است' : 'اختیاری است';
            })->label('اجباری بودن')->alignRight()->headerAlignCenter(),

            Column::callback(['id'], function($id){
                return view('livewire.documents-datatable', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
    }
}
