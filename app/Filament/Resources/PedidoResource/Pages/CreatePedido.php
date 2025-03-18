<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use App\Models\Pedido;
use App\Models\PedidoItem;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePedido extends CreateRecord
{
    protected static string $resource = PedidoResource::class;

    // protected function handleRecordCreation(array $data): Model
    // {
    //     $pedido = null;

    //     $itensPorFornecedor = collect($data)
    //         ->flatten(1)
    //         ->groupBy('fornecedor_id');

    //     foreach ($itensPorFornecedor as $fornecedorId => $itens) {
    //         $pedido = Pedido::create([
    //             'fornecedor_id' => $fornecedorId,
    //             'data_pedido' => now(),
    //             'status' => 'pendente',
    //         ]);

    //         foreach ($itens as $item) {
    //             PedidoItem::create([
    //                 'pedido_id' => $pedido->id,
    //                 'item_empenho_id' => $item['item'],
    //                 'quantidade' => $item['quantidade'],
    //                 'valor_unitario' => (float) str_replace(',', '.', $item['valor_unitario']),
    //                 'valor_total' => (float) str_replace(',', '.', $item['valor_total']),
    //             ]);
    //         }

    //         $pedido->atualizarValorTotal();
    //     }

    //     return $pedido;
    // }
}
