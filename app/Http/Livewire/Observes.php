<?php

namespace App\Http\Livewire;

use App\Models\Employer;
use App\Models\Image;
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
    public $perPage = 50;
    public $hideable = 'select';

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

            Column::name('performer.firstName')->label('نام مجری')->alignRight()->filterable()->headerAlignCenter(),
            Column::name('performer.lastName')->label('نام خانوادگی مجری')->alignRight()->filterable()->headerAlignCenter(),
            Column::name('performer.nationalityCode')->label('کد ملی مجری')->alignRight()->filterable()->headerAlignCenter(),
            Column::name('performer.phone')->label('تلفن تماس مجری')->alignRight()->filterable()->headerAlignCenter(),
            Column::callback('plan.start_date', function ($data){
                return miladi2shamsi('Y',$data);
            })->label('سال اجرا')->alignRight()->headerAlignCenter(),
            Column::name('supervisor.fullName')->label('ناظر')->alignRight()->filterable()->headerAlignCenter(),
            Column::callback(['observes.id'],function ($data){
                return view('livewire.observer-datatable', ['id' => $data]);
            })->label('ثبت در bpms')->alignRight()->headerAlignCenter(),

            Column::callback('observes.observe_date', function ($date){
                return miladi2shamsi('Y/m/d H:i', $date);
            })->label('تاریخ بازدید')->alignRight()->headerAlignCenter(),
            Column::name('plan.distance')->label('فاصله')->alignRight()->filterable()->headerAlignCenter(),
//            Column::callback('monthly_charge', function ($data){
//                return number_format((int)$data);
//            })->label('هزینه اجرایی ماهانه')->alignRight()->headerAlignCenter(),
//            Column::callback('monthly_income', function ($data){
//                return number_format((int)$data);
//            })->label('درامد خالص ماهانه')->alignRight()->headerAlignCenter(),
//            Column::callback('net_worth', function ($data){
//                return number_format((int)$data);
//            })->label('ارزش سرمایه فعلی')->alignRight()->headerAlignCenter(),
            Column::callback('observes.plan_id', function ($date){
                return Image::where([['plan_id', $date], ['document_id', '2']])->count()==1 ? " &#x2714;":"&#215;";
            })->label('مجوز')->alignRight()->headerAlignCenter(),
            Column::callback(['observes.plan_id','performer.phone'], function ($date,$phone){
                return Image::where([['plan_id', $date], ['document_id', '1']])->count()==1 ? " &#x2714;":"&#215;";
            })->label('تابلو')->alignRight()->headerAlignCenter(),


            Column::callback(['observes.plan_id','monthly_charge'], function ($date,$phone){
                return Image::where([['plan_id', $date], ['document_id', '4']])->count()==1 ? " &#x2714;":"&#215;";
            })->label('بیمه نامه')->alignRight()->headerAlignCenter(),


            Column::callback(['observes.plan_id','id'], function ($date,$phone){
                return Image::where([['plan_id', $date], ['document_id', '5']])->count()==1 ? " &#x2714;":"&#215;";
            })->label('عکس محیط')->alignRight()->headerAlignCenter(),

            Column::callback(['observes.plan_id','id','created_at'], function ($date,$phone){
                return Employer::query()->where('plan_id',$date)->count()??0;
            })->label('تعداد کارکنان')->alignRight()->headerAlignCenter(),


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
