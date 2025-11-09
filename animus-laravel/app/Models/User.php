<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * Los atributos que deben estar ocultos para los arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'password' => 'hashed',
    ];
    
    /**
     * Obtiene los recuerdos que pertenecen a este usuario.
     */
    public function recuerdos(): HasMany
    {
        return $this->hasMany(Recuerdo::class);
    }

    /**
     * Obtiene las sagas que pertenecen a este usuario.
     */
    public function sagas(): HasMany
    {
        return $this->hasMany(Saga::class);
    }
}