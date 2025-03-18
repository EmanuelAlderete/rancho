<?php

namespace App\Filament\Forms;

use App\Models\Fornecedor;
use App\Models\ItemEmpenho;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;

class PedidoForm
{
    public static function schema(): array
    {
        return [
            Fieldset::make('Dados Básicos')
                ->schema([
                    Select::make('fornecedor_id')
                        ->label('Fornecedor')
                        ->relationship('fornecedor', 'razao')
                        ->options(fn() => Fornecedor::whereHas('itensEmpenho', function ($query) {
                            $query->where('quantidade_disponivel', '>', 0);
                        })->pluck('razao', 'id')->toArray())
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $set('item_empenho_id', null); // Resetando o campo item_empenho_id após selecionar fornecedor
                        }),
                    DatePicker::make('data_pedido')
                        ->label('Data')
                        ->default(now())
                ]),
            Repeater::make('itens')
                ->visible(fn(Get $get) => filled($get('fornecedor_id')))
                ->columnSpanFull()
                ->label('Lista de Itens')
                ->cloneable()
                ->relationship('itens')
                ->schema([
                    Grid::make('')
                        ->schema([
                            Select::make('item_empenho_id')
                                ->label('Itens Disponíveis')
                                ->options(function (Get $get) {
                                    $fornecedorId = $get('fornecedor_id');
                                    if ($fornecedorId) {
                                        return ItemEmpenho::whereHas('empenho', function ($query) use ($fornecedorId) {
                                            $query->where('fornecedor_id', $fornecedorId)
                                                ->where('quantidade_disponivel', '>', 0);
                                        })->pluck('descricao', 'id')->toArray();
                                    }
                                    return [];
                                })
                        ])
                ])
        ];
    }
}
