<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        // Obtenemos los datos ya validados desde el Form Request.
        $validated = $request->validated();

        try {
            // Pasamos los datos validados al servicio.
            $token = $this->authService->login($validated['email'], $validated['password']);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

        } catch (ValidationException $e) {
            // Este catch ahora solo se activará si el AuthService lanza la excepción
            // (es decir, si las credenciales son incorrectas).
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
