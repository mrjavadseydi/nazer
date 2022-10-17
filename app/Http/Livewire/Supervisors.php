<?php

namespace App\Http\Livewire;

use App\Models\Observe;
use App\Models\Plan;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Morilog\Jalali\Jalalian;

class Supervisors extends LivewireDatatable
{
    private $counter = 1;
    public $perPage = 50;

    public function builder()
    {
        $user = Auth::user();
        if( Str::lower($user->role->name) == 'supervisor' ){
            return Supervisor::where('nationalityCode', $user->nationalityCode)->first()->observes()->getQuery();
        }
        return Supervisor::query();
    }

    public function columns()
    {
        $shamsi = miladi2shamsi('Y/m/d', now());
        $year = explode('/', $shamsi)[0];
        $month = explode('/', $shamsi)[1];
        $monthArray = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        $day = "01";

        $persianFrom = $year . '/' . $month . "/" . $day;
        $gregorianFrom = shamsi2miladi('Y/m/d', $persianFrom);
        if( $month <= 6 )
            $day = "31";
        elseif( $month > 6 and $month < 12 )
            $day = "30";
        elseif( $month == 12 )
            $day = "29";

        $persianTo = $year . '/' . $month . "/" . $day;
        $gregorianTo = shamsi2miladi('Y/m/d', $persianTo);

        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->alignRight()->headerAlignCenter(),

            Column::name('fullName')->label('نام و نام خانوادگی')->alignRight()->headerAlignCenter(),
            Column::name('nationalityCode')->label('کد ملی')->alignRight()->headerAlignCenter(),
            Column::name('phone')->label('تلفن همراه')->alignRight()->headerAlignCenter(),
            Column::callback(['id', 'fullName'], function ($supervisorID, $fullName){
                $count = Plan::where('supervisor_id', $supervisorID)->get()->count();
                if( $count )
                    return "<a style='display: block' href='".route('plans.index', compact('supervisorID'))."'>$count</a>";

                return $count;
            })->label('تعداد طرح ها')->alignRight()->headerAlignCenter(),
            Column::callback(['id', 'phone'], function ($supervisorID, $phone){
                $count = Observe::where('supervisor_id', $supervisorID)->get()->count() ?? 0;
                if( $count )
                    return "<a style='display: block' href='".route('observes.done', compact('supervisorID'))."'>$count</a>";

                return $count;
            })->label('نظارت های انجام شده')->alignRight()->headerAlignCenter(),
            Column::callback(['id', 'phone', 'fullName'], function ($supervisorID, $phone, $fullName) use($persianFrom, $persianTo, $gregorianFrom, $gregorianTo){
                $count = Observe::where('supervisor_id', $supervisorID)->whereBetween('observe_date', [$gregorianFrom, $gregorianTo])->get()->count() ?? 0;
                if( $count )
                    return "<a style='display: block' href='".route('observes.done', compact('supervisorID', 'persianFrom', 'persianTo'))."'>$count</a>";
                return $count;
            })->label('نظارت های انجام شده ' . $monthArray[$month - 1])->alignRight()->headerAlignCenter(),
            Column::callback(['id', 'phone','nationalityCode'], function ($supervisorID, $phone,$n) {
                return Observe::where('supervisor_id',$supervisorID)->where('on_bpms',1)->count();
            })->label("ثبت در bpms")->alignRight()->headerAlignCenter(),
            Column::callback(['id'], function ($id){
                return view('livewire.supervisors-datatable', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
    }
}
