<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GeneroMusical extends Model
{
    /** @use HasFactory<\Database\Factories\GeneroMusicalFactory> */
    use HasFactory;

    protected $table = 'genero_musical';

    protected $fillable = [
        'nombre',
    ];

    public function bandas(): BelongsToMany
    {
        return $this->belongsToMany(Banda::class, 'banda_genero_musical')->withTimestamps();
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getFechaConciertoAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }
}
