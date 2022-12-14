<?php

namespace App\Http\Livewire;

use App\Models\AreaCity;
use App\Models\Observe;
use App\Models\Plan;
use App\Models\Supervisor;
use Carbon\Carbon;
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
    public $hideable = 'select';
    public $active;
    public $need_observe;
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

        $plans =  $plans
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
        $plans = $plans->where('on_hold',$this->active);
        if ($this->need_observe==1){
            $plans = $plans->where('next_observe','<',now()->addDays(14))->where('next_observe','!=','0000-00-00');

        }
        return $plans;
    }

    public function columns()
    {
//        $more =
        $extras = [ 13 => 'supervisor.fullName:?????? ????????'];

        $columns = [
            NumberColumn::callback('id', function ($id){
                return $this->counter++;
            })->label('#')->alignRight()->headerAlignCenter(),
            Column::callback(['id', 'supervisor.fullName'], function ($id, $supervisorFullName){
                $supervisors = Supervisor::all();
                return view('livewire.more-actions', compact('id', 'supervisorFullName', 'supervisors'));
            })->exportCallback(function (){
                return "";
            }),
            Column::name('organizations.title')->label("??????????")->alignRight()->filterable()->headerAlignCenter(),
            Column::name('performers.nationalityCode')->label("???? ??????")->alignRight()->headerAlignCenter()->filterable(),

            Column::name('performers.firstName')->label("??????")->alignRight()->headerAlignCenter()->filterable(),
            Column::name('performers.lastName')->label("?????? ????????????????")->alignRight()->headerAlignCenter()->filterable(),
            Column::name("performers.phone")->alignRight()->headerAlignCenter()->label('????????????')->
            filterable()->view('livewire.phone'),
//            Column::callback(['plans.id', 'plans.area_city_id', 'areas.id'], function ($planID, $planAreaCityID, $areaCityID){
//                return view('livewire.select-editable', [
//                    'rowId' => $planID ? $planID : 0,
//                    'modelName' => "AreaCity",
//                    'nullable' => true,
//                    'valueId' => $planAreaCityID ? $planAreaCityID : 0 , // myModel.user_id
//                    'options' => AreaCity::All(), // [["id" => , "name" => , ....], ...]
//                ]);
//            })->label('????????')->alignRight()->headerAlignCenter(),
//            Column::callback(['plans.id', 'plans.area_city_id', 'areas.id'], function ($planID, $planAreaCityID, $areaCityID){
//                return view('livewire.select-editable', [
//                    'rowId' => $planID ? $planID : 0,
//                    'modelName' => "AreaCity",
//                    'nullable' => true,
//                    'valueId' => $planAreaCityID ? $planAreaCityID : 0 , // myModel.user_id
//                    'options' => AreaCity::All(), // [["id" => , "name" => , ....], ...]
//                ]);
//            })->label('????????')->alignRight()->headerAlignCenter()->exportCallback(function ($planID, $planAreaCityID, $areaCityID) {
//                foreach ( AreaCity::All() as $option){
//                    if ($option->id==( $planAreaCityID ? $planAreaCityID : 0 )){
//                        return $option->area->title;
//                    }
//                }
//
//            }),
            Column::name('plans.address')->label("???????? ??????")->alignRight()->headerAlignCenter()->editable()->filterable(),
            Column::name('plans.location_type')->label("?????? ????????????")->alignRight()->headerAlignCenter()->filterable(),

            Column::name('plans.category')->label("???????? ????????????")->alignRight()->headerAlignCenter(),
            Column::name('plans.level')->label("?????? ????????????")->alignRight()->headerAlignCenter(),
//            Column::name('plans.status')->label("?????????? ????????????")->alignRight()->headerAlignCenter(),
            Column::name('plans.title')->label("?????????? ??????")->alignRight()->headerAlignCenter()->filterable(),
            Column::callback('plans.start_date', function ($startDate){
                if( $startDate == '' )
                    return null;
                return miladi2shamsi('Y/m/d', $startDate);
            })->label("?????????? ????????")->alignRight()->headerAlignCenter(),
//            Column::callback('performers.gender', function ($gender){
//                return $gender == 'male' ? '??????' : '????';
//            })->label("??????????")->alignRight()->headerAlignCenter(),
            Column::name('plans.description')->label("??????????????")->alignRight()->headerAlignCenter()->editable()->filterable(),
//            Column::name('areas.title')->label("????????")->alignRight()->headerAlignCenter(),

//            Column::name('plans.self_sufficiency_status')->label("?????????? ????????????????")->alignRight()->headerAlignCenter(),
//            Column::callback('plans.implement_method', function ($method){
//                return substr($method,0 ,4) . '';latitude
//            })->label("???????? ????????")->alignRight()->headerAlignCenter(),
            Column::callback('plans.last_observe_date', function ($lastObserveDate){
                if( $lastObserveDate == '' )
                    return null;
                return miladi2shamsi('Y/m/d', $lastObserveDate);
            })->label("?????????? ????????????")->alignRight()->headerAlignCenter(),
            Column::callback(['plans.next_observe'], function ($nextObserve){
                if ($nextObserve=="0000-00-00"){
                    return "?????????? ??????????";
                }
                $carbon = new Carbon($nextObserve);
                $next = Jalalian::fromCarbon($carbon)->format('Y/m/d');
                $now = Carbon::now();

                if ($now<$carbon){
                    return $next;
                }elseif($now->addDays(15)<$carbon){
                    return "<span class='text-warning'>$next</span>";

                }else{
                    return "<span class='text-danger'>???????????? ????????</span>";
                }
            })->label("???????????? ????????")->alignRight()->headerAlignCenter(),
            Column::name('id')->label('?????????? ??????')->alignRight()->headerAlignCenter()->view('components.done')->exportCallback(function ($value){
                return \App\Models\Observe::where('plan_id', $value)->get()->count() ?? 0;
            }),

//            Column::name(['id', 'plans.last_observe_date'], function ($planID, $plan){
//                $count = Observe::where('plan_id', $planID)->get()->count() ?? 0;
//                if( $count )
//                    return "<a style='display: block' href='".route('observes.done', compact('planID'))."'>$count</a>";
//
//                return $count;
//            })->label('?????????? ??????')->alignRight()->headerAlignCenter(),
            Column::callback(['longitude','latitude'],function ($long,$lat){})->alignCenter()->headerAlignCenter()
                ->view('components.location')->label('gps')->exportCallback(function ($long,$lat){
                    if ($lat){
                        return"????????";
                    }
                }),
            Column::callback(['id'], function ($id){
                return view('livewire.plans-datatable', compact('id'));
            })->label('????????????')->alignRight()->headerAlignCenter()->exportCallback(function (){
                return "";
            })
        ];

        if ($this->active){
            $a = [ Column::name('plans.hold_reason')->label("??????")->alignRight()->headerAlignCenter()->filterable()];
            array_splice( $columns, 2, 0, $a );
        }

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
