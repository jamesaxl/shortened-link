<?php

namespace App\Http\Requests\Link;

use App\Utils\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'address' => 'required|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => __('address.required'),
            'address.url' => __('address.url'),
            'address.max' => __('address.max'),
        ];
    }
}
