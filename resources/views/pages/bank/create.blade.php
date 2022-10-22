@extends('layout.master')
@section('dashboard_page_title', 'افزودن بانک جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($bank) ? route('bank.update', $bank->id) : route('bank.store') }}" method="POST">
            @csrf
            @isset($bank)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">نام بانک</label>
                                <input type="text" class="form-control" name="name" @isset($bank) value="{{ $bank->name }}" @endisset>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group px-3">
                                <label for="" class="form-label">شهر</label>
                                <select class="form-control" name="city_id">
                                    @foreach(\App\Models\City::all() as $city)
                                        <option value="{{ $city->id }}">{{ $city->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if(isset($bank)&&$branches = $bank->branch)
                        @foreach($branches as $branch)
                            <livewire:branch-input :i="1" :form="$branch" />
                        @endforeach
                    @else

                        <livewire:branch-input/>
                    @endif
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">@isset($bank) ویرایش بانک @else ثبت بانک @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection


