<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'title' => 'required|min:10',
            'content' => 'required|min:20',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title tidak boleh kosong!',
            'title.min' => 'Title minimal 10 karakter!',
            'content.required' => 'Konten artikel tidak boleh kosong!',
            'content.min' => 'Konten artikel minimal 20 karakter!',
            'image' => 'Image tidak boleh kosong!',
            'image' => 'Gambar yang dimasukan tidak valid!',
            'user_id' => 'ID user untuk konten artikel belum diisi!',
            'category_id' => 'ID kategori artikel harus diisi!',
        ];
    }
}
