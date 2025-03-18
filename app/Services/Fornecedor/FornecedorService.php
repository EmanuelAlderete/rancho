<?php

namespace App\Services\Fornecedor;
use App\Models\Fornecedor;
use App\Services\ApiCnpjService;

class FornecedorService
{
    public static function importFornecedor(string $cnpj)
    {
        $api_data = ApiCnpjService::getCnpjData($cnpj);

        $data = [
            'razao' => $api_data['razao_social'],
            'cidade' => $api_data['municipio'],
            'uf' => $api_data['uf'],
            'celular' => $api_data['ddd_telefone_1'],
            'telefone' => $api_data['ddd_telefone_2'],
            // 'email' => $api_data['emails'][0]['address'],
            'cnpj' => $api_data['cnpj'],
        ];

        return Fornecedor::updateOrCreate([
            'cnpj' => $data['cnpj'],
        ], $data);
    }

    public static function createFornecedor(array $data)
    {
        $data_favorecido = [
            'razao' => $data['nome_favorecido'],
            'cnpj' => $data['codigo_favorecido'],
        ];

        return Fornecedor::updateOrCreate([
            'cnpj' => $data['codigo_favorecido'],
        ], $data_favorecido);
    }
}