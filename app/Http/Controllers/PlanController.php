<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Document;
use App\Models\Employer;
use App\Models\Image;
use App\Models\Observe;
use App\Models\ObserveProblem;
use App\Models\Organization;
use App\Models\Performer;
use App\Models\Plan;
use App\Models\Suggest;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $data = $request->input();
        $hold = $request->has('hold')?1:0;
        $need_observe = $request->has('need_observe')?1:0;
        return view('pages.plans.index', compact('data','hold','need_observe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $organizations = Organization::all();
        $categories = Plan::groupBy('category')->pluck('category');
        return view('pages.plans.add', compact('organizations', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
        if ($request->filled('second_number')) {
            $performer->second_number = $performerInfo['second_number'];
        }
        $performer->gender = $performerInfo['gender'];
        $performer->under_support = $performerInfo['support'] == 'on';
        $performer->save();

        $plan = new Plan();
        $plan->title = $planInfo['title'];
        $plan->category = $planInfo['category'];
        $plan->organization_id = $planInfo['organization'];
        $plan->start_date = shamsi2miladi('Y/m/d', fa2en($performerInfo['start_date']));
        $plan->level = $planInfo['level'];
        $plan->address = $planInfo['address'];
        $plan->implement_method = $planInfo['implement_method'];
        $plan->performer_id = $performer->id;
        $plan->location_type = $planInfo['location_type'];
        $plan->supervisor_id = Supervisor::where('nationalityCode', $request->supervisor)->first()->id;
        $plan->save();

        return redirect()->route('plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::find($id);
        $organizations = Organization::all();
        $categories = Plan::groupBy('category')->pluck('category');
        return view('pages.plans.add', compact('organizations', 'categories','plan'));
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
        $performerInfo = $request->performer;
        $planInfo = $request->plan;

        $performer = Plan::find($id)->performer;
        $performer->firstName = $performerInfo['firstName'];
        $performer->lastName = $performerInfo['lastName'];
        $performer->nationalityCode = $performerInfo['nationalityCode'];
        $performer->birthday = $performerInfo['birthday'];

        $performer->phone = $performerInfo['phone'];
        if ($request->filled('second_number')) {
            $performer->second_number = $performerInfo['second_number'];
        }
        $performer->gender = $performerInfo['gender'];
        $performer->under_support = $performerInfo['support'] == 'on';
        $performer->save();

        $plan = Plan::find($id);
        $plan->title = $planInfo['title'];
        $plan->category = $planInfo['category'];
        $plan->organization_id = $planInfo['organization'];
        $plan->start_date = shamsi2miladi('Y/m/d', fa2en($performerInfo['start_date']));
        $plan->level = $planInfo['level'];
        $plan->address = $planInfo['address'];
        $plan->implement_method = $planInfo['implement_method'];
        $plan->performer_id = $performer->id;
        $plan->location_type = $planInfo['location_type'];
        $plan->save();

        return redirect()->route('plans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function observes($planID)
    {
        $plan = Plan::find($planID);
        if (!$plan)
            return redirect()->route('plans.index');

        $plan = $plan->load('organization');

        $observes = $plan->load('employers', 'areaCity')->observes()->with(['performer', 'plan'])->get()->map(function ($observe) {
            $observe->observe_date = miladi2shamsi('Y/m/d', $observe->observe_date);
            return $observe;
        });

        $planImages = Image::with('document')->where('plan_id', $planID)->get();
        $planDocuments = $planImages->map(function ($image) {
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

        DB::beginTransaction();

        try {
//        dd($request->employers);
            $courses = $request->courses;
            $suggests = $request->suggests;

            if ($courses) {
                $found_other = array_search('other', $courses);
                if ($found_other)
                    unset($courses[$found_other]);
            }

            if ($suggests) {
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
            if ($request->filled('description')) {
                $plan->description = $request->description;

            }
            if ($request->filled('location_type')) {
                $plan->location_type = $request->location_type;

            }
            if ($request->is_special == 'yes') {
                $plan->is_special = true;
                $plan->special_reason = $request->special_reason;
            }
            if ($request->is_exhibition == 'yes') {
                $plan->is_exhibition = true;
                $plan->exhibition_level = $request->exhibition_level;
                $plan->exhibition_desire = $request->exhibition_desire;
            }
            if ($request->has_employment == 'yes') {
                $plan->has_employment = true;
            }
            if ($request->filled('branch_id')) {
                $plan->branch_id = $request->branch_id;
            }
            if ($request->filled('bank_id')) {
                $plan->bank_id = $request->bank_id;
            }


            if ($request->filled('installment')) {
                $plan->installment = $request->installment;
            }
            if ($request->filled('loan_amount')) {
                $plan->loan_amount = $request->loan_amount;
            }
            if ($request->filled('loan_time')) {
                $plan->loan_time = shamsi2miladi('Y/m/d', fa2en($request->loan_time))->format('Y/m/d');
                //            dd($plan->loan_time);
            }

            $plan->save();

            $observe = Observe::where('plan_id', $plan->id)->whereDate('observe_date', $stringDate)->first();
            $found = true;
            if (!$observe) {
                $observe = new Observe();
                $found = false;
            }
            if (!$found)
                $observe->supervisor_id = Supervisor::where('nationalityCode', Auth::user()->nationalityCode)->first()->id;
            $observe->performer_id = $plan->performer->id;
            $observe->plan_id = $plan->id;
            $observe->observe_date = $date;
            $observe->monthly_charge = $request->monthly_charge;
            $observe->monthly_income = $request->monthly_income;
            $observe->net_worth = $request->net_worth;

            $observe->save();
            if ($request->has('problems')) {

                foreach ($request->problems as $problem) {
                    if (!ObserveProblem::where('observe_id', $observe->id)->where('problem_id', $problem)->first()) {
                        ObserveProblem::create([
                            'observe_id' => $observe->id,
                            'problem_id' => $problem
                        ]);
                    }
                }

                ObserveProblem::where('observe_id', $observe->id)->whereNotIn('problem_id', $request->problems)->delete();
            }
            foreach ($request->observe_files as $item) {
                $documentID = $item['document'];
                $document = $plan->documents()->find($documentID);
                if (isset($item['file'])) {
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

            if ($request->employers) {
                foreach ($request->employers as $emp) {
                    $employer = Employer::where([
                        ['nationalityCode', $emp['nationalityCode']],
                        ['plan_id', $planID]
                    ])->first();
                    if (!$employer)
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
            $plan = Plan::find($planID);
            $plan->next_observe = $plan->miladiNextObserve();
            $plan->save();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }

    public function doneObserves(Request $request)
    {
        $data = $request->input();
        return view('pages.observes.done', compact('data'));
    }

    public function holdPlan(Request $request, $id)
    {
        $plan = Plan::where('id', $id)->first();
        $plan->update([
            'on_hold' => $request->on_hold == 1,
            'hold_reason' => $request->hold_reason ?? " "
        ]);
        return redirect()->back();
    }
}
