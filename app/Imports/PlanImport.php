<?php

namespace App\Imports;

use App\Exports\DuplicatePlansExport;
use App\Models\Organization;
use App\Models\Performer;
use App\Models\Plan;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class PlanImport implements ToCollection
{
    public $columns, $duplicates, $emptyNationalityCode;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->columns = $collection->first();
        $collection->forget(0);
        $this->duplicates = [collect($this->columns)];
        $this->emptyNationalityCode = [collect($this->columns)];

        foreach ($collection as $row) {
            $plan = null;
            $planSupervisor = null;

            /**
             * ensure nationality code of current row is not empty.
             */
            if( $row[1] == '' ){
                $this->emptyNationalityCode[] = $row;
                continue;
            }

            /**
             * if performer exists in database then update it else store it
             */

            $performer = Performer::with('plans')->where('nationalityCode', $row[1])->first();
            if ($performer){
                continue;
            }
            if( !$performer )
                $performer = new Performer();
            else{
                $plan = $performer->plans()->with('organization')->first();
                $planSupervisor = $plan->supervisor ?? Supervisor::find(17);

                $gender = $performer->gender == 'male' ? 'مرد': 'زن';
                $start_date = $plan->start_date ? en2fa(miladi2shamsi('Y/m/d',$plan->start_date)) : '';
                $last_observe_date = $plan->last_observe_date ? en2fa(miladi2shamsi('Y/m/d',$plan->last_observe_date)) : '';

                /**
                 * get duplicates rows
                 */
                $info = [
                    $plan->organization->id,
                    $performer->nationalityCode,
                    $performer->firstName,
                    $performer->lastName,
                    $plan->category,
                    $plan->level,
                    $plan->status,
                    $plan->title,
                    $start_date,
                    $gender,
                    $plan->address,
                    $performer->phone,
                    $last_observe_date,
                    $plan->self_sufficiency_status,
                    $plan->implement_method,
                    $planSupervisor->fullName,
                    $planSupervisor->nationalityCode
                ];
                $this->duplicates[] = collect($info);
                $this->duplicates[] = collect($row);
            }

            $performer->nationalityCode = $row[1] == '' ? 0 : $row[1];
            $performer->firstName = $row[2];
            $performer->lastName = $row[3];
            $performer->gender =  'male';
//            $performer->gender = $row[9] == 'مرد' ? 'male' : 'female';
            $performer->phone = $row[11];
            $performer->save();

            /**
             * Convert arabic ي to ی
             */
            $status = replace_arabic_with_persian_char($row[6]);
            $sss = replace_arabic_with_persian_char($row[13]);
            $implement = replace_arabic_with_persian_char($row[14]);

            try{
                /**
                 * if performer's plan not exists then create it else update it.
                 */
//                $plan = $performer->plans()->first();
                if ($plan)
                    continue;
                if( !$plan )
                    $plan = new Plan();

                $plan->organization_id = trim($row[0]);
                $plan->category = trim($row[4]);
                $plan->level = trim($row[5]);
                $plan->status = trim($status) != '' ? trim($status) : null;
                $plan->title = trim($row[7]);
                if( $row[8] != '' ){
                    $date = fa2en($row[8]);
                    $expiration = shamsi2miladi('Y/m/d', $date);
                    $start_date = $expiration->toDate();
                    $plan->start_date = $start_date;
                }
                $plan->address = trim($row[10]);
                $plan->self_sufficiency_status = $sss != '' ? $sss : null;;
                $plan->implement_method = $implement != '' ? $implement : "هدایت شغلی";
                $plan->performer_id = $performer->id;

                if( isset($row[12]) and $row[12] != '' ){
                    $date = fa2en($row[12]."/01/01");
                    $expiration = shamsi2miladi('Y/m/d', $date);
                    $last_observe_date = $expiration->toDate();
                    $plan->last_observe_date = $last_observe_date;
                }
                if( isset($row[16]) and $row[16] != '' ){
                    /**
                     * assign supervisor to plan
                     */
//                    $planSupervisor = $plan->supervisor;
//                    $excelSupervisorInSystem = Supervisor::where('nationalityCode', $row[16])->first();
//
//                    if( !$planSupervisor and !$excelSupervisorInSystem )
//                        $supervisor = new Supervisor();
//
//                    if( $planSupervisor and $excelSupervisorInSystem )
//                        $supervisor = $excelSupervisorInSystem;
//
//                    if( !$planSupervisor and $excelSupervisorInSystem )
//                        $supervisor = $excelSupervisorInSystem;
//
//                    if( $planSupervisor and !$excelSupervisorInSystem )
//                        $supervisor = $planSupervisor;
//
//                    $supervisor->fullName = $row[15];
//                    $supervisor->nationalityCode = $row[16];
//                    $supervisor->save();
                }
                $plan->supervisor_id =1;
                $plan->save();
            }
            catch (\Exception $exception){
                dd($row,$exception);
            }
        }
    }
}
