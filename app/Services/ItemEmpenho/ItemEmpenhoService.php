<?php

namespace App\Services\ItemEmpenho;

use App\Models\Empenho;
use App\Models\ItemEmpenho;
use App\Services\ApiTransparenciaService;
use App\Services\Empenho\EmpenhoService;

class ItemEmpenhoService
{

    public static function refreshItens(Empenho $empenho)
    {

        $itens_api = ApiTransparenciaService::getItensEmpenho($empenho->documento);

        foreach ($itens_api as $item) {

            $data = [
                'empenho_id' => $empenho->id,
                'codigo_item' => $item['codigoItemEmpenho'],
                'descricao' => substr($item['descricao'], 21),
                'valor_atual' => $item['valorAtual'],
                'sequencial' => $item['sequencial'],
                // 'quantidade' => $item['quantidade'],
                // 'valor_unitario' => $item['valorUnitario'],
                // 'valor_total' => $item['valorTotal'],
            ];

            $itemEmpenho = ItemEmpenho::updateOrCreate([
                'codigo_item' => $item['codigoItemEmpenho'],
                'sequencial' => $item['sequencial'],
            ], $data);

            ItemEmpenhoService::refreshHistoricoItem($itemEmpenho);
        }

        return $empenho;
    }

    public static function refreshHistoricoItem(ItemEmpenho $itemEmpenho)
    {
        $itens_api = ApiTransparenciaService::getHistoricoItem($itemEmpenho);

        foreach ($itens_api as $item) {

            $data = [
                'quantidade' => $item['quantidade'],
                'valor_unitario' => $item['valorUnitario'],
                'valor_total' => $item['valorTotal'],
            ];

            $itemEmpenho->update($data);
            $itemEmpenho->save();
        }
    }
}