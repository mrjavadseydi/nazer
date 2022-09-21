<?php

namespace App\Exports\Address;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;

class NotFoundExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Session::get('notFounded'));
    }
}
