<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\City;
use Illuminate\Http\Request;

class BankBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('pages.bank_branch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        $banks = Bank::all();
        return view('pages.bank_branch.add',compact('cities','banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        BankBranch::create([
            'name'=>$request->name,
            'code'=>$request->code,
            'phone'=>$request->phone,
            'city_id'=>$request->city_id,
            'bank_id'=>$request->bank_id,
            'boss_name'=>$request->has('boss_name')?$request->boss_name:null,
            'boss_phone'=>$request->has('boss_phone')?$request->boss_phone:null,
            'address'=>$request->has('address')?$request->address:null,
            'description'=>$request->has('description')?$request->description:null,
        ]);
        return redirect()->route('branches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = City::all();
        $banks = Bank::all();
        $branch = BankBranch::find($id);
        return view('pages.bank_branch.add',compact('cities','banks','branch'));
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
        BankBranch::where('id',$id)->update([
            'name'=>$request->name,
            'code'=>$request->code,
            'phone'=>$request->phone,
            'city_id'=>$request->city_id,
            'bank_id'=>$request->bank_id,
            'boss_name'=>$request->has('boss_name')?$request->boss_name:null,
            'boss_phone'=>$request->has('boss_phone')?$request->boss_phone:null,
            'address'=>$request->has('address')?$request->address:null,
            'description'=>$request->has('description')?$request->description:null,
        ]);
        return redirect()->route('branches.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BankBranch::where('id',$id)->delete();
        return redirect()->back();
    }
}
