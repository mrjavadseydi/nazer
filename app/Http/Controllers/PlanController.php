<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Document;
use App\Models\Employer;
use App\Models\Image;
use App\Models\Observe;
use App\Models\Organization;
use App\Models\Performer;
use App\Models\Plan;
use App\Models\Suggest;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $data = $request->input();
        return view('pages.plans.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $organizations = Organization::all();
        $categories = Plan::groupBy('category')->pluck('category');
        return view('pages.plans.add', compact('organizations','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $performerInfo = $request->performer;
        $planInfo = $request->plan;

        $performer = new Performer();
        $performer->firstName = $performerInfo['firstName'];
        $performer->lastName = $performerInfo['lastName'];
        $performer->nationalityCode = $performerInfo['nationalityCode'];
        $performer->birthday = $performerInfo['birthday'];
        $performer->phone = $performerInfo['phone'];
        $performer->gender = $performerInfo['gender'];
        $performer->under_support = $performerInfo['support'] == 'on';
        $performer->save();

        $plan = new Plan();
        $plan->title = $planInfo['title'];
        $plan->category = $planInfo['category'];
        $plan->tags = $planInfo['tags'];
        $plan->organization_id = $planInfo['organization'];
//        $plan->distance = $planInfo['distance'];
        $plan->address = $planInfo['address'];
        $plan->implement_method = $planInfo['implement_method'];
        $plan->performer_id = $performer->id;
        $plan->supervisor_id = Supervisor::where('nationalityCode', $request->supervisor)->first()->id;
        $plan->save();

        return redirect()->route('plans.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function observes($planID)
    {
        $plan = Plan::find($planID);
        if( !$plan )
            return redirect()->route('plans.index');

        $plan = $plan->load('organization');

        $observes = $plan->load('employers', 'areaCity')->observes()->with(['performer', 'plan'])->get()->map( function ($observe){
            $observe->observe_date = miladi2shamsi('Y/m/d', $observe->observe_date);
            return $observe;
        } );

        $planImages = Image::with('document')->where('plan_id', $planID)->get();
        $planDocuments = $planImages->map(function ($image){
            return $image->document;
        });
//        $planDocuments = $plan->documents()->with('image')->get();
//        dd($planImages);
        $documents = Document::all()->diff($planDocuments);
        $courses = Course::all();
        $performerCourses = $plan->performer->courses;
        $planEmployers = $plan->employers;

        return view('pages.observes.add', compact('observes', 'plan', 'documents', 'planDocuments', 'courses', 'performerCourses', 'planImages', 'planEmployers'));
    }

    public function storeObserve(Request $request, $planID)
    {
//        dd($request->employers);
        $courses = $request->courses;
        $suggests = $request->suggests;

        if( $courses ){
            $found_other = array_search('other', $courses);
            if( $found_other )
                unset($courses[$found_other]);
        }

        if( $suggests ){
            foreach ($suggests as $suggest) {
                $suggestModel = new Suggest();
                $suggestModel->title = $suggest;
                $suggestModel->save();
            }
        }

        $now = now();
        $date = fa2en($request->observe_date);
        $expiration = shamsi2miladi('Y/m/d', $date);
        $expiration->addHours($now->hour);
        $expiration->addMinutes($now->minute);
        $date = $expiration->toDate();
        $stringDate = $date->format('Y/m/d');

        $plan = Plan::find($planID)->load(['supervisor', 'performer']);
        $plan->last_observe_date = $date;
        $plan->distance = $request->distance;
        $plan->latitude = $request->latitude;
        $plan->longitude = $request->longitude;
        if ($request->filled('description')){
            $plan->description = $request->description;

        }
        if( $request->is_special == 'yes' ){
            $plan->is_special = true;
            $plan->special_reason = $request->special_reason;
        }
        if( $request->is_exhibition == 'yes' ){
            $plan->is_exhibition = true;
            $plan->exhibition_level = $request->exhibition_level;
            $plan->exhibition_desire = $request->exhibition_desire;
        }
        if( $request->has_employment == 'yes' ){
            $plan->has_employment = true;
        }
        $plan->save();

        $observe = Observe::where('plan_id', $plan->id)->whereDate('observe_date', $stringDate)->first();
        if( !$observe )
            $observe = new Observe();

        $observe->supervisor_id = Supervisor::where('nationalityCode', Auth::user()->nationalityCode)->first()->id;
        $observe->performer_id = $plan->performer->id;
        $observe->plan_id = $plan->id;
        $observe->on_bpms = $request->on_bpms==1?true:false;

        $observe->observe_date = $date;
        $observe->save();

        foreach ($request->observe_files as $item) {
            $documentID = $item['document'];
            $document = $plan->documents()->find($documentID);

            if( !$document and isset($item['file']) ){
                $image = new Image();
                $image->url = upload($item['file']);
                $image->document_id = $documentID;
                $image->plan_id = $plan->id;
                $image->save();

                $plan->documents()->attach($documentID);;
            }
        }

        $performer = $plan->performer;
        $performer->need_course = $request->need_course == 'yes';
        $performer->courses()->sync($courses);
        $performer->save();

        if( $request->employers ){
            foreach ($request->employers as $emp){
                $employer = Employer::where([
                    ['nationalityCode', $emp['nationalityCode']],
                    ['plan_id', $planID]
                ])->first();
                if( !$employer )
                    $employer = new Employer();

                $employer->nationalityCode = $emp['nationalityCode'];
                $employer->fullName = $emp['fullName'];
                $employer->supportStatus = $emp['supportStatus'];
                $employer->phone = $emp['phone'];
                $employer->gender = $emp['gender'];
                $employer->paid_status = $emp['paid_status'];
                $employer->is_insured = $emp['is_insured'];
                $employer->start_date = shamsi2miladi('Y/m/d', fa2en($emp['start_date']));
                $employer->employer_status = $emp['employer_status'];
                $employer->plan_id = $planID;
                $employer->save();
            }
        }
    }

    public function doneObserves(Request $request)
    {
        $data = $request->input();
        return view('pages.observes.done', compact('data'));
    }
}
