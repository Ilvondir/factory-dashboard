<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            "email" => ["required", "email", "min:5", "unique:users"],
            "role_id" => ["required", "integer", "min:1"]
        ];
    }
}
