<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $id = request()->route('user');

        return [
            "first_name" => ["required", "min:2"],
            "last_name" => ["required", "min:2"],
            "email" => ["required", "email", "min:5", Rule::unique('users')->ignore($id)],
            "role_id" => ["required", "integer", "min:1"]
        ];
    }
}
