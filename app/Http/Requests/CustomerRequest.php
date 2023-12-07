<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dni'=>['required','string', 'max:45'],
            'id_reg'=>['required','numeric', 'exists:regions'],
            'id_com'=>[
                'required',
                'numeric',
                'exists:communes',
                Rule::exists('communes', 'id_com')->where(function ($query) {
                    $query->where('id_reg', $this->input('id_reg'));
                })],
            'email'=>['required','string','email','max:120'],
            'name'=>['required','string', 'max:45'],
            'last_name'=>['required','string', 'max:45'],
            'address'=>['required','string', 'max:255'],
        ];
    }
}
