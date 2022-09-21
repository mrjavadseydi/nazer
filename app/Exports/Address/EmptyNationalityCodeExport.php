<?php

namespace App\Exports\Address;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmptyNationalityCodeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Session::get('addressEmptyNationalityCode'));
    }
}
