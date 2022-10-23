<?php

namespace App\Http\Controllers;

use App\Models\Observe;
use Carbon\Carbon;
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
        $supervisor = $request->has('supervisor')? $request->supervisor : null;
        return Cache::remember('report13'.$supervisor, Carbon::now()->addDay(), function () use ($supervisor) {
            $observes  = Observe::query();
            if ($supervisor) {
                $observes = $observes->where('supervisor_id', $supervisor);
            }
            $observes = $observes->orderBy('id','desc')->with('plan','performer','supervisor')->get();

            return view('pages.report.index', compact('observes'))->render();
        });
    }
}
