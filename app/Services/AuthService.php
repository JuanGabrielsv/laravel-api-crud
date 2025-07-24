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

    /**
     * Crea un nuevo usuario y devuelve el modelo del usuario creado.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function register(string $name, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            // Nota: El rol por defecto será 'user' gracias a la configuración de la migración.
            // No permitimos que el usuario elija su rol al registrarse.
        ]);
    }
}
