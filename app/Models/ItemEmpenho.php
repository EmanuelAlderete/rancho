<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemEmpenho extends Model
{
    protected $fillable = [
        'empenho_id',
        'codigo_item',
        'descricao',
        'valor_atual',
        'sequencial',
        'quantidade',
        'quantidade_disponivel',
        'valor_unitario',
        'valor_total',
    ];

    public function empenho(): BelongsTo
    {
        return $this->belongsTo(Empenho::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->quantidade_disponivel = $item->quantidade;
        });
    }

    public function fornecedor()
    {
        return $this->hasOneThrough(
            Fornecedor::class,
            Empenho::class,
            'id',
            'id',
            'empenho_id',
            'fornecedor_id'
        );
    }
}
