<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpenhoResource\Pages;
use App\Filament\Resources\EmpenhoResource\RelationManagers;
use App\Models\Empenho;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\NumberInput;
use Filament\Tables\Actions\Action;

class EmpenhoResource extends Resource
{
    protected static ?string $model = Empenho::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Formulário de Cadastro
                TextInput::make('documento')
                    ->label('Número do Documento')
                    ->required()
                    ->maxLength(255),

                TextInput::make('documento_resumido')
                    ->label('Documento Resumido')
                    ->nullable()
                    ->maxLength(255),

                DatePicker::make('data')
                    ->label('Data do Empenho')
                    ->required()
                    ->default(now())
                    ->format('Y-m-d'),

                Textarea::make('observacao')
                    ->label('Observação')
                    ->nullable()
                    ->maxLength(500),

                Select::make('fornecedor_id')
                    ->label('Favorecido')
                    ->relationship('fornecedor', 'razao')
                    ->required(),

                TextInput::make('valor')
                    ->label('Valor')
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('documento_resumido')
                    ->label('NE')
                    ->sortable(),
                TextColumn::make('fornecedor.razao')
                    ->label('Favorecido')
                    ->copyable()
                    ->icon('heroicon-o-clipboard'),
                TextColumn::make('valor')
                    ->money('BRL')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItensRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmpenhos::route('/'),
            'create' => Pages\CreateEmpenho::route('/create'),
            'view' => Pages\ViewEmpenho::route('/{record}'),
            // 'edit' => Pages\EditEmpenho::route('/{record}/edit'),
        ];
    }
}
