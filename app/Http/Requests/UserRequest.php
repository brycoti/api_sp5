<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'nullable',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => ' :attribute is required',
            'email.required' => ':attribute is required',
            'email.email' => ':attribute must be a valid email',
            'password.required' => ':attribute is required',
            'password.min' => ':attribute must be at least 10 characters',
        ];
    }
}
