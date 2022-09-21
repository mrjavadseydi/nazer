<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

if( !function_exists('put_message') ){
    function put_message($title, $message, $status)
    {
        $put_data = [
            'title' => $title,
            'message' => $message,
            'status' => $status
        ];
        Session::flash('message', $put_data);
    }
}

if( !function_exists('get_message') ){
    function get_message()
    {
        return Session::get('message');
    }
}

if( !function_exists('has_message') ){
    function has_message(): bool
    {
        return Session::has('message');
    }
}

if( !function_exists('fa2en') ){
    function fa2en($string) {
        return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }
}

if( !function_exists('en2fa') ){
    function en2fa($string) {
        $nums = [
            '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
            '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹',
        ];

//        $nums = array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9')
        return strtr($string, $nums);
    }
}

if( !function_exists('shamsi2miladi') ){
    function shamsi2miladi($dateFormat, $dateString){
        return Jalalian::fromFormat($dateFormat, $dateString)->toCarbon();
    }
}

if( !function_exists('miladi2shamsi') ){
    function miladi2shamsi($format, $date){
        if( gettype($date) == 'string' )
            $date = \Illuminate\Support\Carbon::createFromTimeString($date);

        return Jalalian::fromCarbon($date)->format($format);
    }
}


if( !function_exists('upload') ){
    function upload(\Illuminate\Http\UploadedFile $file){
        $name = \Illuminate\Support\Str::uuid();
        $extension = $file->extension();
        $fullName = $name . '.' . $extension;

        $file->move('uploads/', $fullName);
        return $fullName;
    }
}

if( !function_exists('replace_arabic_with_persian_char') ){
    function replace_arabic_with_persian_char($text){
        $characters = [ 'ي' => 'ی' ];
        return trim(strtr($text, $characters));
    }
}


if( !function_exists('get_excerpt_fullName') ){
    function get_excerpt_fullName(){
        $user = Auth::user();
        $splitWords = explode(' ', $user->fullName);
        $firstSplitWord = $splitWords[0];
        $lastSplitWord = $splitWords[count($splitWords) - 1];
    }
}
