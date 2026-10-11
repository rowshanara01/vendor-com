<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','min:4'],
            'email' => ['required','email','unique:users'],
            'phone' => ['required','unique:users,phone','min:11','max:15'],
            'password' => ['required','confirmed'],
        ];
    }
}
