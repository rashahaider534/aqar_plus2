<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'name' => 'required',
              'password' => [
                'required',
                    // يحتوي على أرقام
              ],
            ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'يرجى إدخال اسم المستخدم.',
            'name.exists' => 'المستخدم غير موجود، يمكنك إنشاء حساب جديد.',

            'password.required' => 'يرجى إدخال كلمة السر.',
        ];
    }
}
