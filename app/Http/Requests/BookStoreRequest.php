<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
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
            'isbn' => [
                'required',
                'numeric',
                'unique:App\Models\Book,isbn'
            ],
            'title' => [
                'required',
                'string',
                'max:100'
            ],
            'publicationDate' => [
                'required',
                'date'
            ],
            'weight' => [
                'required',
                'integer'
            ],
            'wide' => [
                'required',
                'integer'
            ],
            'long' => [
                'required',
                'integer'
            ],
            'page' => [
                'required',
                'integer'
            ],
            'description' => [
                'required',
                'string',
                'max:200'
            ],
            'author' => [
                'required',
                'array'
            ],
            'author.*' => [
                'integer'
            ],
            'publisher' => [
                'required',
                'integer'
            ],
            'language' => [
                'required',
                'integer'
            ],
            'category' => [
                'required',
                'integer'
            ],
            'image' => [
                'required',
                'array'
            ],
            'image.*' => [
                'image'
            ],
        ];
    }
}
