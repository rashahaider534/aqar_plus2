<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPropertyRequest extends FormRequest
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
            'province'       => 'required|string',
            'name'           => 'required|string',
            'type'           => 'required',
            'ownership_image'  => 'required|image',
            'room'          => 'integer|required',
            'final_price'          => 'required|numeric',
            'area'           => 'required|numeric',
            'images'         => 'required|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'province.required'       => 'يجب إدخال المحافظة.',
            'name.required'           => 'يجب إدخال اسم العقار.',
            'type.required'           => 'يجب تحديد نوع العقار (اجار أو شراء).',
            'ownership_image.required'  => 'يجب رفع صورة وثيقة الملكية.',
            'ownership_image.image'     => 'وثيقة الملكية يجب أن تكون صورة.',
            'room.required'       => 'عدد الغرف مطلوب .',
            'room.integer'           => 'عدد الغرف يجب أن يكون رقماً صحيحاً.',
            'final_price.required'          => 'يجب إدخال السعر.',
            'final_price.numeric'           => 'السعر يجب أن يكون رقماً.',
            'area.required'           => 'يجب إدخال المساحة.',
            'area.numeric'            => 'المساحة يجب أن تكون رقماً.',
            'images.required'         => 'يجب رفع صور للعقار.',
            'images.array'            => 'يجب إرسال الصور كمصفوفة.',
            'images.*.image'          => 'كل صورة يجب أن تكون من نوع صورة.',
            'images.*.mimes'          => 'الصور يجب أن تكون بصيغة jpeg أو png أو jpg.',
            'images.*.max'            => 'حجم كل صورة لا يجب أن يتجاوز 2 ميغابايت.',
        ];
    }
}
