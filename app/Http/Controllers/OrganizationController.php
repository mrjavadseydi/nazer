<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('pages.organizations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('pages.organizations.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $organization = new Organization();
        $organization->code = $request->code;
        $organization->title = $request->title;
        $organization->latitude = $request->latitude;
        $organization->longitude = $request->longitude;
        $organization->save();

        return redirect()->route('organizations.index');
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
        $organization = Organization::find($id);
        return view('pages.organizations.add', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::find($id);
        $organization->code = $request->code;
        $organization->title = $request->title;
        $organization->latitude = $request->latitude;
        $organization->longitude = $request->longitude;
        $organization->save();

        return redirect()->route('organizations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        Organization::find($id)->delete();
        return redirect()->route('organizations.index');
    }
}
