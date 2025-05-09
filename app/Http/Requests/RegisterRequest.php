<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
           
            'email' => 'email|unique:users,email',
            'profile_photo' => 'file|mimes:jpg,jpeg,png|max:2048',
            'password' => 'required|confirmed|min:8',
            'name'=>'required|string|max:50|unique:users,name'
        ];
    }
}
