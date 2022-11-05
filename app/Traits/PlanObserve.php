<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

trait PlanObserve
{
    private $types = [
        "خدمات" => [
            3,4,6,12,0
        ],
        "صنعتي و توليدي" => [
            3,3,6,12,0
        ],
        "دامپروري" => [
            3,3,3,12,12
        ],
        "حمل و نقل" => [
            4,6,12,0,0
        ],
        "پرورش آبزيان" => [
            3,2,2,0,0
        ],
        "کشاورزي" => [
            3,2,2,0,0,
        ],
        "صنايع دستي" => [
            3,3,6,0,0
        ],
        "پرورش طيور" => [
            3,4,6,12,0
        ],
        "زنبورداري" => [
            4,4,6,6,12
        ],
        "فرش و گليم" => [
            3,3,6,12,0
        ],
        'صنعتي و معدني'=>[
            3,3,6,12,0
        ]
    ];

    public function nextObserve()
    {
        $months = $this->types[$this->category];
        if (is_null($this->start_date)&&is_null($this->last_observe_date)){
            return '1401/01/01';
        }
        $start = now();
        if (!is_null($this->start_date)){
            $start = new Carbon($this->start_date);
        }elseif(!is_null($this->last_observe_date)){
            $start = new Carbon($this->last_observe_date);
        }
        $start_date = Jalalian::fromCarbon($start)->format('Y');
        $diff = Jalalian::now()->format('Y')-$start_date;
        $month = $months[$diff]??0;
        if ($month==0){
            return  -1;
        }
        if (!is_null($this->last_observe_date)){
            $last =  New \Carbon\Carbon($this->last_observe_date);
            $last = $last->addMonths($month);
        }elseif (!is_null($this->start_date)){
            $last =  New \Carbon\Carbon($this->start_date);
            $last =  $last->addMonths($month);
        }
        try {
            return Jalalian::fromCarbon($last)->format('Y/m/d');

        }catch (\Exception $e){
           Log::alert($e->getMessage());
            return '1401/01/01';
        }


    }
}