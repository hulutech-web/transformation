<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParkRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:parks',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '名稱',
            'address' => '地址',
            'phone' => '電話',
        ];
    }
}
