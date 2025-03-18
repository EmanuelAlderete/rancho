<?php

namespace App\Services\Empenho;

use App\Models\Empenho;
use App\Services\ApiTransparenciaService;
use App\Services\Fornecedor\FornecedorService;
use App\Services\ItemEmpenho\ItemEmpenhoService;

class EmpenhoService
{
    public static function importEmpenho(array $data)
    {
        $api_data = ApiTransparenciaService::getEmpenho($data);

        $data = [
            'data' => $api_data['data'],
            'documento' => $api_data['documento'],
            'documento_resumido' => $api_data['documentoResumido'],
            'observacao' => $api_data['observacao'],
            'favorecido' => $api_data['favorecido'],
            'codigo_favorecido' => $api_data['codigoFavorecido'],
            'nome_favorecido' => $api_data['nomeFavorecido'],
            'valor' => $api_data['valor'],
        ];
        if (strlen($api_data['codigoFavorecido']) != 14) {
            $fornecedor = FornecedorService::importFornecedor(str_replace(['.', '/', '-'], '', $data['codigo_favorecido']));

        } else {
            $fornecedor = FornecedorService::createFornecedor($data);
        }



        $data = array_merge($data, ['fornecedor_id' => $fornecedor->id]);

        $empenho = Empenho::updateOrCreate([
            'documento' => $data['documento'],
        ], $data);

        $empenho = ItemEmpenhoService::refreshItens($empenho);

        return $empenho;
    }
}