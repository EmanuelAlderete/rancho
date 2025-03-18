<?php

namespace App\Filament\Resources\EmpenhoResource\Pages;

use App\Filament\Resources\EmpenhoResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditEmpenho extends EditRecord
{
    protected static string $resource = EmpenhoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
