@extends('layout.master')
@section('dashboard_page_title', 'افزودن پیشنهاد جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($suggest) ? route('suggests.update', $suggest->id) : route('suggests.store') }}" method="POST">
            @csrf
            @isset($suggest)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">عنوان دوره</label>
                                <input type="text" class="form-control" name="title" @isset($suggest) value="{{ $suggest->title }}" @endisset required>
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
                    <button class="btn btn-primary">@isset($suggest) ویرایش پیشنهاد @else ثبت پیشنهاد @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection
