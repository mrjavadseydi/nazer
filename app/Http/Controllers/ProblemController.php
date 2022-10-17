<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.problems.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Plan::groupBy('category')->pluck('category');

        return view('pages.problems.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'problem' => 'required',
            'plan_type' => 'required',
            'end_value' => 'required',
        ]);
        Problem::create([
            'problem' => $request->problem,
            'plan_type' => $request->plan_type,
            'end_value' => $request->end_value,
        ]);
        return redirect()->route('problem.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $problem = Problem::find($id);
        $categories = Plan::groupBy('category')->pluck('category');
        return view('pages.problems.create', compact('problem', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'problem' => 'required',
            'plan_type' => 'required',
            'end_value' => 'required',
        ]);
        $problem = Problem::find($id);
        $problem->update([
            'problem' => $request->problem,
            'plan_type' => $request->plan_type,
            'end_value' => $request->end_value,
        ]);
        return redirect()->route('problem.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $problem = Problem::find($id);
        $problem->delete();
        return redirect()->route('problem.index');
    }
}
