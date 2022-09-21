@extends('auth.layout.master')
@section('auth_content')
<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
    <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('{{ url('assets/img/bg-3.jpg') }}');">
        <div class="login-form text-center p-7 position-relative overflow-hidden">
            <!--begin::Login Header-->
            <div class="d-flex flex-center mb-15">
                <a href="#">
                    <img src="{{ url('assets/img/login-logo.png') }}" class="max-h-75px" alt="" />
                </a>
            </div>
            <!--end::Login Header-->
            <!--begin::Login reset password form-->
            <div class="login-reset">
                <div class="mb-20">
                    <h3>تغییر رمز عبور</h3>
                    <div class="text-muted font-weight-bold">رمز عبور جدید برای اکانت خود ایجاد کنید</div>
                </div>
                <form action="{{ url('/reset') }}" method="POST" class="form" id="kt_login_forgot_form">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group mb-10">
                        <input class="form-control form-control-solid h-auto py-4 px-8 text-right" type="text" placeholder="ایمیل خود را وارد کنید" name="email" autocomplete="off" value="{{ $email }}" readonly/>
                    </div>
                    <div class="form-group mb-10">
                        <input class="form-control form-control-solid h-auto py-4 px-8 text-right" type="password" placeholder="رمز عبور جدید" name="password" autocomplete="off" />
                    </div>
                    <div class="form-group mb-10">
                        <input class="form-control form-control-solid h-auto py-4 px-8 text-right" type="password" placeholder="تکرار رمز عبور جدید" name="password_confirmation" autocomplete="off" />
                    </div>
                    <div class="form-group d-flex flex-wrap flex-center mt-10">
                        <button id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">ارسال درخواست</button>
                        <a class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2" href="{{ url('/login') }}">لغو کردن</a>
                    </div>
                </form>
            </div>
            <!--end::Login reset password form-->
        </div>
    </div>
</div>
@endsection
