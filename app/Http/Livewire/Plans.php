<?php

namespace App\Http\Livewire;

use App\Models\AreaCity;
use App\Models\Observe;
use App\Models\Plan;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Action;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Morilog\Jalali\Jalalian;

class Plans extends LivewireDatatable
{
    private $counter = 1;
    public $exportable = true;
    public $observesCount = 0;
    public $perPage = 50;
    public $supervisorid;

    public function builder()
    {
        $user = Auth::user();
        if( $this->supervisorid )
            $plans = Supervisor::find($this->supervisorid)->plans()->getQuery();
        else{
            if( Str::lower($user->role->name) == 'supervisor' ){
                $plans = Supervisor::where('nationalityCode', $user->nationalityCode)->first()->plans()->getQuery();
            }
            else{
                $plans = Plan::query();
            }
        }

        return $plans
            ->leftJoin('performers', function ($join){
                $join->on('plans.performer_id', '=', 'performers.id');
            })
            ->leftJoin('supervisors', function ($join){
                $join->on('plans.supervisor_id', '=', 'supervisors.id');
            })
            ->leftJoin('organizations', function ($join){
                $join->on('plans.organization_id', '=', 'organizations.id');
            })
            ->leftJoin('area_city', function ($join){
//                $jj = new JoinClause();
//                $jj->
//                $jj->join()->select()
                $join->join('areas as areas', function ($j){
                    $j->on('area_city.area_id', '=', 'areas.id');
                });
                $join->on('plans.area_city_id', '=', 'area_city.id');
//                dd(DB::raw($join->get));
            });
    }

    public function columns()
    {
        $more = Column::callback(['id', 'supervisor.fullName'], function ($id, $supervisorFullName){
            $supervisors = Supervisor::all();
            return view('livewire.more-actions', compact('id', 'supervisorFullName', 'supervisors'));
        });
        $extras = [1 => $more, 13 => 'supervisor.fullName:نام ناظر'];

        $columns = [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('#')->alignRight()->headerAlignCenter(),
            Column::name('organizations.title')->label("اداره")->alignRight()->headerAlignCenter(),
            Column::name('performers.nationalityCode')->label("کد ملی")->alignRight()->headerAlignCenter()->filterable(),

            Column::name('performers.firstName')->label("نام")->alignRight()->headerAlignCenter()->filterable(),
            Column::name('performers.lastName')->label("نام خانوادگی")->alignRight()->headerAlignCenter()->filterable(),
            Column::callback('performers.phone', function ($phone){
                return "<a href='tel:$phone'>$phone</a>";
            })->label("تلفن همراه")->alignRight()->headerAlignCenter()->filterable(),
            Column::callback(['plans.id', 'plans.area_city_id', 'areas.id'], function ($planID, $planAreaCityID, $areaCityID){
                return view('livewire.select-editable', [
                    'rowId' => $planID ? $planID : 0,
                    'modelName' => "AreaCity",
                    'nullable' => true,
                    'valueId' => $planAreaCityID ? $planAreaCityID : 0 , // myModel.user_id
                    'options' => AreaCity::All(), // [["id" => , "name" => , ....], ...]
                ]);
            })->label('محله')->alignRight()->headerAlignCenter(),
            Column::name('plans.address')->label("آدرس طرح")->alignRight()->headerAlignCenter()->editable()->filterable(),
            Column::name('plans.location_type')->label("نوع موقعیت")->alignRight()->headerAlignCenter()->filterable(),

//            Column::name('plans.category')->label("گروه فعالیت")->alignRight()->headerAlignCenter(),
//            Column::name('plans.level')->label("سطح فعالیت")->alignRight()->headerAlignCenter(),
//            Column::name('plans.status')->label("وضعیت فعالیت")->alignRight()->headerAlignCenter(),
            Column::name('plans.title')->label("عنوان طرح")->alignRight()->headerAlignCenter()->filterable(),
            Column::callback('plans.start_date', function ($startDate){
                if( $startDate == '' )
                    return null;
                return miladi2shamsi('Y/m/d', $startDate);
            })->label("تاریخ اجرا")->alignRight()->headerAlignCenter(),
//            Column::callback('performers.gender', function ($gender){
//                return $gender == 'male' ? 'مرد' : 'زن';
//            })->label("جنیست")->alignRight()->headerAlignCenter(),
            Column::name('plans.description')->label("توضیحات")->alignRight()->headerAlignCenter()->editable()->filterable(),
//            Column::name('areas.title')->label("محله")->alignRight()->headerAlignCenter(),

//            Column::name('plans.self_sufficiency_status')->label("وضعیت حودکفایی")->alignRight()->headerAlignCenter(),
//            Column::callback('plans.implement_method', function ($method){
//                return substr($method,0 ,4) . '';
//            })->label("نحوه اجرا")->alignRight()->headerAlignCenter(),
            Column::callback('plans.last_observe_date', function ($lastObserveDate){
                if( $lastObserveDate == '' )
                    return null;
                return miladi2shamsi('Y/m/d', $lastObserveDate);
            })->label("آخرین بازدید")->alignRight()->headerAlignCenter(),
            Column::callback(['id', 'plans.last_observe_date'], function ($planID, $plan){
                $count = Observe::where('plan_id', $planID)->get()->count() ?? 0;
                if( $count )
                    return "<a style='display: block' href='".route('observes.done', compact('planID'))."'>$count</a>";

                return $count;
            })->label('انجام شده')->alignRight()->headerAlignCenter(),
            Column::callback(['id'], function ($id){
                return view('livewire.plans-datatable', compact('id'));
            })->label('عملیات')->alignRight()->headerAlignCenter()
        ];



        if( Str::lower(Auth::user()->role->name) == 'supervisor' ){
            return $columns;
        }
        else{
            foreach ($extras as $index => $extra) {
                if( !($extra instanceof Column) ){
                    $splicedExtra = explode(':', $extra);
                    $extra = Column::name($splicedExtra[0])->label($splicedExtra[1])->alignRight()->headerAlignCenter();
                }
                array_splice($columns, $index, 0, [$extra]);
            }

            return $columns;
        }
    }

    public function saveData($rowId, $modelName, $value)
    {
        $plan = Plan::find($rowId);
        $plan->area_city_id = $value == '' ? null : $value;
        $plan->save();
    }

    public function saveSupervisor($planID, $supervisorID)
    {
        $plan = Plan::find($planID);
        $plan->supervisor_id = $supervisorID;
        $plan->save();

        $this->redirect(route('plans.index'));
    }
}
