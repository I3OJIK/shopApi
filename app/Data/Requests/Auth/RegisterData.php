<?php

namespace App\Data\Requests\Auth;

use App\Data\BaseData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterData",
    required: ["name", "email", "password"]
)]
class RegisterData extends BaseData
{
    #[Required]
    #[OA\Property(type: "string", example: "John Doe")]
    public string $name;

    #[Required, Email, Unique('users', 'email')]
    #[OA\Property(type: "string", format: "email", example: "john@example.com")]
    public string $email;

    #[Required, Min(6)]
    #[OA\Property(type: "string", format: "password", example: "secret123")]
    public string $password;
}