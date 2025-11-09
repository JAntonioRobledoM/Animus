<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Saga extends Model
{
    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'color',
        'posicion',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recuerdos(): HasMany
    {
        return $this->hasMany(Recuerdo::class);
    }
}
