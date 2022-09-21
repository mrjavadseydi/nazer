<?php

namespace App\Imports;

use App\Models\Organization;
use App\Models\Performer;
use App\Models\Plan;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportObserve implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
//        dd($collection->first());
        $columns = $collection->first();
        $collection->forget(0);
        $users = [];
        $supervisors = [];

//        dd($collection->get( $collection->count() - 1 ));
        foreach ($collection as $item) {
            $performer = new Performer();
            $performer->nationalityCode = $item[1] == '' ? 0 : $item[1];
            $performer->firstName = $item[2];
            $performer->lastName = $item[3];
            $performer->phone = $item[11];
            $performer->gender = $item[9] == 'مرد' ? 'male' : 'female';
            $performer->save();

            $status = replace_arabic_with_persian_char($item[6]);
            $sss = replace_arabic_with_persian_char($item[13]);
            $implement = replace_arabic_with_persian_char($item[14]);

            try{
                $plan = new Plan();
                $plan->organization_id = trim($item[0]);
                $plan->category = trim($item[4]);
                $plan->level = trim($item[5]);
                $plan->status = trim($status) != '' ? trim($status) : null;
                $plan->title = trim($item[7]);
                if( $item[8] != '' ){
                    $date = fa2en($item[8]);
                    $expiration = shamsi2miladi('Y/m/d', $date);
                    $start_date = $expiration->toDate();
                    $plan->start_date = $start_date;
                }
                $plan->address = trim($item[10]);
                $plan->self_sufficiency_status = $sss != '' ? $sss : null;;
                $plan->implement_method = $implement != '' ? $implement : null;
                $plan->performer_id = $performer->id;

                if( isset($item[16]) and $item[16] ){
                    $date = fa2en($item[16]);
                    $expiration = shamsi2miladi('Y/m/d', $date);
                    $last_observe_date = $expiration->toDate();
                    $plan->last_observe_date = $last_observe_date;
                }
                if( isset($item[17]) and $item[17] != '' ){
                    $supervisor = Supervisor::where('nationalityCode', $item[17])->first();

                    if( !$supervisor )
                        $supervisor = new Supervisor();

                    $supervisor->fullName = $item[15];
                    $supervisor->nationalityCode = $item[17];
                    $supervisor->save();
                    $plan->supervisor_id = $supervisor->id;
                }
                $plan->save();
            }
            catch (\Exception $exception){
                dd($exception);
            }
        }
    }
}
