<?php

namespace App\Http\Livewire;

use App\Models\Organization;
use App\Models\Plan;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Organizations extends LivewireDatatable
{
    private $counter = 1;
    public $perPage = 50;

    public function builder()
    {
        return Organization::query();
    }

    public function columns()
    {
        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->alignRight()->headerAlignCenter(),
            Column::name('code')->label('کد اداره')->alignRight()->headerAlignCenter(),
            Column::name('title')->label('نام اداره')->alignRight()->headerAlignCenter(),
            Column::callback(['id','code'], function ($id){
                return Plan::where('organization_id', $id)->count();
            })->label('تعداد طرح ها')->alignRight()->headerAlignCenter(),
            Column::callback(['id'], function($id){
                return view('livewire.organizations-datatable', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
    }
}
