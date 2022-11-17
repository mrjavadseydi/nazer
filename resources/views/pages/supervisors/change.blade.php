@extends('layout.master')
@section('dashboard_page_title', 'انتقال برنامه های ناظر')

@section('dashboard_content')

    <div class="container-fluid text-right">

        <form action="{{ route('change-supervisor.store',request()->id) }}"
              method="POST">
            @csrf

            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">ناظر </label>
                                <input type="text" class="form-control" disabled name="firstName"
                                       value="{{ $supervisor->fullName }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label"> تعداد برنامه ها</label>
                                <input type="text" class="form-control" disabled name="lastName"
                                       value="{{$supervisor->plans->count() }}">
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group px-3">
                                <label for="" class="form-label">ناظر جدید</label>
                                <select class="form-control" name="supervisor">
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{$supervisor->id}}">{{$supervisor->fullName}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label"> تعداد برنامه ها</label>
                                <input min="{{$supervisor->plans->count()}}" type="number" class="form-control"
                                       name="count"
                                       value="0">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group px-3">
                                <label for="" class="form-label">نوع انتقال</label>
                                <select class="form-control" name="type">
                                    <option value="1">همه</option>
                                    <option value="2">بدون نظارت</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">ثبت</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('dashboard_extra_js')

@endpush
