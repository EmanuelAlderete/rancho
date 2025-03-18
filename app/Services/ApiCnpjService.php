<?php

namespace App\Services;
use App\Models\ItemEmpenho;
use Error;
use ErrorException;
use Exception;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;

class ApiCnpjService
{
    public static function getCnpjData(string $cnpj): array
    {
        $response = Http::retry(3, 100)
            ->timeout(15)
            ->get(env('API_CNPJ_URL') . '/cnpj/v1/' . $cnpj);

        return $response->json();

        if ($response->successful() && $response->json() != []) {
            return $response->json();
        } else {
            throw new ErrorException('Não foi possível encontrar o CNPJ: ' . $cnpj, $response->status());
        }
    }
}
