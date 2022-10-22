<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankBranch;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('pages.bank.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bank = Bank::create([
            'name'=>$request->name,
            'city_id'=>$request->city_id
        ]);
        foreach ($request->branchName as $i=> $name){
            BankBranch::create([
                'bank_id'=>$bank->id,
                'name'=>$name,
                'address'=>$request->branchAddress[$i],
                'code'=>$request->branchCode[$i]
            ]);
        }
        return redirect()->route('bank.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('pages.bank.create',compact('bank'));
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
        $bank = Bank::find($id)->update([
            'name'=>$request->name,
            'city_id'=>$request->city_id
        ]);
        BankBranch::where('bank_id',$id)->delete();
        foreach ($request->branchName as $i=> $name){
            BankBranch::create([
                'bank_id'=>$id,
                'name'=>$name,
                'address'=>$request->branchAddress[$i],
                'code'=>$request->branchCode[$i]
            ]);
        }
        return redirect()->route('bank.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bank::where('id',$id)->delete();
        return redirect()->back();
    }
}
