<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\AreaCity;
use App\Models\City;
use App\Models\Performer;
use App\Models\Plan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AreaImport implements ToCollection
{
    public $columns, $emptyNationalityCode, $notFounded;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->columns = $collection->first();
        $collection->forget(0);
        $this->errors = $this->columns;
        $city = City::find(1);

        foreach ($collection as $index => $row) {
            $nationalityCode = (int)$row[0];
            $excelArea = $row[2];
//            $excelCityTitle = isset($row[2]) ? $row[2] : null; // Excel City
            $excelCityDescription = isset($row[3]) ? $row[3] : null; // Excel City
            try {
                /**
                 * to ensure nationality code of current row is not empty.
                 */
                if ($nationalityCode == '') {
                    $this->errors[] = $row;
                    continue;
                }

                /**
                 * get all performers that not exists in database and store their to `notFounded` property of this class.
                 */
                $performer = Performer::with('plans')->where('nationalityCode', 'LIKE','%'.$nationalityCode.'%')->first();
                if( !$performer ){
                    $this->notFounded[] = $row;
                    continue;
                }

                if( $excelArea ){
                    /**
                     * check the area exists or not. if not exists then store it to database else update it.
                     */
                    $area = Area::where('title', 'like', '%' . $excelArea . '%')->first();
                    if( !$area ){
                        $area = new Area();
                        $area->title = $excelArea;
                    }
                    if( $excelCityDescription )
                        $area->description = $excelCityDescription;
                    $area->save();

                    /**
                     * for use dynamic Cities in excel, uncomment this section and comment line 25
                     */
//                $city = $area->cities()->where('title', 'like', '%' . $excelCityTitle . '%');
//                if( !$city->first() ){
//                    $city->title = $excelCityTitle;
//                    $city->first()->save();
//                }
//                $city = $city->first();

                    /**
                     * attach area to plan
                     */
                    $areaCity = AreaCity::where([
                        ['area_id', $area->id],
                        ['city_id', $city->id]
                    ])->first();

                    if( !$areaCity )
                        $areaCity = new AreaCity();

                    $areaCity->city_id = $city->id;
                    $areaCity->area_id = $area->id;
                    $areaCity->save();

                    $plan = $performer->plans()->first();
                    $plan->area_city_id = $areaCity->id;
                    $plan->save();
                }
            }

            catch (\Error $exception){
                dd($row);
            }
        }
    }
}
