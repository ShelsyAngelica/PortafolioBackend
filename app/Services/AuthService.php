<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;

class AuthService
{
    protected $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(array $data)
    {
        
        $user = $this->repository->attemptLogin($data);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Usuario o contraseña incorrectos',
            ];
        }

        $token = $this->repository->createToken($user);

        return [
            'success' => true,
            'message' => 'Usuario logueado exitosamente',
            'user' => $user,
            'token' => $token,
        ];

    }    

        //metodo para cerrar sesion
        public function logout(User $user)
        {
            return $this->repository->logout($user);
        }
}
