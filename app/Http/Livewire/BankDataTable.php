<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankBranch;
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
            Column::name('city.title')->label('شهر')->alignRight()->filterable()->headerAlignCenter(),
            Column::callback(['id','created_at'],function ($id){
                return BankBranch::where('bank_id',$id)->count();
            })->label('تعداد شعب')->headerAlignCenter()->alignCenter(),
            Column::callback(['id'], function ($id){
                return view('livewire.bank-data-table', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
    }
}
