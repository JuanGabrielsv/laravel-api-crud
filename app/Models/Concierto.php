<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concierto extends Model
{
    use HasFactory;

    protected $table = 'concierto';

    protected $fillable = [
        'titulo',
        'lugar',
        'fecha_concierto',
        'es_gratis',
        'precio_concierto',
    ];
}
