<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificacions';

    protected $fillable = [
        'user_id',
        'titulo',
        'contenido',
        'tipo',
        'leida',
        'programada_en'
    ];

    protected $casts = [
        'programada_en' => 'datetime',
        'leida' => 'boolean'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
