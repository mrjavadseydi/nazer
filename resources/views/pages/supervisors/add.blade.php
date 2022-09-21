@extends('layout.master')
@section('dashboard_page_title', 'افزودن ناظر جدید')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ isset($supervisor) ? route('supervisors.update', $supervisor->id) : route('supervisors.store') }}" method="POST">
            @csrf
            @isset($supervisor)
                @method('PUT')
            @endisset
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">نام و نام خانوادگی</label>
                                <input type="text" class="form-control" name="fullName" @isset($supervisor) value="{{ $supervisor->fullName }}" @endisset>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">تلفن همراه</label>
                                <input type="text" class="form-control" name="phone" @isset($supervisor) value="{{ $supervisor->phone }}" @endisset>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">کد ملی</label>
                                <input type="text" class="form-control" name="nationalityCode" @isset($supervisor) value="{{ $supervisor->nationalityCode }}" @endisset>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">رمز عبور</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button id="generate_password" class="btn btn-primary" type="button" style="border-radius: 0 0.42rem 0.42rem 0;" data-password-generator>تولید رمز</button>
                                    </div>
                                    <input type="password" class="form-control" name="password" style="border-radius: 0;" value="hide">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" style="border-radius: 0.42rem 0 0 0.42rem" data-password-toggle>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-danger m-0 mt-3">در صورتی که رمز عبور وارد شده بیش از 8 کاراکتر باشد، رمز عبور شما تغییر خواهد کرد</p>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="" class="form-label">آدرس</label>
                                <input type="text" class="form-control" name="address" @isset($supervisor) value="{{ $supervisor->address }}" @endisset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">@isset($supervisor) ویرایش ناظر @else ثبت ناظر @endif</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('dashboard_extra_js')
    <script>
        let password = document.querySelector('input[name=password]');

        document.querySelector('[data-password-generator]').addEventListener('click', ()=>{
            password.setAttribute('type', 'text');
            password.value = generatePassword(8);
        });

        document.querySelector('[data-password-toggle]').addEventListener('click', ()=>{
            if( password.getAttribute('type') === 'text' )
                password.setAttribute('type', 'password');
            else
                password.setAttribute('type', 'text');
        });

        function generatePassword(length){
            let pwdChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            return Array(length).fill(pwdChars).map(function(x) { return x[Math.floor(Math.random() * x.length)] }).join('');
        }
    </script>
@endpush
