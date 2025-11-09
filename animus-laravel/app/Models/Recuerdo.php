<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recuerdo extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'saga_id',
        'img',
        'title',
        'subtitle',
        'path',
        'position',
        'year',
        'lugar',
        'latitud',
        'longitud',
        'necesita_app_externa',
        'ruta_app_externa',
    ];

    /**
     * Obtiene el usuario al que pertenece este recuerdo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene la saga a la que pertenece este recuerdo.
     */
    public function saga(): BelongsTo
    {
        return $this->belongsTo(Saga::class);
    }
}