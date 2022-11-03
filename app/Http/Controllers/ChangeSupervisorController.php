<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;

class ChangeSupervisorController extends Controller
{

    public function index($id){
        $supervisor = Supervisor::findOrFail($id);
        $supervisors = Supervisor::all();
        return view('pages.supervisors.change',compact('supervisor','supervisors'));
    }
    public function store(Request $request,$id){
        $request->validate([
            'supervisor'=>'required',
            'type'=>'required|in:1,2',
            'count'=>'required|numeric|min:1'
        ]);
        $supervisor = Supervisor::findOrFail($id);
        if ($request->type == 1) {
            $supervisor->plans()->limit($request->count)->update(['supervisor_id' => $request->supervisor]);
        }else{
            $supervisor->plans()->where('last_observe_date','!=',null)->limit($request->count)->update(['supervisor_id' => $request->supervisor]);
        }
        return redirect()->route('supervisors.index');
    }
}
