<?php

namespace App\Utils\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait FailedValidation
{
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     *
     */
    function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        if ($errors) {
            foreach ($errors as $value ) {
                throw new HttpResponseException(response()->json(
                    [
                        'message' => $value[0]
                    ],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                );
            }
        }
    }
}
