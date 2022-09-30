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

class Observes extends LivewireDatatable
{
    public $planid, $supervisorid, $persianfrom, $persianto;
    private $counter = 1;

    public function builder()
    {
        $user = Auth::user();

        if( $this->planid ) {
            $observes = Plan::find($this->planid)->observes()->getQuery();
        }
        elseif( $this->supervisorid and $this->persianfrom and $this->persianto ){
            $gregorianFrom = shamsi2miladi('Y/m/d', $this->persianfrom);
            $gregorianTo = shamsi2miladi('Y/m/d', $this->persianto);
            $observes = Observe::whereBetween('observe_date', [$gregorianFrom, $gregorianTo])->where('observes.supervisor_id', $this->supervisorid);
        }
        elseif( $this->supervisorid ){
            $observes = Supervisor::find($this->supervisorid)->observes()->getQuery();
        }
        else{
            if( Str::lower($user->role->name) == 'supervisor' ){
                $observes = Supervisor::where('nationalityCode', $user->nationalityCode)->first()->observes()->orderByDesc('observe_date')->getQuery();
            }
            else{
                $observes = Observe::query()->orderByDesc('observe_date');
            }
        }

        return $observes
            ->join('supervisors', function ($join){
                $join->on('observes.supervisor_id', '=', 'supervisors.id');
            })
            ->join('performers', function ($join){
                $join->on('observes.performer_id', '=', 'performers.id');
            })
            ->join('plans', function ($join){
                $join->on('observes.plan_id', '=', 'plans.id');
            });
    }

    public function columns()
    {
        return [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('ردیف')->headerAlignCenter()->alignRight(),

            Column::name('performer.firstName')->label('نام مجری')->alignRight()->headerAlignCenter(),
            Column::name('performer.lastName')->label('نام خانوادگی مجری')->alignRight()->headerAlignCenter(),
            Column::name('performer.nationalityCode')->label('کد ملی مجری')->alignRight()->headerAlignCenter(),
            Column::name('performer.phone')->label('تلفن تماس مجری')->alignRight()->headerAlignCenter(),
            Column::name('supervisor.fullName')->label('ناظر')->alignRight()->headerAlignCenter(),
            Column::callback('observes.on_bpms',function ($data){
                return $data==true?"ثبت شده":"عدم ثبت";
            })->label('ثبت در bpms')->alignRight()->headerAlignCenter(),

            Column::callback('observes.observe_date', function ($date){
                return miladi2shamsi('Y/m/d H:i', $date);
            })->label('تاریخ بازدید')->alignRight()->headerAlignCenter(),
            Column::callback(['id'], function ($observeID){
                $planID = Observe::find($observeID)->load('plan')->plan->id;
                $buttonName = 'مشاهده';
                $data = compact('planID', 'buttonName');
                if( Str::lower(Auth::user()->role->name) == 'admin' )
                    $data['observeID'] = $observeID;

                return view('livewire.plans-datatable', $data);
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];
    }
}
