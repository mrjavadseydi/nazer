@extends('layout.master')
@section('dashboard_page_title', 'افزودن مدرک جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($document) ? route('documents.update', $document->id) : route('documents.store') }}" method="POST">
            @csrf
            @isset($document)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">عنوان مدرک</label>
                                <input type="text" class="form-control" name="title" @isset($document) value="{{ $document->title }}" @endisset>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">اجباری بودن</label>
                                <div class="radio-inline">
                                    <label class="radio radio-outline radio-primary mr-0 ml-4">
                                        <input type="radio" name="required" value="on" @isset($document) {{ $document->required ? 'checked' : '' }} @endisset/>
                                        <span class="mr-0 ml-2"></span>
                                        اجباری است
                                    </label>
                                    <label class="radio radio-outline radio-primary mr-0 ml-4">
                                        <input type="radio" name="required" value="off" @isset($document) {{ !$document->required ? 'checked' : '' }}  @else checked @endisset/>
                                        <span class="mr-0 ml-2"></span>
                                        اختیاری است
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">@isset($document) ویرایش مدرک @else ثبت مدرک @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection
