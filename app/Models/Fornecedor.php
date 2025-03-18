<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    protected $fillable = [
        'razao',
        'cidade',
        'uf',
        'telefone',
        'celular',
        'email',
        'cnpj',
    ];

    public function empenhos(): HasMany
    {
        return $this->hasMany(Empenho::class);
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    public function itensEmpenho(): HasManyThrough
    {
        return $this->hasManyThrough(ItemEmpenho::class, Empenho::class);
    }
}
