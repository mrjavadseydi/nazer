<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('pages.users.show', compact('user'));
    }

    public function storeProfile(Request $request)
    {
        $user = Auth::user();
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->nationalityCode = $request->nationalityCode;
        if( $request->password != 'hide' and strlen($request->password) >= 8 )
            $user->password = $request->password;
        $user->save();

        if( Str::lower($user->role->name) == 'supervisor' ){
            $supervisor = Supervisor::where('nationalityCode', $user->nationalityCode)->first();
            $supervisor->fullName = $request->firstName . ' ' . $request->lastName;
            $supervisor->phone = $request->phone;
            $supervisor->nationalityCode = $request->nationalityCode;
            $supervisor->address = $request->address;
            $supervisor->save();
        }

        return redirect()->route('plans.index');
    }
}
