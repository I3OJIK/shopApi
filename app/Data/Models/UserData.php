<?php

namespace App\Data\Models;

use App\Data\BaseData;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UserData",
    required: ["id", "name", "email", "role", "created_at", "updated_at"]
)]
class UserData extends BaseData
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "string", example: "John Doe")]
    public string $name;

    #[OA\Property(type: "string", format: "email", example: "john@example.com")]
    public string $email;

    #[OA\Property(type: "string", example: "user")]
    public string $role;

    #[OA\Property(type: "string", format: "date-time", example: "2025-10-03 13:41:09")]
    public string $createdAt;
}