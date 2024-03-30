<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateCustomerRequest extends FormRequest
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
    public function rules(): array
    {
        if ($this->isMethod('GET')) {
            return  [];
        }

        $rules = [
            'customer_name' => 'required|string|max:255',
            'phone' => ['required', 'max:20', 'regex:/^0\d{9,10}$/'],
            'address' => 'required|string|max:255',
        ];

        if (!empty($this->input('email'))) {
            $rules['email'] = 'email|max:255';
            if ($this->isMethod('POST')) {
                $rules['email'] .= '|unique:customers,email';
            }
        }
        if (!empty($this->input('tax_code'))) {
            $rules['tax_code'] = 'required';
            $rules['company'] = 'required';
            $rules['company_address'] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Vui lòng nhập tên.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'email.email' => 'Vui lòng nhập đúng định dạng địa chỉ email.',
            'email.unique' => 'Địa chỉ email này đã tồn tại.',
            'phone.max' => 'Số điện thoại không được vượt quá :max ký tự.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'tax_code' => 'Vui lòng mã số thuế.',
            'company' => 'Vui lòng nhập tên công ty.',
            'company_address' => 'Vui lòng nhập địa chỉ công ty.'
        ];
    }
}
