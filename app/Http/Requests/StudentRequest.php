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
            'school_attended' => ['nullable', 'max:40'],
            'guardian_family_name' => ['nullable', 'max:20'],
            'guardian_given_name' => ['nullable', 'max:20'],
            'guardian_family_name_kana' => ['nullable', 'regex:/\A[ァ-ヴー]+\z/u', 'max:20'],
            'guardian_given_name_kana' => ['nullable', 'regex:/\A[ァ-ヴー]+\z/u', 'max:20'],
            'phone1' => ['nullable', 'regex:/\A[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}\z/u'],
            'phone1_relationship' => ['nullable', 'max:20'],
            'phone2' => ['nullable', 'regex:/\A[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}\z/u'],
            'phone2_relationship' => ['nullable', 'max:20'],
            'email' => ['nullable', 'email:strict,dns', 'max:80'],
            'remarks' => ['nullable', 'max:200'],
        ];
    }
}
