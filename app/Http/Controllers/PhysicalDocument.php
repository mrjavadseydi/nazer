<?php

namespace App\Http\Controllers;

use App\Models\PhysicalItems;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhysicalDocument extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $inputs = PhysicalItems::all();
        return view('pages.physicalDocument.index',compact('plan','inputs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->isAdmin)
            abort(403);
        DB::beginTransaction();
        try{
            DB::table('physical_item_values')->
                where('plan_id',$id)
                ->delete();
            $inputs = PhysicalItems::all();
            foreach ($inputs as $input){
                if ($request->filled($input->name)){
                    DB::table('physical_item_values')->insert([
                      'plan_id'=>$id,
                      'physical_items_id'=>$input->id,
                      'value'=>$request[$input['name']]
                    ]);
                }
            }
            DB::commit();
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


}
