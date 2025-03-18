<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_id',
        'data_pedido',
        'valor_total',
        'status',
        'observacoes',
    ];

    public function atualizarValorTotal()
    {
        $valorTotal = $this->itens()->sum('valor_total');

        $this->update(['valor_total' => $valorTotal]);
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function itensEmpenho(): HasManyThrough
    {
        return $this->hasManyThrough(
            ItemEmpenho::class,
            Fornecedor::class
        );
    }
}
