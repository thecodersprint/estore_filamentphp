<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
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
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\TagsRelationManager;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

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
                    ->maxLength(150),
                FileUpload::make('photo')
                    ->image()
                    ->directory('posts/thumbnails')
                    ->columnSpanFull(),
                RichEditor::make('summary')
                    ->required()
                    ->fileAttachmentsDirectory('posts/images')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->required()
                    ->fileAttachmentsDirectory('posts/images')
                    ->columnSpanFull(),
                TextInput::make('quote')
                    ->required()
                    ->maxLength(255),
                Select::make('post_cat_id')
                    ->required()
                    ->label('Category')
                    ->relationship('category', 'title')
                    ->searchable(),
                    Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'title')
                    ->searchable()
                    ->multiple(),
                    Select::make('status')
                    ->required()
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active'),
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
            TagsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
