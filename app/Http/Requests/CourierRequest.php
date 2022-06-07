<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourierRequest extends FormRequest
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
            'name' => 'required|min:3|max:45',
            'phone' => 'required|min:18',

        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле обзательно для заполнения',
            'min' => 'Поле должно иметь минимум :min символов',
        ];
    }
}
