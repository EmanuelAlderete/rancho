<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FornecedorResource\Pages;
use App\Filament\Resources\FornecedorResource\RelationManagers;
use App\Models\Fornecedor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FornecedorResource extends Resource
{
    protected static ?string $model = Fornecedor::class;

    protected static ?string $modelLabel = 'fornecedor';
    protected static ?string $pluralModelLabel = 'fornecedores';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('razao')
                    ->label('Razão Social')
                    ->required(),
                Forms\Components\TextInput::make('cidade')
                    ->label('Cidade')
                    ->required(),
                Forms\Components\TextInput::make('uf')
                    ->label('UF')
                    ->required(),
                Forms\Components\TextInput::make('telefone')
                    ->label('Telefone')
                    ->tel(),
                Forms\Components\TextInput::make('celular')
                    ->label('Celular')
                    ->tel(),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('cnpj')
                    ->label('CNPJ')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('razao')
                    ->searchable()
                    ->label('Razão Social'),
                Tables\Columns\TextColumn::make('cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uf')
                    ->label('UF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('celular')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->searchable()
                    ->label('E-mail'),
                Tables\Columns\TextColumn::make('cnpj')
                    ->copyable()
                    ->label('CNPJ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFornecedors::route('/'),
            'create' => Pages\CreateFornecedor::route('/create'),
            'edit' => Pages\EditFornecedor::route('/{record}/edit'),
        ];
    }
}
