<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signIn(Request $request)
    {
        $nationalityCode = $request->nationalityCode;
        $password = $request->password;

        if( Auth::attempt(['nationalityCode' => $nationalityCode, 'password' => $password]) ){
            return redirect()->route('plans.index');
        }
        return back();
    }

    public function forgot(ForgotRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('phone')
        );

        if( $status === Password::RESET_LINK_SENT ){
            return trans('authentication::auth.' . Str::lower('The reset link was sent to entered email'));
        }
        else{
            return trans('authentication::auth.' . Str::lower('The email was entered is incorrect'));
        }
    }

    public function resetForm(Request $request, $token)
    {
        $email = $request->email;
        return view('auth.reset', compact('token', 'email'));
    }

    public function reset(ResetRequest $request)
    {

        $credentials = $request->only('nationalityCode', 'password', 'password_confirmation', 'token');
        $status = Password::reset($credentials, function ($user, $password){
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        if( $status == Password::PASSWORD_RESET ){
            $status = trans('authentication::auth.' . Str::lower('Your password successfully changed'));
            return redirect()->route('login')->with('status', $status);
        }
        elseif ($status == Password::INVALID_TOKEN){
            return trans('authentication::auth.' . Str::lower('The token is invalid'));
        }
        elseif ($status == Password::INVALID_USER){
            return trans('authentication::auth.' . Str::lower('User with this email not exist'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
