<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * Регистрация пользователя
     * 
     * @param RegisterRequest $request
     * 
     * @return Response
     */
    public function register(RegisterRequest $request): Response
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            User::create($data);
            return new Response([$data], Response::HTTP_CREATED);
        } catch(\Exception $e){
            
            return new Response(['error' => $e->getMessage()],$e->getCode());
        }
        
    }
}
