<?php

namespace App\Http\Requests\Auth;

use App\Utils\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('email.required'),
            'email.email' => __('email.email'),
            'email.max' => __('email.max'),
            'password.required' => __('password.required'),
            'password.max' => __('password.max'),
        ];
    }
}
