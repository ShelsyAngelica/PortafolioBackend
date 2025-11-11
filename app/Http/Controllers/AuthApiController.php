<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Metodo para iniciar sesion
     */
    public function login (StoreAuthRequest $request)
    {
        try {

            $result = $this->authService->login($request->validated());

            if (!$result['success']) {
                return response()->json(['message' => $result['message']], 401);
            }
    
            return response()->json([
                'message' => 'Usuario logueado exitosamente',
                'user' => $result['user'],
                'token' => $result['token']
            ]);

        } catch (\Exception $e) {
            
            return response()->json([
                'message' => 'Error al loguear usuario',
                'error'   => $e->getMessage() 
            ],500);

        }
    }

    //metodo para cerrar sesion
    public function logout(Request $request)
    {
        try {
            $result = $this->authService->logout($request->user());
            return response()->json([
                'message' => 'Se cerro sesión'
            ], 200);
        } 
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}

