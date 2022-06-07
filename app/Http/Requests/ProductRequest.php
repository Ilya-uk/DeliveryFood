<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:3|max:80',
            'weight' => 'required|min:1|max:12',
            'composition' => 'required|min:3',
            'price' => 'required|numeric|min:1',
            'old_price' => 'numeric|min:1|nullable ',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле обзательно для заполнения',
            'min' => 'Поле должно иметь минимум :min символов',
            'max' => 'Поле не должно превышать :min символов',
            'numeric' => 'Поле не должно содержать буквы'
        ];
    }
}
