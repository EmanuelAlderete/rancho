<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empenho extends Model
{
    protected $fillable = [
        'data',
        'documento',
        'documento_resumido',
        'observacao',
        'valor',
        'fornecedor_id',
    ];

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function itens(): HasMany
    {
        return $this->hasMany(ItemEmpenho::class);
    }
}
