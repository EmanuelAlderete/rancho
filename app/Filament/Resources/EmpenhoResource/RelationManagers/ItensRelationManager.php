<?php

namespace App\Filament\Resources\EmpenhoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItensRelationManager extends RelationManager
{
    protected static string $relationship = 'itens';
    protected static ?string $title = 'Itens do Empenho';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                    ->label('Descrição do Item')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('valor_unitario')
                    ->label('Valor Unitário')
                    ->prefix('R$')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('quantidade')
                    ->label('Quantidade')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('valor_total')
                    ->label('Valor Total')
                    ->prefix('R$')
                    ->required()
                    ->columnSpan(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('sequencial')
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->sortable()
                    ->searchable()
                    ->limit(60)
                    ->wrap(),
                Tables\Columns\BadgeColumn::make('valor_unitario')
                    ->label('Valor Unitário')
                    ->color('info')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('quantidade')
                    ->label('Quantidade')
                    ->color('info')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('valor_total')
                    ->label('Valor Total')
                    ->color('info')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
