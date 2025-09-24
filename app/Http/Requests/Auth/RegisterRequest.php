<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required','string', 'max:25'],
            'email'    => ['required', 'email','unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }



    /**
     * Обработка неудачной валидации для API
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->getMessageBag(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY) // 422
        );
    }
}