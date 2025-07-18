<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banda extends Model
{
    use HasFactory;

    protected $table = 'banda';

    protected $fillable = [
        'nombre',
        'genero',
    ];

    public function concierto(): HasMany
    {
        return $this->hasMany(Concierto::class, 'banda_id');
    }
}
