@extends('layout.master')
@section('dashboard_page_title', 'افزودن بانک جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($branch) ? route('branches.update', $branch->id) : route('branches.store') }}" method="POST">
            @csrf
            @isset($branch)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">نام شعبه</label>
                                <input required type="text" class="form-control" name="name" @isset($branch) value="{{ $branch->name }}" @endisset>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">کد شعبه</label>
                                <input required type="text" class="form-control" name="code" @isset($branch) value="{{ $branch->code }}" @endisset>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">تلفن شعبه</label>
                                <input required type="text" class="form-control" name="phone" @isset($branch) value="{{ $branch->phone }}" @endisset>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">رئیس  شعبه</label>
                                <input type="text" class="form-control" name="boss_name" @isset($branch) value="{{ $branch->boss_name }}" @endisset>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">تلفن رئیس شعبه</label>
                                <input type="text" class="form-control" name="boss_phone" @isset($branch) value="{{ $branch->boss_phone }}" @endisset>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group px-3">
                                <label for="" class="form-label">شهر</label>
                                <select required class="form-control" name="city_id">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" @if(isset($branch)) {{$branch->city_id == $city->id ? "selected":""}} @endif >{{ $city->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group px-3">
                                <label for="" class="form-label">بانک</label>
                                <select required class="form-control" name="bank_id">
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}" @if(isset($branch)) {{$branch->bank_id == $bank->id ? "selected":""}} @endif >{{ $bank->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">آدرس</label>
                                <input required type="text" class="form-control" name="address"
                                       @isset($branch) value="{{ $branch->address }}" @endisset  >
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">توضیحات</label>
                                <input  type="text" class="form-control" name="description"
                                       @isset($branch) value="{{ $branch->description }}" @endisset  >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">@isset($branch) ویرایش شعبه @else ثبت شعبه @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection


