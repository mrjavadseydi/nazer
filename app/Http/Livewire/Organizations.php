<?php

namespace App\Http\Livewire;

use App\Models\Observe;
use App\Models\Organization;
use App\Models\Plan;
use Illuminate\Support\Facades\Log;
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

            Column::callback(['id','created_at'], function ($ida,$ca){
                $ob =  Observe::query()->whereHas('plan',function ($q) use($ida){
                    $q->where('organization_id',$ida);
                })->get();
                return count($ob);
            })->label('بازدید های انجام شده')->alignRight()->headerAlignCenter(),

            Column::callback(['id','updated_at','code'], function ($ida){
                $ob =  Observe::query()->whereHas('plan',function ($q) use($ida){
                    $q->where('organization_id',$ida)->where('on_bpms',true);
                })->get();
                return count($ob);
            })->label('ثبت bpms')->alignRight()->headerAlignCenter(),

            Column::callback(['id'], function($id){
                return view('livewire.organizations-datatable', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
    }
}
