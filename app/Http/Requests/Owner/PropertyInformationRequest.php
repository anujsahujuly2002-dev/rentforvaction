<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PropertyInformationRequest extends FormRequest
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
        if(Request::input('property_old_image') !='undefined'):
            $rule= [
                'property_name'=>'required',
                'property_suitablity'=>'required',
                // 'property_main_image'=>'mimes:jpeg,jpg,png,gif,webp|max:8192',
                // 'square_feet'=>'required',
                'property_type'=>'required',
                'bedrooms'=>'required',
                'sleeps'=>'required',
                'avg_night'=>'required',
                'rate_per_unit'=>'required',
                'baths'=>'required',
                'description'=>'required',
                'country_name'=>'required',
                'state_name'=>'required',
                'region_name'=>'required',
                // 'city_name'=>'required',
            ];
        else:
            $rule= [
                'property_name'=>'required',
                'property_suitablity'=>'required',
                // 'property_main_image'=>'required|mimes:jpeg,jpg,png,gif,webp|max:8192',
                // 'square_feet'=>'required',
                'property_type'=>'required',
                'bedrooms'=>'required',
                'sleeps'=>'required',
                'avg_night'=>'required',
                'rate_per_unit'=>'required',
                'baths'=>'required',
                'description'=>'required',
                'country_name'=>'required',
                'state_name'=>'required',
                'region_name'=>'required',
                // 'city_name'=>'required',
            ];
        endif;
        return $rule;
    }

    public function messages(){
        return [
        'property_main_image.required' => "You must use the 'Choose file' button to select which file you wish to property main image",
        'property_main_image.max' => "Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB"
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
