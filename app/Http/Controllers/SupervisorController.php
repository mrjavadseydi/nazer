<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('pages.supervisors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('pages.supervisors.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $supervisor = new Supervisor();
        $supervisor->fullName = $request->fullName;
        $supervisor->phone = $request->phone;
        $supervisor->nationalityCode = $request->nationalityCode;
        $supervisor->address = $request->address;
        $supervisor->save();

        $user = new User();
        $user->firstName = $request->fullName;
        $user->phone = $request->phone;
        $user->nationalityCode = $request->nationalityCode;
        $user->password = bcrypt($request->password);
        $user->role_id = 4;
        $user->save();

        return redirect()->route('supervisors.index');
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
     */
    public function edit($id)
    {
        $supervisor = Supervisor::find($id);
        return view('pages.supervisors.add', compact('supervisor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $supervisor = Supervisor::find($id);
        $supervisor->fullName = $request->fullName;
        $supervisor->phone = $request->phone;
        $supervisor->nationalityCode = $request->nationalityCode;
        $supervisor->address = $request->address;
        $supervisor->save();

        $user = User::find($id);
        if( !$user ){
            $user = new User();
            $user->password = bcrypt($request->nationalityCode);
            $user->role_id = 4;
        }
        $user->firstName = $request->fullName;
        $user->phone = $request->phone;
        $user->nationalityCode = $request->nationalityCode;
        if( $request->password != 'hide' and strlen($request->password) >= 8 )
            $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('supervisors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        Supervisor::find($id)->delete();
        return redirect()->route('supervisors.index');
    }
}
