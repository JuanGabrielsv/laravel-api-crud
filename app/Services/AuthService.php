<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Intenta autenticar a un usuario y devuelve un token de API si tiene éxito.
     *
     * @param string $email
     * @param string $password
     * @return string
     * @throws ValidationException
     */
    public function login(string $email, string $password): string
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            // Lanza una excepción si las credenciales son incorrectas.
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        // Devuelve el token de texto plano.
        return $user->createToken('auth_token')->plainTextToken;
    }
}
