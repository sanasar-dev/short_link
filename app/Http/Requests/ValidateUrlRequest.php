<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidateUrlRequest extends FormRequest
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
        return [
            'url' => 'url'
        ];
    }

    /**
     * @return array|string[]
     *
     * Generate errors message
     */
    public function messages(): array
    {
        return [
            'url' => 'Please, provide a valid url'
        ];
    }

    /**
     * @param Validator $validator
     *
     * Return error messages
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => array_map(function ($errors) {
                return array_values($errors);
            }, $validator->errors()->toArray())
        ]));
    }
}
