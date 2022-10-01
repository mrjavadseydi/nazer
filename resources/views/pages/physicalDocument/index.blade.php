@extends('layout.master')
@section('dashboard_page_title', 'اطلاعات پرونده')

@push('dashboard_extra_css')
    <link rel="stylesheet" href="{{ asset('/assets/css/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/leaflet.css') }}">
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
                <h3 class="card-title">اطلاعات مجری</h3>
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

                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">آدرس: <strong>{{ $plan->address }}</strong></label>
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

                </div>
            </div>
            <!--end::Body-->
        </div>

        <form action="{{ route('physicalDocument.update', $plan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title"><strong>اطلاعات پرونده</strong></h3>
                </div>
                <div class="card-body">
                    <div class="row text-right border-bottom border-bottom-light-light mb-8">

                        @foreach($inputs as $input)
                            @if($input->type=="text"||$input->type=="number")
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="form-label"><strong>{{$input->title}}</strong></label>
                                        <input type="{{$input->type}}"
                                               {{$input->required?"required":""}} value="{{item_value($plan->id,$input->id)}}"
                                               class="form-control  mb-8"
                                               name="{{$input->name}}">
                                    </div>
                                </div>
                            @elseif($input->type=='bool')
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="form-label"><strong>{{$input->title}}</strong></label>
                                        <div class="radio-inline">
                                            <label class="radio radio-outline radio-primary mr-0 ml-4 text-success">
                                                <input type="radio"
                                                       {{$input->required?"required":""}}  name="{{$input->name}}"
                                                       value="true" {{item_value($plan->id,$input->id)=='true'?'checked':""}}
                                                />
                                                <span class="mr-0 ml-2"></span>
                                                دارد
                                            </label>
                                            <label class="radio radio-outline radio-primary mr-0 ml-4 text-danger">
                                                <input type="radio"
                                                       {{$input->required?"required":""}} name="{{$input->name}}"
                                                       {{item_value($plan->id,$input->id)==='false'?'checked':""}} value="false"
                                                        {{item_value($plan->id,$input->id)==null?'checked':""}}
                                                />
                                                <span class="mr-0 ml-2"></span>
                                                ندارد
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                    @if(auth()->user()->isAdmin)
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4 mx-5 w-25 ">ثبت</button>
                        </div>
                    @endif
                </div>

            </div>
        </form>
        <div class="text-right">
            <h3 class="text-xl mt-10"><strong>بازدید های ثبت شده</strong></h3>
            <livewire:observes planid="{{ $plan->id }}"/>
        </div>
    </div>
@endsection

@push('dashboard_extra_js')

@endpush
