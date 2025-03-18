<?php

namespace App\Filament\Resources\EmpenhoResource\Pages;

use App\Filament\Resources\EmpenhoResource;
use App\Services\Empenho\EmpenhoService;
use App\Services\ItemEmpenho\ItemEmpenhoService;
use Error;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use SebastianBergmann\Timer\Timer;

class ViewEmpenho extends ViewRecord
{
    protected static string $resource = EmpenhoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importar')
                ->label('Atualizar Itens')
                ->color('info')  // Cor do botão
                ->action(function ($record) {
                    try {
                        $empenho = $record;
                        ItemEmpenhoService::refreshItens($empenho);
                        $this->redirect(request()->header('Referer'));
                        Notification::make()->title('Os itens foram atualizados!')->success()->send();
                    } catch (Error $e) {
                        Notification::make()->title('Erro')->body($e->getMessage());
                    }

                }),
        ];
    }
}
