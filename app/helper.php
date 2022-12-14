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
        try {
            return Jalalian::fromFormat($dateFormat, $dateString)->toCarbon();

        }catch (Exception $e){
//            dd($e->getMessage());
            return  "";
        }
    }
}

if( !function_exists('miladi2shamsi') ){
    function miladi2shamsi($format, $date){
        if (is_int($date)){
            $date = $date."/01/01";
        }
        try {
            if( gettype($date) == 'string' )
                $date = \Illuminate\Support\Carbon::createFromTimeString($date);

            return Jalalian::fromCarbon($date)->format($format);
        }catch (\Exception $e){
            \Illuminate\Support\Facades\Log::alert($e->getMessage()); ;
            return 0;
        }

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

if (!function_exists('on_bpms')){
    function on_bpms($id){
        $last_observ = \App\Models\Observe::where('plan_id',$id)->orderBy('id','desc')->first();
        if ($last_observ){
            return $last_observ->on_bpms;
        }
        return false;
    }
}
if (!function_exists('item_value')){
    function item_value($plan_id,$item_id){
        return \App\Models\PhysicalItemValue::where('plan_id',$plan_id)->where('physical_items_id',$item_id)->first()->value??null;
    }
}
if (!function_exists('last_observe_value')){
    function last_observe_value($plan_id,$type){
        return \App\Models\Observe::where('plan_id',$plan_id)->orderBy('id','desc')->first()[$type]??0;
    }
}
if (!function_exists('has_problem')){
    function has_problem($plan_id,$problem_id){
        $last_observer = \App\Models\Observe::where('plan_id',$plan_id)->orderBy('id','desc')->first();
        if (!$last_observer)
            return false;
        return (bool) \App\Models\ObserveProblem::where('observe_id',$last_observer->id)->where('problem_id',$problem_id)->first() ;
    }
}
if (!function_exists('sendSms')){
    function sendSms($pattern,$phone,$input_data=[]){
        $username = config('ippanel.username');
        $password = config('ippanel.password');
        $from = "+983000505";
        $pattern_code = $pattern;
        $to = [$phone];
        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
        return $response;
    }
}