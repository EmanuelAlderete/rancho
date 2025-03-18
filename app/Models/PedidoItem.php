<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PedidoItem extends Model
{
    use HasFactory;

    protected $table = 'pedido_itens';

    protected $fillable = ['pedido_id', 'item_empenho_id', 'quantidade', 'valor_unitario', 'valor_total'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function itemEmpenho()
    {
        return $this->hasOne(ItemEmpenho::class);
    }

    public function fornecedor()
    {
        return $this->hasOneThrough(
            related: Fornecedor::class,
            through: Pedido::class,
            firstKey: 'id',
            secondKey: 'id',
            localKey: 'pedido_id',
            secondLocalKey: 'fornecedor_id'
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->valor_total = $item->quantidade * $item->valor_unitario;
        });
    }
}
