<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Suggest;
use Illuminate\Http\Request;

class SuggestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('pages.suggests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        Suggest::find($id)->delete();
        return redirect()->route('suggests.index');
    }

    public function approve($id)
    {
        $suggest = Suggest::find($id);

        $course = new Course();
        $course->title = $suggest->title;
        $course->save();

        $suggest->delete();

        return redirect()->route('suggests.index');
    }
}
