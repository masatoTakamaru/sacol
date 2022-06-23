<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'registered_date' => 'required',
            'expired_date' => ['nullable', 'date'],
            'family_name' => ['required', 'max:20'],
            'given_name' => ['required', 'max:20'],
            'family_name_kana' => ['required', 'regex:/\A[ァ-ヴー]+\z/u', 'max:20'],
            'given_name_kana' => ['required', 'regex:/\A[ァ-ヴー]+\z/u', 'max:20'],
            'gender' => ['required', 'in:男,女,その他'],
            'grade' => ['required', 'integer'],
            'email' => ['nullable', 'email:strict,dns', 'max:80'],
            'remarks' => ['nullable', 'max:200'],
        ];
    }
}
