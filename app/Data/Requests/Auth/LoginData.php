<?php

namespace App\Data\Requests\Auth;

use App\Data\BaseData;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "LoginData",
    required: ["email", "password"]
)]
class LoginData extends BaseData
{
    #[Required, Email, Exists('users', 'email')]
    #[OA\Property(type: "string", format: "email", example: "john@example.com")]   
    public string $email;

    #[Required]
    #[OA\Property(type: "string", format: "password", example: "secret123")]
    public string $password;
}