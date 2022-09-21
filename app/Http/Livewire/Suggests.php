<?php

namespace App\Http\Livewire;

use App\Models\Suggest;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Suggests extends LivewireDatatable
{
    private $counter = 1;

    public function builder()
    {
        return Suggest::query();
    }

    public function columns()
    {
        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->alignRight()->headerAlignCenter(),
            Column::name('title')->label('عنوان')->alignRight()->headerAlignCenter()->editable(),
            Column::callback(['id'], function ($id){
                return view('livewire.suggests-datatable', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter(),
        ];
    }
}
