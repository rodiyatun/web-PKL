<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => "required|email",
            "name" => "required",
            "company_name" => "required",
            "password" => "required",
            "company_address" => "required",
            "pic" => "required",
            "pic_email" => "required",
            "pic_phone" => "required"
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Alamat Email harus diisi",
            "name.required" => "nama Owner harus diisi",
            "company_name.required" => "nama perusahaan harus diisi",
            "password.required" => "Password harus diisi",
            "company_address.required" => "Alamat Perusahaan harus diisi",
            "pic.required" => "PIC harus diisi",
            "pic_email.required" => "Email PIC harus diisi",
            "pic_phone.required" => "Phone PIC harus diisi",
        ];
    }
}
