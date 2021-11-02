<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => 'required',
            "email" => 'required',
            "password" => 'required',
            "phone" => 'nullable',
            "status" => 'nullable',
            "image" => 'nullable',
            "public_key" => 'nullable',
            "private_key" => 'nullable',
            "currency" => 'nullable',
        ];
    }
}
