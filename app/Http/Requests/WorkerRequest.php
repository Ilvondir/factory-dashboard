<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => ["required", "min:2"],
            "last_name" => ["required", "min:2"],
            "salary" => ["required", "decimal:0,2"],
            "email" => ["required", "email", "min:5"],
            "phone_number" => ["required", "min:8", "max:20"],
            "address" => ["required", "min:8"],
            "hired" => ["required", "date", "before:tomorrow"],
            "position_id" => ["required", "integer", "min:1"]
        ];
    }
}
