<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PrepertyReviews extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'reviews_heading'=>'required',
            // 'guest_name'=>'required',
            // 'place'=>'required',
            // 'reviews'=>'required',
            // 'rating'=>'required', 
        ];
    }

    /**
        * Get the error messages for the defined validation rules.*
        * @return array
    */
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status'=>422
        ], 422));
    }
}
