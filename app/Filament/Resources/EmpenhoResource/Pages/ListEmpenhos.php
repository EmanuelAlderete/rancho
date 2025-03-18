<?php

namespace App\Filament\Resources\EmpenhoResource\Pages;

use App\Services\ApiTransparenciaService;
use App\Filament\Resources\EmpenhoResource;
use App\Services\Empenho\EmpenhoService;
use Error;
use ErrorException;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Log;
use Exception;

class ListEmpenhos extends ListRecords
{
    protected static string $resource = EmpenhoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importar')
                ->label('Importar Empenhos')
                ->color('success')  // Cor do botão
                ->modalHeading('Importar Empenho')
                ->modalSubmitActionLabel('Importar')
                ->modalSubheading('Aqui você pode importar empenhos diretamente da API do Portal da Transparência')
                ->form([
                    Grid::make('3')
                        ->schema([
                            Select::make('ug')
                                ->label('Unidade Gestora')
                                ->options([
                                    '160362' => '160362',
                                    '167362' => '167362'
                                ])
                                ->default('160362')
                                ->required(),
                            Select::make('ano')
                                ->label('Ano')
                                ->options([
                                    '2023' => '2023',
                                    '2024' => '2024',
                                    '2025' => '2025',
                                ])
                                ->default('2025')
                                ->required(),
                            TextInput::make('empenho')
                                ->label('Nº Empenho')
                                ->mask('NE 999 999')
                                ->required()
                                ->placeholder('NE 000 000')
                                ->minLength(10)
                        ])
                ])
                ->action(function (array $data) {
                    try {
                        $empenho = EmpenhoService::importEmpenho($data);

                        if ($empenho->wasRecentlyCreated ?? $empenho->created_at->eq($empenho->updated_at)) {
                            Notification::make()
                                ->title('Empenho importado com sucesso!')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Dados do empenho atualizados!')
                                ->info()
                                ->send();
                        }
                    } catch (ErrorException $e) {
                        Notification::make()
                            ->title('Erro ao importar empenho!')
                            ->icon('heroicon-o-exclamation-circle')
                            ->body($e->getMessage())
                            ->send();
                    }


                }),
        ];
    }
}
