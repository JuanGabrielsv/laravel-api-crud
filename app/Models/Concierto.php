<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concierto extends Model
{
    use HasFactory;

    protected $table = 'concierto';

    protected $fillable = [
        'titulo',
        'lugar',
        'fecha_concierto',
        'precio_entrada',
        'banda_id'
    ];

    public function banda(): BelongsTo
    {
        return $this->belongsTo(Banda::class, 'banda_id');
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
