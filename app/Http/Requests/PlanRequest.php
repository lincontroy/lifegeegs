<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            "price" => 'required',
            "duration" => 'required',
            "captcha" => 'nullable',
            "menual_req" => 'nullable',
            "daily_req" => 'nullable',
            "mail_activity" => 'nullable',
            "storage_limit" => 'nullable',
            "fraud_check" => 'nullable',
            "is_featured" => 'nullable',
            "is_auto" => 'nullable',
            "is_trial" => 'nullable',
            "status" => 'nullable',
            "is_default" => 'nullable',
        ];
    }
}
