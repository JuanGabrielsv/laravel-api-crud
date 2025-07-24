<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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

    /**
     * Maneja la petición de registro de un nuevo usuario.
     */
    public function register(RegisterRequest $request)
    {
        // La validación ya ha sido hecha por RegisterRequest.
        $validated = $request->validated();

        // Llamamos al servicio para crear el usuario.
        $user = $this->authService->register(
            $validated['name'],
            $validated['email'],
            $validated['password']
        );

        // Devolvemos el usuario recién creado con un código de estado 201 Created.
        return response()->json($user, 201);
    }
}
