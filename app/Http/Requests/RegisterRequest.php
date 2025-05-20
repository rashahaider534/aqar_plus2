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

            'email' => 'required|email|regex:/^.+@.+\.com$/i|unique:users,email',
            'profile_photo' => 'file|mimes:jpg,jpeg,png|max:2048',
              'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-zA-Z]/', // يحتوي على حروف
                'regex:/[0-9]/'     // يحتوي على أرقام
              ],
            'name'=>'required|string|max:50|unique:users,name',
            'phone'=>'unique:users,phone',
            'bank_code'=>'unique:users,bank_code|min:10|max:10',
        ];
    }
      public function messages(): array
    {
        return [
            'name.required' => 'الرجاء إدخال الاسم.',
            'name.unique' => 'الاسم موجود مسبقًا، يرجى اختيار اسم آخر.',

            'email.required' => 'الرجاء إدخال البريد الإلكتروني.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.regex' => 'يجب أن يحتوي البريد الإلكتروني على @ و .com',
            'email.unique' => 'هذا الحساب موجود بالفعل.',

            'password.required' => 'الرجاء إدخال كلمة السر.',
            'password.min' => 'كلمة السر يجب أن تكون على الأقل 8 محارف.',
            'password.regex' => 'يجب أن تحتوي كلمة السر على أحرف وأرقام.',

            'phone.unique'=>'هذا الرقم موجود بالفعل.',

            'bank_code.unique'=>'الرقم البنكي موجود  مسبقاً',
            'bank_code.min'=>'الرقم البنكي  مكون من 10 ارقام حصراَ',
            'bank_code.max'=>'الرقم البنكي  مكون من 10 ارقام حصراَ',
        ];
    }
}
