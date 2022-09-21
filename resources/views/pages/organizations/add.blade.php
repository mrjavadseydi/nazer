@extends('layout.master')
@section('dashboard_page_title', 'افزودن اداره جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($organization) ? route('organizations.update', $organization->id) : route('organizations.store') }}" method="POST">
            @csrf
            @isset($organization)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">کد اداره</label>
                                <input type="number" class="form-control" name="code" @isset($organization) value="{{ $organization->code }}" @endisset>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">نام اداره</label>
                                <input type="text" class="form-control" name="title" @isset($organization) value="{{ $organization->title }}" @endisset>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">عرض جغرافیایی (Latitude)</label>
                                <input type="text" class="form-control" name="latitude" @isset($organization) value="{{ $organization->latitude }}" @endisset>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">طول جغرافیایی (Longitude)</label>
                                <input type="text" class="form-control" name="longitude" @isset($organization) value="{{ $organization->longitude }}" @endisset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">@isset($organization) ویرایش اداره @else ثبت اداره @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection
