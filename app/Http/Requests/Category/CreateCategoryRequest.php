<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|min:6',
            'user_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori tidak boleh kossong!',
            'name.min' => 'Nama kategori minimal 6 karakter!',
            'user_id.required' => 'ID User untuk kategory tidak boleh kosong!',
        ];
    }
}
