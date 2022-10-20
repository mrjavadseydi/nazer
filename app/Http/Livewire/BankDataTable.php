<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Suggest;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class BankDataTable extends LivewireDatatable
{
    private $counter = 1;

    public function builder()
    {
        return Bank::query();
    }

    public function columns()
    {
        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->alignRight()->headerAlignCenter(),
            Column::name('name')->label('نام بانک')->alignRight()->filterable()->headerAlignCenter(),
        ];
    }
}
