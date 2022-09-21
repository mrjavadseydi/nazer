@extends('layout.master')
@section('dashboard_page_title', 'پروفایل کاربری')

@section('dashboard_content')
    <div class="container-fluid text-right">
        <form action="{{ route('users.storeProfile') }}" method="POST">
            @csrf
            <div class="card card-custom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">نام</label>
                                <input type="text" class="form-control" name="firstName" value="{{ $user->firstName }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">نام خانوادگی</label>
                                <input type="text" class="form-control" name="lastName" value="{{ $user->lastName }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">ایمیل</label>
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">تلفن همراه</label>
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="" class="form-label">کد ملی</label>
                                <input type="text" class="form-control" name="nationalityCode" value="{{ $user->nationalityCode }}">
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

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="form-label">آدرس</label>
                                <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">ویرایش مشخصات</button>
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
