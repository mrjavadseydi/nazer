<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        $validator = Validator::make($this->all(), [
//            'nationalityCode' => 'bail|required|min:10',
//            'password' => 'bail|required|min:8',
//        ]);
//        dd($validator->errors());
        return [
            'nationalityCode' => 'bail|required|min:10',
            'password' => 'bail|required|min:8',
        ];
    }
}
