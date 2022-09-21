<?php

namespace App\Http\Controllers;

use App\Exports\DuplicatePlansExport;
use App\Imports\AddressImport;
use App\Imports\AreaImport;
use App\Imports\PlanImport;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function plansForm(Request $request)
    {
        return view('pages.import.plans');
    }

    public function plansStore(Request $request)
    {
        Session::forget('duplicates');
        Session::forget('emptyNationalityCode');
        $planImport = new PlanImport;
        Excel::import($planImport, $request->file('file'));
        Session::put('duplicates', $planImport->duplicates);
        Session::put('emptyNationalityCode', $planImport->emptyNationalityCode);
    }

    public function addressesForm(Request $request)
    {
        return view('pages.import.addresses');
    }

    public function addressesStore(Request $request)
    {
        Session::forget('notFounded');
        Session::forget('addressEmptyNationalityCode');
        $addressImport = new AddressImport;
        Excel::import($addressImport, $request->file('file'));
        Session::put('notFounded', $addressImport->notFounded);
        Session::put('addressEmptyNationalityCode', $addressImport->emptyNationalityCode);
    }

    public function areasForm(Request $request)
    {
        return view('pages.import.areas');
    }

    public function areasStore(Request $request)
    {
//        Session::forget('notFounded');
//        Session::forget('addressEmptyNationalityCode');
        $areaImport = new AreaImport;
        Excel::import($areaImport, $request->file('file'));
//        Session::put('notFounded', $addressImport->notFounded);
//        Session::put('addressEmptyNationalityCode', $addressImport->emptyNationalityCode);
    }
}
