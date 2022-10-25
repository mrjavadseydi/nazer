@extends('layout.master')
@section('dashboard_page_title', 'ثبت بازدید')

@push('dashboard_extra_css')
    <link rel="stylesheet" href="{{ asset('/assets/css/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/leaflet-routing-machine.css') }}">
    <style>
        [data-repeater-item] {
            padding: 2em 0;
        }

        [data-repeater-item]:not(:last-child) {
            border-bottom: 2px solid #e9e9e9;
        }

        form strong {
            font-size: 18px;
        }

        .accordion.accordion-toggle-arrow .card .card-header .card-title:after {
            left: 2em !important;
            right: unset !important;
            font-size: 18px !important;
        }

        .accordion.accordion-toggle-arrow .card .card-header .card-title:after {
            transform: rotate(180deg);
        }

        .accordion.accordion-toggle-arrow .card .card-header .card-title.collapsed:after {
            transform: unset !important;
        }

        @media screen and (max-width: 600px) {
            button[type=submit] {
                position: fixed;
                bottom: 10px;
                z-index: 1;
                width: calc(100% - 50px);
                left: 25px;
            }

            #planDocuments .card-body > div {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            #showOnMap {
                display: none;
            }
        }
    </style>
@endpush

@section('dashboard_content')
    <div id="map" style="display: none"></div>
    {{--    <div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-xl" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-body">--}}
    {{--                    --}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="container-fluid">
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-header align-items-center">
                <h3 class="card-title text-right">طرح :
                    {{$plan->title }}</h3>
                {{--                <button id="showOnMap" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">--}}
                {{--                    مشاهده روی نقشه--}}
                {{--                </button>--}}
            </div>
            <div class="card-body">
                <div class="row text-right">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">کد ملی:
                                <strong>{{ $plan->performer->nationalityCode }}</strong></label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">نام و نام خانوادگی:
                                <strong>{{ $plan->performer->firstName }}
                                    {{ $plan->performer->lastName }}
                                </strong></label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">تلفن:
                                <strong>{{ $plan->performer->phone }}</strong></label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">تلفن ضروری:
                                <strong>{{ $plan->performer->second_phone }}</strong></label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">تحت پوشش کمیته امداد:
                                <strong>{{ $plan->performer->under_support ? ($plan->performer->under_support == '1' ? 'بله' : 'خیر') : '-' }}</strong></label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">محله:
                                @if(!is_null($plan->areaCity))
                                    <strong>{{ $plan->areaCity->area->title }}</strong>
                                @endif
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">آدرس: <strong>{{ $plan->address }}</strong></label>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">آدرس 2: <strong>{{ $plan->address2 }}</strong></label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">اداره:
                                <strong>{{ $plan->organization->title }}</strong></label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">سطح طرح: <strong>{{ $plan->level }}</strong></label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">وضعیت طرح: <strong>{{ $plan->status }}</strong></label>
                        </div>
                    </div>

                </div>
                <div class="col-12 text-right">
                    @if($plan->on_hold )
                        این برنامه دارای نقص / مشکل جهت بازرسری میبابد .
                        <br>
                        توضیحات :
                        {{ $plan->hold_reason }}
                        @if(auth()->user()->isAdmin )
                            <form action="{{route('report.problem',$plan->id)}}" method="post">
                                @csrf
                                <input type="hidden" class="form-control  mb-8" name="hold_reason" value=" ">
                                <input type="hidden" class="form-control  mb-8" name="on-hold" value="0">
                                <div class="col-md-2 col-sm-12">
                                    <button type="submit" class="btn btn-primary">
                                        مشکل رفع شد
                                    </button>

                                </div>
                            </form>
                        @endif
                    @endif


                </div>
            </div>
            <!--end::Body-->
        </div>
        @if(!$plan->on_hold)
            <form id="nezarat" action="{{ route('observes.store', $plan->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <h3 class="card-title"><strong>ثبت بازدید</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-right border-bottom border-bottom-light-light mb-8">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>تاریخ بازدید</strong></label>
                                    <input type="text" class="form-control persianDate mb-8" name="observe_date">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>موقعیت مکانی</strong></label>
                                    <div class="row align-items-start">
                                        <div class="form-group col-lg-4">
                                            <input type="text" class="form-control" id="latitude" name="latitude"
                                                   value="{{ $plan->latitude }}">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <input type="text" class="form-control" id="longitude" name="longitude"
                                                   value="{{ $plan->longitude }}">
                                        </div>
                                        <div class="col-lg-4">
                                            <button class="btn btn-primary" type="button" onclick="getLocation()">دریافت
                                                لوکیشن
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>فاصله اداره تا موقعیت طرح (برحسب
                                            کیلومتر)</strong></label>
                                    <div class="d-flex">
                                        <input type="number" inputmode="numeric" class="form-control" id="distance"
                                               name="distance"
                                               value="{{ $plan->distance }}">
                                        <button class="btn btn-primary mr-4" type="button" id="calcDistance"
                                                onclick="calculateDistance(this)" data-p1-lat="{{ $plan->latitude }}"
                                                data-p1-lng="{{ $plan->longitude }}"
                                                data-p2-lat="{{ $plan->organization->latitude }}"
                                                data-p2-lng="{{ $plan->organization->longitude }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>هزینه ماهانه
                                        </strong>
                                        (
                                        <span id="monthly_charge"></span>
                                        ریال)

                                    </label>
                                    <input type="number" required step="10000000" class="form-control  mb-8"
                                           inputmode="numeric" min="0" name="monthly_charge"
                                           value="{{last_observe_value($plan->id,"monthly_charge")}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>درامد خالص ماهانه
                                        </strong>
                                        (
                                        <span id="monthly_income"></span>
                                        ریال)
                                    </label>
                                    <input type="number" required step="10000000" class="form-control  mb-8"
                                           inputmode="numeric" min="0" name="monthly_income"
                                           value="{{last_observe_value($plan->id,"monthly_income")}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>ارزش سرمایه فعلی
                                        </strong>
                                        (
                                        <span id="net_worth"></span>
                                        ریال)
                                    </label>
                                    <input type="number" required step="10000000" class="form-control  mb-8"
                                           inputmode="numeric" min="0" name="net_worth"
                                           value="{{last_observe_value($plan->id,"net_worth")}}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="start_date" class="form-label"><strong>تاریخ
                                            تسهیلات</strong></label>
                                    <input type="text" class="form-control persianDate"
                                           name="loan_time"

                                           @if($plan->loan_time ) value="{{$plan->loan_time}}" @endif
                                           id="start_date">
                                </div>
                            </div>
                            {{--                        <div class="col-lg-6 col-sm-12">--}}
                            {{--                            <div class="form-group">--}}
                            {{--                                <label for="" class="form-label"><strong>مشکلات طرح</strong></label>--}}
                            {{--                                <select name="problems[]" class="custom-select form-control select2-generate"--}}
                            {{--                                        id="problems" multiple="multiple">--}}
                            {{--                                    @foreach( \App\Models\Problem::where('plan_type',$plan->category)->get() as $problem )--}}
                            {{--                                        <option value="{{ $problem->id }}" {{has_problem($plan->id,$problem->id)?"selected":""}}>{{ $problem->problem }}</option>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </select>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            {{--                            @if(auth()->user()->isAdmin)--}}
                            {{--                                @dd($plan->category)--}}
                            {{--                                @endif--}}
                            <livewire:bank-branche-select :plan_id="$plan->id"/>

                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>مبلغ وام
                                        </strong>
                                        (
                                        <span id="loan_amount"></span>
                                        ریال)
                                    </label>
                                    <input type="number" required step="10000000" class="form-control  mb-8"
                                           inputmode="numeric" min="0" name="loan_amount"
                                           value="{{$plan->loan_amount??0}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>مبلغ قسط
                                        </strong>
                                        (
                                        <span id="installment"></span>
                                        ریال)
                                    </label>
                                    <input type="number" required step="500000" class="form-control  mb-8"
                                           inputmode="numeric" min="0" name="installment"
                                           value="{{$plan->installment??0}}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>نیاز به آموزش</strong></label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="need_course" value="yes"
                                                   @if( $plan->performer->need_course ) checked
                                                   @endif data-need-courses/>
                                            <span class="mr-0 ml-2"></span>
                                            دارد
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="need_course" value="no"
                                                   @if( !$plan->performer->need_course ) checked
                                                   @endif data-need-courses/>
                                            <span class="mr-0 ml-2"></span>
                                            ندارد
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6" @if( !$plan->performer->need_course ) style="display: none"
                                 @endif data-courses>
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>مشخص کردن دوره ها</strong></label>
                                    <select name="courses[]" class="custom-select form-control select2-generate"
                                            id="courses" multiple="multiple">
                                        @foreach( $performerCourses as $course )
                                            <option value="{{ $course->id }}" selected>{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6" style="display: none" data-suggest-course>
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>پیشنهاد دوره</strong></label>
                                    <select name="suggests[]" class="custom-select form-control select2-generate"
                                            id="suggests" multiple="multiple">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row text-right border-bottom border-bottom-light-light mb-8">
                            <div class="col-lg-4 col-sm-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>طرح سوژه و ویژه می باشد؟</strong></label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="is_special" value="yes"
                                                   @if( $plan->is_special ) checked @endif data-is-special/>
                                            <span class="mr-0 ml-2"></span>
                                            بله
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="is_special" value="no"
                                                   @if( !$plan->is_special ) checked @endif data-is-special/>
                                            <span class="mr-0 ml-2"></span>
                                            خیر
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-sm-6" @if( !$plan->is_special ) style="display: none"
                                 @endif data-special-resaon>
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>دلیل و کار شاخص طرح</strong></label>
                                    <textarea name="special_reason" rows="3"
                                              class="form-control">{{ $plan->special_reason }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row text-right border-bottom border-bottom-light-light mb-8">
                            <div class="col-lg-4 col-sm-6">
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>ویژگی نمایشگاهی</strong></label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="is_exhibition" value="yes"
                                                   @if( $plan->is_exhibition ) checked @endif data-is-exhibition/>
                                            <span class="mr-0 ml-2"></span>
                                            دارد
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="is_exhibition" value="no"
                                                   @if( !$plan->is_exhibition ) checked @endif data-is-exhibition/>
                                            <span class="mr-0 ml-2"></span>
                                            ندارد
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group ">
                                    <label for="" class="form-label">نوع مکان طرح</label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" {{$plan->location_type=="شهری"?"checked":""}}  name="location_type"
                                                   value="شهری"/>
                                            <span class="mr-0 ml-2"></span>
                                            شهری
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="location_type"
                                                   {{$plan->location_type=="روستایی"?"checked":""}}  value="روستایی"/>
                                            <span class="mr-0 ml-2"></span>
                                            روستایی
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6" @if( !$plan->is_exhibition ) style="display: none"
                                 @endif data-exhibition-level>
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>سطح نمایشگاهی</strong></label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="exhibition_level" value="شهرستانی"
                                                   @if( $plan->exhibition_level == 'شهرستانی' ) checked @endif/>
                                            <span class="mr-0 ml-2"></span>
                                            شهرستانی
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="exhibition_level" value="استانی"
                                                   @if( $plan->exhibition_level == 'استانی' ) checked @endif/>
                                            <span class="mr-0 ml-2"></span>
                                            استانی
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="exhibition_level" value="کشوری"
                                                   @if( $plan->exhibition_level == 'کشوری' ) checked @endif/>
                                            <span class="mr-0 ml-2"></span>
                                            کشوری
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6" @if( !$plan->is_exhibition ) style="display: none"
                                 @endif data-exhibition-desire>
                                <div class="form-group">
                                    <label for="" class="form-label"><strong>تمایل مجری</strong></label>
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="exhibition_desire" value="کم"
                                                   @if( $plan->exhibition_desire == 'کم' ) checked @endif/>
                                            <span class="mr-0 ml-2"></span>
                                            کم
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="exhibition_desire" value="متوسط"
                                                   @if( $plan->exhibition_desire == 'متوسط' ) checked @endif/>
                                            <span class="mr-0 ml-2"></span>
                                            متوسط
                                        </label>
                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                            <input type="radio" name="exhibition_desire" value="زیاد"
                                                   @if( $plan->exhibition_desire == 'زیاد' ) checked @endif/>
                                            <span class="mr-0 ml-2"></span>
                                            زیاد
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-right">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="" class="form-label"><strong>اشتغال زایی به جز
                                                    مجری</strong></label>
                                            <div class="radio-inline">
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="has_employment" value="yes"
                                                           @if( $plan->has_employment ) checked
                                                           @endif data-has-employer/>
                                                    <span class="mr-0 ml-2"></span>
                                                    دارد
                                                </label>
                                                <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                    <input type="radio" name="has_employment" value="no"
                                                           @if( !$plan->has_employment ) checked
                                                           @endif data-has-employer/>
                                                    <span class="mr-0 ml-2"></span>
                                                    ندارد
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" @if( !$plan->has_employment ) style="display: none"
                                     @endif data-employers>
                                    <div class="accordion accordion-toggle-arrow w-100 text-right" id="employers">
                                        @forelse($planEmployers as $employer)
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title collapsed" data-toggle="collapse"
                                                         data-target="#employers{{ $employer->id }}">
                                                        {{ $employer->fullName }}
                                                    </div>
                                                </div>
                                                <div id="employers{{ $employer->id }}" class="collapse"
                                                     data-parent="#employers">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-sm-4 col-xs-5">
                                                                <div class="form-group">
                                                                    <label for="nationalityCode"><strong>کد
                                                                            ملی</strong></label>
                                                                    <input type="text" class="form-control"
                                                                           name="employers[{{ $employer->id }}][nationalityCode]"
                                                                           value="{{ $employer->nationalityCode }}"
                                                                           id="nationalityCode" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="fullName" class="form-label"><strong>نام
                                                                            خانوادگی</strong></label>
                                                                    <input type="text" class="form-control"
                                                                           name="employers[{{ $employer->id }}][fullName]"
                                                                           value="{{ $employer->fullName }}"
                                                                           id="fullName"
                                                                           oninput="changeAccordionTitle(this)">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="supportStatus"
                                                                           class="form-label"><strong>وضعیت
                                                                            مددجویی</strong></label>
                                                                    <select name="employers[{{ $employer->id }}][supportStatus]"
                                                                            id="supportStatus" class="form-control">
                                                                        <option value="مددجو"
                                                                                @if( $employer->supportStatus == 'مددجو' ) selected @endif>
                                                                            مددجو
                                                                        </option>
                                                                        <option value="غیر مددجو"
                                                                                @if( $employer->supportStatus == 'غیر مددجو' ) selected @endif>
                                                                            غیر مددجو
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="phone" class="form-label"><strong>شماره
                                                                            تماس</strong></label>
                                                                    <input type="text" class="form-control"
                                                                           name="employers[{{ $employer->id }}][phone]"
                                                                           value="{{ $employer->phone }}" id="phone">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="employer_status"
                                                                           class="form-label"><strong>وضعیت
                                                                            شاغل در طرح</strong></label>
                                                                    <input type="text" class="form-control"
                                                                           name="employers[{{ $employer->id }}][employer_status]"
                                                                           value="{{ $employer->employer_status }}"
                                                                           id="employer_status">
                                                                    <select name="employers[{{ $employer->id }}][employer_status]"
                                                                            id="employer_status" class="form-control">
                                                                        <option value="تمام وقت"
                                                                                @if( $employer->employer_status == 'تمام وقت' ) selected @endif>
                                                                            تمام وقت
                                                                        </option>
                                                                        <option value="پاره وقت"
                                                                                @if( $employer->employer_status == 'پاره وقت' ) selected @endif>
                                                                            پاره وقت
                                                                        </option>
                                                                        <option value="ساعتی"
                                                                                @if( $employer->employer_status == 'ساعتی' ) selected @endif>
                                                                            ساعتی
                                                                        </option>
                                                                        <option value="موردی"
                                                                                @if( $employer->employer_status == 'موردی' ) selected @endif>
                                                                            موردی
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="start_date" class="form-label"><strong>تاریخ
                                                                            شروع</strong></label>
                                                                    <input type="text" class="form-control persianDate"
                                                                           name="employers[{{ $employer->id }}][start_date]"
                                                                           value="{{ $employer->start_date }}"
                                                                           id="start_date">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="gender"
                                                                           class="form-label"><strong>جنسیت</strong></label>
                                                                    <div class="radio-inline" id="gender">
                                                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                                            <input type="radio"
                                                                                   name="employers[{{ $employer->id }}][gender]"
                                                                                   value="male" {{ $employer->gender == 'male' ? 'checked="checked"' : '' }}/>
                                                                            <span class="mr-0 ml-2"></span>
                                                                            مرد
                                                                        </label>
                                                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                                            <input type="radio"
                                                                                   name="employers[{{ $employer->id }}][gender]"
                                                                                   value="female" {{ $employer->gender == 'female' ? 'checked="checked"' : '' }}/>
                                                                            <span class="mr-0 ml-2"></span>
                                                                            زن
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="paid_status" class="form-label"><strong>وضعیت
                                                                            مزد بگیری</strong></label>
                                                                    <div class="radio-inline" id="paid_status">
                                                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                                            <input type="radio"
                                                                                   name="employers[{{ $employer->id }}][paid_status]"
                                                                                   value="employedWithSalary" {{ $employer->paid_status == 'employedWithSalary' ? 'checked="checked"' : '' }}/>
                                                                            <span class="mr-0 ml-2"></span>
                                                                            شاغل مزد بگیر
                                                                        </label>
                                                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                                            <input type="radio"
                                                                                   name="employers[{{ $employer->id }}][paid_status]"
                                                                                   value="familyWithoutSalary" {{ $employer->paid_status == 'familyWithoutSalary' ? 'checked="checked"' : '' }}/>
                                                                            <span class="mr-0 ml-2"></span>
                                                                            کارکنان خانوادگی بدون مزد
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="is_insured"
                                                                           class="form-label"><strong>بیمه</strong></label>
                                                                    <div class="radio-inline" id="is_insured">
                                                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                                            <input type="radio"
                                                                                   name="employers[{{ $employer->id }}][is_insured]"
                                                                                   value="yes" {{ $employer->is_insured == '1' ? 'checked="checked"' : '' }}/>
                                                                            <span class="mr-0 ml-2"></span>
                                                                            دارد
                                                                        </label>
                                                                        <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                                            <input type="radio"
                                                                                   name="employers[{{ $employer->id }}][is_insured]"
                                                                                   value="no" {{ $employer->is_insured == '0' ? 'checked="checked"' : '' }}/>
                                                                            <span class="mr-0 ml-2"></span>
                                                                            ندارد
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @empty
                                            {{--                                        <div class="card">--}}
                                            {{--                                            <div class="card-header">--}}
                                            {{--                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#employers0">--}}
                                            {{--                                                    نام و نام خانوادگی--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div id="employers0" class="collapse" data-parent="#employers">--}}
                                            {{--                                                <div class="card-body">--}}
                                            {{--                                                    <div class="row">--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4 col-xs-5">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="nationalityCode"><strong>کد ملی</strong></label>--}}
                                            {{--                                                                <input type="text" class="form-control" name="employers[0][nationalityCode]" id="nationalityCode" required>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="firstName" class="form-label"><strong>نام</strong></label>--}}
                                            {{--                                                                <input type="text" class="form-control" name="employers[0][firstName]" id="firstName" oninput="changeAccordionTitle(this)">--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="lastName" class="form-label"><strong>نام خانوادگی</strong></label>--}}
                                            {{--                                                                <input type="text" class="form-control" name="employers[0][lastName]" id="lastName" oninput="changeAccordionTitle(this)">--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="supportStatus" class="form-label"><strong>وضعیت مددجویی</strong></label>--}}
                                            {{--                                                                <input type="text" class="form-control" name="employers[0][supportStatus]" id="supportStatus">--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="phone" class="form-label"><strong>شماره تماس</strong></label>--}}
                                            {{--                                                                <input type="text" class="form-control" name="employers[0][phone]" id="phone">--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="employer_status" class="form-label"><strong>وضعیت شاغل در طرح</strong></label>--}}
                                            {{--                                                                <input type="text" class="form-control" name="employers[0][employer_status]" id="employer_status">--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="gender" class="form-label"><strong>جنسیت</strong></label>--}}
                                            {{--                                                                <div class="radio-inline" id="gender">--}}
                                            {{--                                                                    <label class="radio radio-outline radio-primary mr-0 ml-4">--}}
                                            {{--                                                                        <input type="radio" name="employers[0][gender]" value="male"/>--}}
                                            {{--                                                                        <span class="mr-0 ml-2"></span>--}}
                                            {{--                                                                        مرد--}}
                                            {{--                                                                    </label>--}}
                                            {{--                                                                    <label class="radio radio-outline radio-primary mr-0 ml-4">--}}
                                            {{--                                                                        <input type="radio" name="employers[0][gender]" value="female"/>--}}
                                            {{--                                                                        <span class="mr-0 ml-2"></span>--}}
                                            {{--                                                                        زن--}}
                                            {{--                                                                    </label>--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="paid_status" class="form-label"><strong>وضعیت مزد بگیری</strong></label>--}}
                                            {{--                                                                <div class="radio-inline" id="paid_status">--}}
                                            {{--                                                                    <label class="radio radio-outline radio-primary mr-0 ml-4">--}}
                                            {{--                                                                        <input type="radio" name="employers[0][paid_status]" value="employedWithSalary"/>--}}
                                            {{--                                                                        <span class="mr-0 ml-2"></span>--}}
                                            {{--                                                                        شاغل مزد بگیر--}}
                                            {{--                                                                    </label>--}}
                                            {{--                                                                    <label class="radio radio-outline radio-primary mr-0 ml-4">--}}
                                            {{--                                                                        <input type="radio" name="employers[0][paid_status]" value="familyWithoutSalary"/>--}}
                                            {{--                                                                        <span class="mr-0 ml-2"></span>--}}
                                            {{--                                                                        کارکنان خانوادگی بدون مزد--}}
                                            {{--                                                                    </label>--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="is_insured" class="form-label"><strong>بیمه</strong></label>--}}
                                            {{--                                                                <div class="radio-inline" id="is_insured">--}}
                                            {{--                                                                    <label class="radio radio-outline radio-primary mr-0 ml-4">--}}
                                            {{--                                                                        <input type="radio" name="employers[0][is_insured]" value="yes"/>--}}
                                            {{--                                                                        <span class="mr-0 ml-2"></span>--}}
                                            {{--                                                                        دارد--}}
                                            {{--                                                                    </label>--}}
                                            {{--                                                                    <label class="radio radio-outline radio-primary mr-0 ml-4">--}}
                                            {{--                                                                        <input type="radio" name="employers[0][is_insured]" value="no"/>--}}
                                            {{--                                                                        <span class="mr-0 ml-2"></span>--}}
                                            {{--                                                                        ندارد--}}
                                            {{--                                                                    </label>--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <div class="col-lg-4 col-sm-4">--}}
                                            {{--                                                            <div class="form-group">--}}
                                            {{--                                                                <label for="start_date" class="form-label"><strong>تاریخ شروع</strong></label>--}}
                                            {{--                                                                <input type="text" class="form-control persianDate" name="employers[0][start_date]" id="start_date">--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{--                                        </div>--}}
                                        @endforelse
                                    </div>
                                    <button class="btn btn-primary mt-4" type="button" onclick="addEmployer()">اضافه
                                        کردن
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="form-group text-right">
                                    <p for="" class="form-label text-right pt-3"><strong>مشکلات طرح</strong></p>
                                    <div class="radio-inline">
                                        @foreach( \App\Models\Problem::where('plan_type',$plan->category)->get() as $problem )
                                            <div class="d-block">
                                                <label class="mb-0 p-2 mt-1"
                                                       for="{{ $problem->id }}problem">{{$problem->problem}}

                                                </label>
                                                <input type="checkbox" class="p-2" name="problems[]"
                                                       {{has_problem($plan->id,$problem->id)?"checked":""}}  value="{{ $problem->id }}"
                                                       id="{{ $problem->id }}problem">

                                                @if(!$loop->last)
                                                    <span class="mt-1 p-2">|</span>
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div style="width: 100%" class="form repeater-default row align-items-center">
                                        <div class="col-lg-11">
                                            <div style="width: 100%" data-repeater-list="observe_files">
                                                <div data-repeater-item>
                                                    <div class="row justify-content-between align-items-end text-right">
                                                        <div class="col-lg-4 col-sm-5 col-xs-5">
                                                            <label for="document"><strong>نوع مدرک</strong></label>
                                                            <select name="document" id="document" class="form-control"
                                                                    required>
                                                                @foreach($documents as $document)
                                                                    <option value="{{ $document->id }}">{{ $document->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-4 col-sm-5 col-xs-5">
                                                            <label for="" class="form-label"><strong>بارگزاری
                                                                    فایل</strong></label>
                                                            <input type="file" name="file"
                                                                   accept="image/*;capture=camera">
                                                        </div>

                                                        <div class="col-lg-2 col-sm-2 col-xs-2">
                                                            <button class="btn btn-danger" data-repeater-delete
                                                                    type="button">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <button class="btn btn-primary d-flex" type="button" data-repeater-create>
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div style="width: 100%" class="form repeater-default row align-items-center">
                                            <label for="" class="form-label"><strong>توضیحات</strong></label>
                                            <textarea name="description" rows="3"
                                                      class="form-control">{{ $plan->description }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">ثبت بازدید</button>
                    </div>
                </div>
            </form>
        @endif

        <div class="card card-custom gutter-b" id="planDocuments">
            <div class="card-header">
                <h3 class="card-title">مدارک آپلود شده</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px">
                    @foreach($planImages as $image)
                        <livewire:plan-document :item="$image"/>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-right">
            <h3 class="text-xl mt-10"><strong>بازدید های ثبت شده</strong></h3>
            <livewire:observes planid="{{ $plan->id }}"/>
        </div>
    </div>
@endsection

@push('dashboard_extra_js')
    <script src="{{ asset('/assets/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('/assets/js/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('/assets/js/compressor.min.js') }}"></script>
    <script src="{{ asset('/assets/js/leaflet.js') }}"></script>
    <script src="{{ asset('/assets/js/leaflet-routing-machine.js') }}"></script>
    <script src="{{ asset('/assets/js/num2persian.js') }}"></script>
    <script>
        let net_worth_inp = document.getElementsByName('net_worth')[0];
        if (net_worth_inp.value > 0) {
            document.getElementById('net_worth').innerText = (net_worth_inp.value).num2persian();
        }


        let monthly_charge = document.getElementsByName('monthly_charge')[0];
        if (monthly_charge.value > 0) {
            document.getElementById('monthly_charge').innerText = (monthly_charge.value).num2persian();
        }


        let monthly_income = document.getElementsByName('monthly_income')[0];
        if (net_worth_inp.value > 0) {
            document.getElementById('monthly_income').innerText = (monthly_income.value).num2persian();
        }


        let installment = document.getElementsByName('installment')[0];
        if (installment.value > 0) {
            document.getElementById('installment').innerText = (installment.value).num2persian();
        }


        let loan_amount = document.getElementsByName('loan_amount')[0];
        if (installment.value > 0) {
            document.getElementById('loan_amount').innerText = (loan_amount.value).num2persian();
        }

        monthly_income.addEventListener('change', function (e) {
            document.getElementById('monthly_income').innerText = (e.target.value).num2persian();
        });
        net_worth_inp.addEventListener('change', function (e) {
            document.getElementById('net_worth').innerText = (e.target.value).num2persian();
        });
        monthly_charge.addEventListener('change', function (e) {
            document.getElementById('monthly_charge').innerText = (e.target.value).num2persian();
        });
        monthly_income.addEventListener('keyup', function (e) {
            document.getElementById('monthly_income').innerText = (e.target.value).num2persian();
        });
        net_worth_inp.addEventListener('keyup', function (e) {
            document.getElementById('net_worth').innerText = (e.target.value).num2persian();
        });
        monthly_charge.addEventListener('keyup', function (e) {
            document.getElementById('monthly_charge').innerText = (e.target.value).num2persian();
        });


        loan_amount.addEventListener('keyup', function (e) {
            document.getElementById('loan_amount').innerText = (e.target.value).num2persian();
        });
        installment.addEventListener('keyup', function (e) {
            document.getElementById('installment').innerText = (e.target.value).num2persian();
        });
        loan_amount.addEventListener('change', function (e) {
            document.getElementById('loan_amount').innerText = (e.target.value).num2persian();
        });
        installment.addEventListener('change', function (e) {
            document.getElementById('installment').innerText = (e.target.value).num2persian();
        });


        document.querySelectorAll('[data-remove]').forEach(item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    title: 'حذف',
                    text: 'آیا از حذف کردن این نظارت اطمینان دارید؟',
                    icon: 'question',
                    confirmButtonText: 'بله',
                    showCancelButton: true,
                    cancelButtonText: 'خیر'
                }).then(result => {
                    if (result.isConfirmed) {
                        item.closest('div').querySelector('form').submit();
                    }
                });
            });
        })
    </script>
    <script>
        window.addEventListener('swal', function (e) {
            Swal.fire(e.detail).then(result => {
                if (result.isConfirmed) {
                    Livewire.emit('remove', e.detail.documentId, '{{ $plan->id }}')
                }
            });
        });

        window.addEventListener('swal-result', function (e) {
            Swal.fire(e.detail);
            location.reload();
        });
    </script>
    <script>
        let documentsFormData = new FormData();
        documentsFormData.append('observe_files[0][document]', '{{ $documents->first()->id }}');

        var mapOptions = {
            center: [32.8733, 59.2163],
            zoom: 5
        }

        var map = new L.map('map', mapOptions);
        var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        map.addLayer(layer);

        $(document).on('change', 'input[type=file], [data-repeater-item] #document', event => {
            if (event.target.tagName === 'INPUT') {
                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                var reader = new FileReader();
                reader.onload = function () {
                    let img = document.createElement('img');
                    img.src = reader.result;
                    img.onload = function () {
                        const quality = 50;
                        const output_format = 'jpg';
                        let compressed = compress(img, quality, output_format);

                        var base64data = compressed.src.replace("data:image/jpeg;base64,", "");
                        var bs = atob(base64data);
                        var buffer = new ArrayBuffer(bs.length);
                        var ba = new Uint8Array(buffer);
                        for (var i = 0; i < bs.length; i++) {
                            ba[i] = bs.charCodeAt(i);
                        }
                        var blob = new Blob([ba], {type: "image/png"});
                        // showBlobFile(blob);
                        refreshFormData(event.target, true, blob);
                    }
                }

                reader.readAsDataURL(event.target.files[0])
            } else {
                refreshFormData(event.target, false);
            }
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "این مرورگر نمی تواند موقعیت فعلی شما را پیدا کند";
            }
        }

        function showPosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            document.querySelector('#latitude').value = latitude;
            document.querySelector('#longitude').value = longitude;

            document.querySelector('#calcDistance').setAttribute('data-p1-lat', latitude);
            document.querySelector('#calcDistance').setAttribute('data-p1-lng', longitude);

            calculateDistance(document.querySelector('#calcDistance'))
        }

        function calculateDistance(element) {
            let p2Lat = element.getAttribute('data-p2-lat');
            let p2Lng = element.getAttribute('data-p2-lng');

            if (p2Lat === '' || p2Lng === '') {
                Swal.fire({
                    title: 'خطا',
                    text: 'موقعیت مکانی اداره مشخص نشده است. لطفا به واحد اشتغال اطلاع دهید',
                    icon: 'error',
                    submitButtonText: 'بله'
                })
                return;
            }

            let p1Lat = element.getAttribute('data-p1-lat');
            let p1Lng = element.getAttribute('data-p1-lng');

            if (p1Lat === '' || p1Lng === '') {
                Swal.fire({
                    title: 'خطا',
                    text: 'ابتدا موقعیت مکانی طرح را مشخص کنید',
                    icon: 'error',
                    submitButtonText: 'بله'
                })
                return;
            }

            let routing = L.Routing.control({
                waypoints: [
                    L.latLng(p1Lat, p1Lng),
                    L.latLng(p2Lat, p2Lng)
                ]
            }).addTo(map);

            routing.on('routeselected', function (e) {
                var route = e.route
                document.querySelector('#distance').value = Math.round(route.summary.totalDistance / 1000);
            })
        }

        document.querySelector('#nezarat').addEventListener('submit', e => {
            e.preventDefault();
            let formData = new FormData(document.querySelector('#nezarat'));
            for (const pair of documentsFormData.entries()) {
                formData.append(pair[0], pair[1]);
            }

            Swal.fire({
                title: 'ذخیره',
                text: 'آیا از ثبت نظارت اطمینان دارد؟',
                icon: 'question',
                confirmButtonText: 'بله',
                showCancelButton: true,
                cancelButtonText: 'خیر',
            }).then(result => {
                if (result.isConfirmed) {
                    let waitingDialog = Swal.fire({
                        title: 'در حال آپلود عکس ها . لطفا صبر کنید ...',
                        icon: 'info',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('observes.store', $plan->id) }}",
                        data: formData,
                        type: "POST",
                        contentType: false,
                        processData: false,
                        cache: false,
                        dataType: "json",
                        error: function (xhr, status, error) {
                            waitingDialog.close();
                            Swal.fire({
                                title: 'بازدید با موفقیت ثبت شد',
                                icon: 'success',
                            }).then(result => {
                                window.location.href = '{{ route('plans.index') }}'
                            });
                        },
                        success: function (data) {
                            waitingDialog.close();
                            Swal.fire({
                                title: 'بازدید با موفقیت ثبت شد',
                                icon: 'success',
                            }).then(result => {
                                window.location.href = '{{ route('plans.index') }}'
                            });
                        },
                        complete: function () {
                            return true;
                        }
                    });
                }
            });
        })

        function setDatePicker(item = null) {
            let dateItem;

            console.log(item);

            if (item) {
                dateItem = $(item.querySelector('.persianDate'));
            } else {
                dateItem = $(".persianDate");
            }

            dateItem.pDatepicker({
                format: 'YYYY/MM/DD'
            });
        }

        $(document).ready(function () {
            setDatePicker();

            $('#exampleModalLong').on('show.bs.modal', function () {
                // console.log('test test');
                const resizeObserver = new ResizeObserver(() => {
                    console.log('worked')
                    map.invalidateSize();
                    map.options.zoom = 8;
                });

                resizeObserver.observe(document.querySelector('#map'));
            });

            $('.repeater-default').repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    Swal.fire({
                        title: 'حذف',
                        text: "از حذف کردن این فایل اطمینان دارید؟",
                        showDenyButton: true,
                        confirmButtonText: 'خیر',
                        denyButtonText: `بله`,
                        focusConfirm: true
                    }).then(result => {
                        if (result.isDenied) {
                            $(this).slideUp(deleteElement);
                        }
                    });
                }
            });

            let coursesSelect2 = $('#courses').select2({
                ajax: {
                    url: '{{ route('api.courses.index') }}',
                    dataType: 'json'
                },
            });
            let problemsSelect2 = $('#problems').select2({});

            let suggestsSelect2 = $('#suggests').select2({
                tags: true
            });


            coursesSelect2.on('select2:select', e => {
                let data = e.params.data;
                if (data.id === 'other') {
                    let suggests = $('[data-suggest-course]');
                    suggests.fadeIn();
                }
            })

            let events = ['select2:unselect', 'select2:clear'];
            events.forEach(event => {
                coursesSelect2.on(event, e => {
                    let data = e.params.data;
                    if (data.id === 'other') {
                        let suggests = $('[data-suggest-course]');
                        suggestsSelect2.val(null).trigger('change');
                        suggests.fadeOut();
                    }
                })
            })

            $('[data-need-courses]').on("change", e => {
                let courses = $('[data-courses]');
                let suggests = $('[data-suggest-course]');

                if (e.target.value === 'yes') {
                    courses.fadeIn();
                } else {
                    coursesSelect2.val(null).trigger('change');
                    suggestsSelect2.val(null).trigger('change');
                    courses.find('.select2-generate').value = '';
                    courses.fadeOut();
                    suggests.fadeOut();
                }
            });

            $('[data-is-special]').on('change', e => {
                let specialReason = $('[data-special-resaon]');
                let textarea = specialReason.find('textarea')[0];

                if (e.target.value === 'yes') {
                    textarea.textContent = '{{ $plan->special_reason }}';
                    specialReason.fadeIn();
                } else {
                    textarea.textContent = '';
                    specialReason.fadeOut();
                }
            })

            $('[data-is-exhibition]').on('change', e => {
                let exhibitionLevel = $('[data-exhibition-level]');
                let exhibitionDesire = $('[data-exhibition-desire]');

                if (e.target.value === 'yes') {
                    exhibitionLevel.fadeIn();
                    exhibitionDesire.fadeIn();
                } else {
                    exhibitionLevel.fadeOut();
                    exhibitionDesire.fadeOut();
                }
            })

            $('[data-has-employer]').on('change', e => {
                let employer = $('[data-employers]');

                if (e.target.value === 'yes') {
                    employer.fadeIn();
                } else {
                    employer.fadeOut();
                }
            });
        });

        function refreshFormData(element, isCompressed = true, result = null) {
            let name = element.getAttribute('name');

            if (isCompressed) {
                documentsFormData.set(name, result, result.name);
                for (const documentsFormDatum of documentsFormData.entries()) {
                    console.log(documentsFormDatum);
                }
                return true;
            }

            documentsFormData.set(name, element.closest('.row').querySelector('#document').value);
            for (const documentsFormDatum of documentsFormData.entries()) {
                console.log(documentsFormDatum);
            }
        }

        @if( !$plan->latitude )
        getLocation();
        @endif

        function compress(source_img_obj, quality, maxWidth, output_format) {
            var mime_type = "image/jpeg";
            if (typeof output_format !== "undefined" && output_format === "png") {
                mime_type = "image/png";
            }

            var natW = source_img_obj.naturalWidth;
            var natH = source_img_obj.naturalHeight;

            var cvs = document.createElement('canvas');
            cvs.width = natW;
            cvs.height = natH;

            var ctx = cvs.getContext("2d").drawImage(source_img_obj, 0, 0, natW, natH);
            var newImageData = cvs.toDataURL(mime_type, quality / 100);
            var result_image_obj = new Image();
            result_image_obj.src = newImageData;
            return result_image_obj;
        }

        function showBlobFile(blob) {
            let url = window.URL.createObjectURL(blob);
            let img = document.createElement('img');
            img.src = url;
            document.querySelector('.content > .flex-column-fluid .container-fluid').insertAdjacentHTML('beforeend', img.outerHTML);
        }

        function changeAccordionTitle(element) {
            element.closest('.card').querySelector('[data-target]').textContent = element.value;
        }

        async function addEmployer() {
            let accordion = document.querySelector('#employers');
            let promise = (await fetch('/assets/templates/employer.html')).text();
            promise.then(content => {

                let id = accordion.childElementCount;
                content = content.replaceAll('$$ID$$', `${id}`);
                accordion.insertAdjacentHTML('beforeend', content);
                setDatePicker(accordion.querySelector(`.card:nth-child(${id + 1})`));
            });
        }

        function deleteEmployer(id) {
            Swal.fire({
                title: 'حذف',
                text: 'از حذف کردن این شخص از لیست اطمینان دارید؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'بله',
                cancelButtonText: 'لغو',
                focusCancel: true
            }).then(result => {
                if (result.isConfirmed) {
                    document.querySelector(`.accordion .card[data-id="${id}"]`).remove();
                }
            });
        }
    </script>

@endpush
