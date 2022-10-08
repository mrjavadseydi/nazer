<?php

namespace App\Http\Controllers;

use App\Models\Observe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Report13Controller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $view = Cache::remember('report13', now()->addHours(24), function () {
            $observes  = Observe::orderBy('id','desc')->with('plan','performer','supervisor')->get();

            return view('pages.report.index', compact('observes'))->render();
        });
        return $view ;
    }
}
