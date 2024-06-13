<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            //     TextInput::make('order_number')
            // ->readOnly(),
            // Select::make('user_id')
            // ->relationship('user', 'name'),
            // TextInput::make('ip_address'),
            // TextInput::make('first_name'),
            // TextInput::make('last_name'),
            // TextInput::make('email'),
            // TextInput::make('phone'),
            // Select::make('shipping_address_id')
            // ->relationship('user', 'name'),
            // Select::make('shipping_id'),
            // Select::make('payment_method'),
            // Select::make('payment_status'),
            // Select::make('status'),
            // Select::make('coupon_id'),
            // TextInput::make('sub_total'),
            // TextInput::make('discount'),
            // TextInput::make('total_amount'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number'),
                TextColumn::make('customer_name'),
                TextColumn::make('ip_address'),
                TextColumn::make('customer_email'),
                TextColumn::make('phone'),
                TextColumn::make('shippingAddress.post_code'),
                TextColumn::make('shipping.type'),
                TextColumn::make('payment_method'),
                TextColumn::make('payment_status'),
                TextColumn::make('status'),
                TextColumn::make('coupon.code'),
                TextColumn::make('sub_total'),
                TextColumn::make('discount'),
                TextColumn::make('total_amount'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
