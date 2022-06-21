<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemMasterRequest extends FormRequest
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
            'code' => ['required', 'integer', 'between:1,9999'],
            'category' => ['required', 'integer', 'between:1,4'],
            'name' => ['required', 'max:20'],
            'description' => ['nullable', 'max:50'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes('price',
            ['required', 'integer', 'between:0,999999'],
            function($input) {
                return $input->category !== 1;
            });
    }
}
