<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => 'required',
            'email'            => 'required|email:rfc,dns|unique:users,email',
            'mob'              => 'required|numeric',
            'password'         => 'required',
            'confirm_password' => 'required|same:password',
            'captcha'          => 'required|captcha',
        ];
    }

    public function messages(): array
    {
        return [
            'captcha.required' => 'Please enter the captcha code.',
            'captcha.captcha'  => 'Invalid captcha. Please try again.',
            'email.email'      => 'Please enter a valid email address.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => 422
        ], 422));
    }
}
