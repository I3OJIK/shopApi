<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Api shop',
)]


#[OA\Tag(
    name: "Registration",
    description: "Регистрация пользователей"
)]

#[OA\Tag(
    name: "Auth",
    description: "Авторизация пользователей"
)]

#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]

abstract class Controller
{
}
