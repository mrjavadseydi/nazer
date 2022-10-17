<?php

namespace App\Http\Livewire;

use App\Models\Observe;
use App\Models\Plan;
use App\Models\Problem;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Problems extends LivewireDatatable
{
    private $counter = 1;
    public $perPage = 50;
    public $exportable = false;
    public function builder()
    {
        return Problem::query();
    }

    public function columns()
    {

        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->alignRight()->headerAlignCenter(),

            Column::name('problem')->label('عنوان مشکل')->alignRight()->editable()->headerAlignCenter(),
            Column::name('plan_type')->label('دسته مشکل')->alignRight()->editable()->headerAlignCenter(),
            Column::name('end_value')->label('مقدار bpms')->alignRight()->editable()->headerAlignCenter(),

            Column::callback(['id'], function ($id){
                return view('livewire.problem-datatable', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
    }
}
