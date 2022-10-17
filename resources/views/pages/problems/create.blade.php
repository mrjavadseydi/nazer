@extends('layout.master')
@section('dashboard_page_title', 'افزودن مشکل جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($problem) ? route('problem.update', $problem->id) : route('problem.store') }}" method="POST">
            @csrf
            @isset($problem)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">عنوان مشکل </label>
                                <input type="text" class="form-control" name="problem" @isset($problem) value="{{ $problem->problem }}" @endisset>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group px-3">
                                <label for="" class="form-label">دسته</label>
                                <select class="form-control" name="plan_type">
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" @if(isset($problem)){{$problem->plan_type==$category?"selected":""}}@endif>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">مقدار bpms</label>
                                <input type="number" class="form-control" name="end_value" @isset($problem) value="{{ $problem->end_value }}" @endisset>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">@isset($problem) ویرایش مشکل @else ثبت مشکل @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection


