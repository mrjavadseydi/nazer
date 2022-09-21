@extends('layout.master')
@section('dashboard_page_title', 'افزودن دوره جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($course) ? route('courses.update', $course->id) : route('courses.store') }}" method="POST">
            @csrf
            @isset($course)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">عنوان دوره</label>
                                <input type="text" class="form-control" name="title" @isset($course) value="{{ $course->title }}" @endisset required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">توضیحات</label>
                                <textarea name="description" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">@isset($course) ویرایش دوره @else ثبت دوره @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection
