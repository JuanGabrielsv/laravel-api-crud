<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banda extends Model
{
    use HasFactory;

    protected $table = 'banda';

    protected $fillable = [
        'nombre',
        'idioma',
        'user_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    | TODAS las relaciones que tiene Banda.
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function concierto(): HasMany
    {
        return $this->hasMany(Concierto::class, 'banda_id');
    }

    public function generos(): BelongsToMany
    {
        return $this->belongsToMany(GeneroMusical::class, 'banda_genero_musical')->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS VARIOS
    | Aquí van los métodos especiales como formateo de fecha.
    |--------------------------------------------------------------------------
    */

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }
}
