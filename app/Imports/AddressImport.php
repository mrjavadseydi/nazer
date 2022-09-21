<?php

namespace App\Imports;

use App\Models\Performer;
use App\Models\Plan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AddressImport implements ToCollection
{
    public $columns, $emptyNationalityCode, $notFounded, $result;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->columns = $collection->first();
        $collection->forget(0);
        $this->emptyNationalityCode = [collect($this->columns)];


        foreach ($collection as $row) {
            try{
                $nationalityCode = (int)$row[0];
                /**
                 * ensure nationality code of current row is not empty.
                 */
                if( $nationalityCode == '' ){
                    $this->emptyNationalityCode[] = $row;
                    continue;
                }

                /**
                 * get all performers that not exists in database and store their to `notFounded` property of this class.
                 */
                $performer = Performer::with('plans')->where('nationalityCode', 'LIKE',"%{$nationalityCode}%")->first();
                if( !$performer ){
                    $this->notFounded[] = $row;
                    continue;
                }

//                $plan = $performer->plans->first();
//                array_push($this->result, [
//                    $nationalityCode, $row[1], $row[2], $plan->address, $plan->areaCity == null ? null : $plan->areaCity->area->title
//                ]);

                /**
                 * if excel address column is empty then move stored address (`address2`) to `address` column else put excel address into `address` column.
                 */
                $plan = $performer->plans()->first();
                if( $row[1] == '' ){
                    $plan->address = $plan->address2;
                    $plan->address2 = null;
                }
                else{
                    $plan->address = $row[1];
                }

                $plan->save();
            }
            catch (\ErrorException $exception){
                dd($exception);
            }

        }
    }
}
