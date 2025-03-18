<?php

namespace App\Services;
use App\Models\ItemEmpenho;
use Error;
use ErrorException;
use Exception;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiTransparenciaService
{
    public static function getEmpenho(array $data)
    {
        $documento = $data['ug'] . '00001' . $data['ano'] . str_replace(' ', '', $data['empenho']);

        try {
            $response = Http::retry(3, 2000) // 3 tentativas com 2 segundos de intervalo
                ->withHeaders([
                    'chave-api-dados' => env('API_GOV_TOKEN'),
                ])
                ->timeout(30)
                ->get(env('API_GOV_URL') . '/api-de-dados/despesas/documentos/' . $documento);

            if ($response->successful()) {
                $responseData = $response->json();

                if (is_array($responseData) && !empty($responseData)) {
                    return $responseData;
                }
            }

            Log::warning('Empenho não encontrado ou resposta inválida.', [
                'documento' => $documento,
                'status' => $response->status(),
                'erro' => $response->body(),
            ]);

            throw new ErrorException('Não foi possível encontrar o empenho: ' . $data['ano'] . str_replace(' ', '', $data['empenho']), $response->status());

        } catch (Exception $e) {
            Log::error('Erro na requisição do empenho', [
                'documento' => $documento,
                'erro' => $e->getMessage(),
            ]);

            throw new ErrorException('Erro ao buscar o empenho. Tente novamente mais tarde!');
        }
    }

    public static function getItensEmpenho(string $documento)
    {
        $data = [];
        $helper = true;

        for ($page = 1; $helper; $page++) {

            try {
                $response = Http::retry(3, 2000) // 3 tentativas com 2 segundos de intervalo
                    ->withHeaders([
                        'chave-api-dados' => env('API_GOV_TOKEN'),
                    ])
                    ->timeout(30)
                    ->get(env('API_GOV_URL') . '/api-de-dados/despesas/itens-de-empenho', [
                        'codigoDocumento' => $documento,
                        'pagina' => $page,
                    ]);

                if (!$response->successful()) {
                    Log::error('Falha na requisição', [
                        'documento' => $documento,
                        'pagina' => $page,
                        'status' => $response->status(),
                        'erro' => $response->body(),
                    ]);

                    throw new ErrorException('Falha na comunicação com a API.');
                }

                $responseData = $response->json();
                $data = array_merge($data, $responseData);

                if (empty($responseData)) {
                    $helper = false;
                }
            } catch (Exception $e) {
                Log::error('Erro na requisição de itens de empenho', [
                    'documento' => $documento,
                    'pagina' => $page,
                    'erro' => $e->getMessage(),
                ]);

                throw new ErrorException('Parece que o sistema do Portal da Transparência está fora do ar. Tente novamente mais tarde.');
            }
        }

        return $data;
    }

    public static function getHistoricoItem(ItemEmpenho $itemEmpenho)
    {
        $data = [];
        $helper = true;

        for ($page = 1; $helper; $page++) {

            try {
                $response = Http::retry(3, 2000) // 3 tentativas com 2 segundos de intervalo
                    ->withHeaders([
                        'chave-api-dados' => env('API_GOV_TOKEN'),
                    ])
                    ->timeout(30)
                    ->get(env('API_GOV_URL') . '/api-de-dados/despesas/itens-de-empenho/historico', [
                        'codigoDocumento' => $itemEmpenho->codigo_item,
                        'sequencial' => $itemEmpenho->sequencial,
                        'pagina' => $page,
                    ]);

                if (!$response->successful()) {
                    Log::error('Falha na requisição', [
                        'codigo_item' => $itemEmpenho->codigo_item,
                        'sequencial' => $itemEmpenho->sequencial,
                        'pagina' => $page,
                        'status' => $response->status(),
                        'erro' => $response->body(),
                    ]);

                    throw new ErrorException('Falha na comunicação com a API.');
                }

                $responseData = $response->json();
                $data = array_merge($data, $responseData);

                if (empty($responseData)) {
                    $helper = false;
                }
            } catch (Exception $e) {
                Log::error('Erro na requisição do histórico do item', [
                    'codigo_item' => $itemEmpenho->codigo_item,
                    'sequencial' => $itemEmpenho->sequencial,
                    'pagina' => $page,
                    'erro' => $e->getMessage(),
                ]);

                throw new ErrorException('Não foi possível atualizar o histórico do item. Tente mais tarde!');
            }
        }

        return $data;
    }
}
