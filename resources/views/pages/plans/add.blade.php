@extends('layout.master')
@section('dashboard_page_title', 'ثبت پرونده')
@push('dashboard_extra_css')
    {{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>--}}

    {{--    <link rel="stylesheet" href="{{ asset('/assets/css/steps.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/assets/css/persian-datepicker.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ asset('/assets/css/dropzone.min.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset('/assets/css/tagify.css') }}">--}}
    <style>
        #select2-supervisors-container {
            height: 45px;
        }
    </style>
@endpush

@section('dashboard_content')
    <div class="container-fluid">

        <div class="card card-custom">
            <form id="accept_plan" action="{{ isset($plan) ?route('plans.update',$plan->id): route('plans.store') }}"
                  method="POST">
                @if(isset($plan))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <!--begin::Nav Content-->
                    <div class="tab-content m-0 mt-4 p-0">

                        @csrf
                        <section>
                            <div class="row text-right">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">نام</label>
                                        <input type="text" required class="form-control" name="performer[firstName]" @isset($plan) value="{{$plan->performer->firstName}}" @endisset>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group px-3">
                                        <label for="" class="form-label">نام خانوادگی</label>
                                        <input type="text" required class="form-control" name="performer[lastName]" @isset($plan) value="{{$plan->performer->lastName}}" @endisset>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group pr-3">
                                        <label for="" class="form-label">کد ملی</label>
                                        <input type="text" required class="form-control"
                                               name="performer[nationalityCode]" @isset($plan) value="{{$plan->performer->nationalityCode}}" @endisset>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">تاریخ تولد</label>
                                        <input type="text" required class="form-control persianDate"
                                               name="performer[birthday]" @isset($plan) value="{{shamsi2miladi('Y/m/d',fa2en($plan->performer->birthday))}}" @endisset>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group px-3">
                                        <label for="" class="form-label">شماره تلفن</label>
                                        <input type="text" required class="form-control" name="performer[phone]" @isset($plan) value="{{$plan->performer->phone}}" @endisset>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group px-3">
                                        <label for="" class="form-label"> شماره تلفن ضروری </label>
                                        <input type="text" class="form-control" name="performer[second_number]" @isset($plan) value="{{$plan->performer->second_number}}" @endisset>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group pr-3">
                                        <label for="" class="form-label">جنسیت</label>
                                        <div class="radio-inline">
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" name="performer[gender]" checked="checked"
                                                       value="male"  @isset($plan) {{$plan->performer->gender=="male"?"checked":""}} @endisset />
                                                <span class="mr-0 ml-2"></span>
                                                مرد
                                            </label>
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" name="performer[gender]" value="female"  @isset($plan) {{$plan->performer->gender=="female"?"checked":""}} @endisset/>
                                                <span class="mr-0 ml-2"></span>
                                                زن
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">تحت پوشش کمیته امداد</label>
                                        <div class="radio-inline">
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" name="performer[support]"
                                                       checked="checked"/>
                                                <span class="mr-0 ml-2"></span>
                                                بله
                                            </label>
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" name="performer[support]"/>
                                                <span class="mr-0 ml-2"></span>
                                                خیر
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group px-3">
                                        <label for="" class="form-label">سطح فعالیت</label>
                                        <select class="form-control" name="plan[level]">
                                            <option @isset($plan)
                                                        {{$plan->level=="خودکفايي"?"selected":""}}
                                                    @endisset
                                                >
                                                خودکفايي
                                            </option>
                                            <option  @isset($plan)
                                                {{$plan->level==" توان افزایی"?"selected":""}}
                                                    @endisset>
                                                توان افزایی
                                            </option>
                                            <option @isset($plan)
                                                {{$plan->level=="کار انگیزی"?"selected":""}}
                                                    @endisset>
                                                کار انگیزی
                                            </option>
                                            <option @isset($plan)
                                                {{$plan->level=="کار آفرینی"?"selected":""}}
                                                    @endisset>
                                                کار آفرینی
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section>
                            <div class="row text-right">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">عنوان طرح</label>
                                        <input type="text" class="form-control" required name="plan[title]"  @isset($plan) value="{{$plan->title}}" @endisset>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">تاریخ اجرا</label>
                                        <input type="text" required class="form-control persianDate"
                                               name="performer[start_date]" @isset($plan) value="{{$plan->start_date}}" @endisset >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group px-3">
                                        <label for="" class="form-label">دسته</label>
                                        <select class="form-control" name="plan[category]">
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}"  @isset($plan) value="{{$plan->category==$category?"selected":""}}" @endisset >{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{--                                <div class="col-4">--}}
                                {{--                                    <div class="form-group pr-3">--}}
                                {{--                                        <label for="" class="form-label">برچسب ها</label>--}}
                                {{--                                        <input type="text" required class="form-control" name="plan[tags]" id="tagify">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">اداره</label>
                                        <select class="form-control" name="plan[organization]">
                                            @foreach($organizations as $organization)
                                                <option value="{{ $organization->id }}"  @isset($plan) value="{{$plan->organization_id==$organization->id?"selected":""}}" @endisset>{{ $organization->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group px-3">
                                        <label for="" class="form-label">نوع طرح</label>
                                        <div class="radio-inline">
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" name="plan[implement_method]" value="هدایت شغلی"
                                                       checked="checked"/>
                                                <span class="mr-0 ml-2"></span>
                                                هدایت شغلی
                                            </label>
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" @isset($plan)
                                                    {{$plan->implement_method=="راهبری شغلی"?"checked":""}}
                                                @endisset name="plan[implement_method]" value="راهبری شغلی"/>
                                                <span class="mr-0 ml-2"></span>
                                                راهبری شغلی
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group pr-3">
                                        <label for="" class="form-label">نوع مکان طرح</label>
                                        <div class="radio-inline">
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" name="plan[location_type]" checked="checked"
                                                       value="شهری"/>
                                                <span class="mr-0 ml-2"></span>
                                                شهری
                                            </label>
                                            <label class="radio radio-outline radio-primary mr-0 ml-4">
                                                <input type="radio" name="plan[location_type]" @isset($plan)
                                                        {{$plan->location_type=="روستایی"?"checked":""}}
                                                    @endisset value="روستایی"/>
                                                <span class="mr-0 ml-2"></span>
                                                روستایی
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">آدرس</label>
                                        <input type="text" required class="form-control" name="plan[address]"  @isset($plan) value="{{$plan->address}}" @endisset >
                                    </div>
                                </div>
                            </div>
                        </section>
                        @if(!isset($plan))
                        <section>
                            <div class="row text-right">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group pl-3">
                                        <label for="" class="form-label">کارشناس فنی (ناظر)</label>
                                        <select required class="custom-select form-control select2-generate"
                                                id="supervisors"
                                                name="supervisor">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @endif
                    </div>

                    <!--end::Nav Content-->
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">ثبت پرونده</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('dashboard_extra_js')
    {{--    <script src="{{ asset('/assets/js/jquery-3.6.1.min.js')}}"></script>--}}
    {{--    <script src="{{ asset('/assets/js/jquery.steps.min.js') }}"></script>--}}
    <script src="{{ asset('/assets/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('/assets/js/persian-datepicker.min.js') }}"></script>
    {{--    <script src="{{ asset('/assets/js/dropzone.min.js') }}"></script>--}}
    <script src="{{ asset('/assets/js/tagify.js') }}"></script>
    <script src="{{ asset('/assets/js/tagify.polyfills.min.js') }}"></script>
    {{--    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>--}}
    <script>
        $(document).ready(function () {
            $(".persianDate").pDatepicker({
                format: 'YYYY/MM/DD'
            });
        });

        $(document).ready(function () {
            var input = document.querySelector('#tagify'),
                tagify = new Tagify(input);
            $('#supervisors').select2({
                ajax: {
                    url: '{{ route('supervisor.index') }}',
                    dataType: 'json'
                }
            });
        });
    </script>
@endpush
