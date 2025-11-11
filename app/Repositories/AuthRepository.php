<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{   
    public function attemptLogin(array $data)
    {
        // Buscar usuario por email
        $user = User::where('email', $data['email'])->first();

        // Validar contraseña
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function createToken(User $user)
    {
        return $user->createToken('api_token')->plainTextToken;
    }

    public function logout($user)
    {
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
    }


}