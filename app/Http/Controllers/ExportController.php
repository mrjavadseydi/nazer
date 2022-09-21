<?php

namespace App\Http\Controllers;

use App\Exports\Address\EmptyNationalityCodeExport;
use App\Exports\Address\NotFoundExport;
use App\Exports\DuplicatePlansExport;
use App\Exports\ErrorPlansExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function duplicates(Request $request)
    {
        return Excel::download(new DuplicatePlansExport, 'طرح های تکراری.xls');
    }

    public function errors(Request $request)
    {
        return Excel::download(new ErrorPlansExport, 'طرح های ثبت نشده.xls');
    }

    public function notFounded(Request $request)
    {
        return Excel::download(new NotFoundExport, 'مجریان ثبت نشده در سیستم.xls');
    }

    public function emptyNationalityCode(Request $request)
    {
        return Excel::download(new EmptyNationalityCodeExport, 'مجریان ثبت نشده در سیستم.xls');
    }
}
