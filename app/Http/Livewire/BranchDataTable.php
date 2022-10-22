<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankBranch;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class BranchDataTable extends LivewireDatatable
{
    private $counter = 1;

    public function builder()
    {
        $bank = request('bank');
        return BankBranch::query()->when(request()->has('bank'), function ($query) use ($bank) {
            return $query->where('bank_id', $bank);
        });
    }

    public function columns()
    {
        $list =  [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->alignRight()->headerAlignCenter(),
            Column::name('name')->label('نام شعبه')->alignRight()->filterable()->headerAlignCenter(),
            Column::name('code')->label('کد شعبه')->alignRight()->filterable()->headerAlignCenter(),
            Column::name('bank.name')->label('نام بانک')->alignRight()->filterable()->headerAlignCenter(),
            Column::name('phone')->label('تلفن')->alignRight()->filterable()->headerAlignCenter(),
            Column::name('city.title')->label('شهر')->alignRight()->filterable()->headerAlignCenter(),
            Column::callback(['id'], function ($id){
                return view('livewire.branch-data-table', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
        if (request()->has('bank')){
            unset($list[3]);
        }
        return $list;
    }
}
