<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; //Añadir esta línea para que User pueda manejar Tokens.

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable; // Hay que añadir HasApiTokens aquí.

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define la relación "hasMany" con Concierto.
     * Un usuario puede tener muchos conciertos.
     */
    public function conciertos() // <-- ¡AÑADE ESTA RELACIÓN!
    {
        return $this->hasMany(Concierto::class);
    }

    /**
     * Si también tienes la relación con Banda, debería estar aquí.
     */
    public function bandas()
    {
        return $this->hasMany(Banda::class);
    }
}
