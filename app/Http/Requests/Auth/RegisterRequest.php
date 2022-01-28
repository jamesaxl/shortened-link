<?php

namespace App\Http\Requests\Auth;

use App\Utils\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:255|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('email.required'),
            'email.email' => __('email.email'),
            'email.unique' => __('email.unique'),
            'email.max' => __('email.max'),
            'password.required' => __('password.required'),
            'password.confirmed' => __('password.confirmed'),
            'password.unique' => __('password.unique'),
            'password.max' => __('password.max'),
        ];
    }
}
