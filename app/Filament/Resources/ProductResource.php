<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->live('', "1000ms")
                    ->required()
                    ->minLength(5)
                    ->maxLength(150)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                        if ($operation == 'string') {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                FileUpload::make('photo')
                    ->image()
                    ->multiple()
                    ->directory('products/thumbnails')
                    ->columnSpanFull(),
                RichEditor::make('summary')
                    ->required()
                    ->fileAttachmentsDirectory('products/images')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->required()
                    ->fileAttachmentsDirectory('products/images')
                    ->columnSpanFull(),
                Select::make('size')
                    ->required()
                    ->multiple()
                    ->options(['M' => 'Medium', 'L' => 'Large', 'S' => 'Small', 'xl' => 'xtra large'])
                    ->columnSpanFull(),
                TextInput::make('stock')
                    ->required()
                    ->type('number')
                    ->columnSpanFull(),
                Select::make('is_featured')
                    ->required()
                    ->options([true => 'Yes', false => 'No'])
                    ->columnSpanFull(),
                Select::make('condition')
                    ->required()
                    ->options(['default' => 'Default', 'new' => 'New', 'hot' => 'Hot'])
                    ->columnSpanFull(),
                Select::make('cat_id')
                    ->required()
                    ->relationship('category', 'title')
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn ($set) => $set('child_cat_id', null)),
                Select::make('child_cat_id')
                    ->required()
                    ->searchable()
                    ->label('Child Category')
                    ->options(function ($get) {
                        $parentCategoryId = $get('cat_id');
                        if ($parentCategoryId) {
                            return \App\Models\Category::where('parent_id', $parentCategoryId)->pluck('title', 'id');
                        }
                        return [];
                    }),
                TextInput::make('price')
                    ->required()
                    ->type('number'),
                Select::make('brand_id')
                    ->required()
                    ->relationship('brand', 'title')
                    ->searchable(),
                TextInput::make('discount')
                    ->required()
                    ->type('number')
                    ->maxLength(255),
                Select::make('status')
                    ->required()
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active')
                    ->columnSpanFull(),
                // TextInput::make('status')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('category.title')->sortable(),
                TextColumn::make('stock')->sortable(),
                TextColumn::make('condition')->sortable(),
                TextColumn::make('created_at')->date('d-M-Y')->sortable(),
                TextColumn::make('updated_at')->date('d-M-Y')->sortable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
