<?php

namespace App\Filament\Resources;

use App\Enums\StatusEnum;
use App\Filament\Resources\PostsResource\Pages;
use App\Filament\Resources\PostsResource\RelationManagers;
use App\Models\Posts;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Markdown;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsResource extends Resource
{
    protected static ?string $model = Posts::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(1)
                    ->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('slug')->required(),
                        FileUpload::make('thumbnail')->required()
                            ->image()
                            ->disk('public')
                            ->directory('thumnails')
                            ->visibility('public'),
                    ]),
                Section::make()
                    ->columns(1)
                    ->schema([
                        Textarea::make('brief_description')->required()->maxLength(255),
                        MarkdownEditor::make('content')
                            ->extraAttributes(['style' => 'height:500px !important'])
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'heading',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'table',
                                'undo',

                            ])->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('post')
                            ->fileAttachmentsVisibility('public'),


                        Select::make('tags')
                            ->options([
                                'tags1'   => 'Tags 1',
                                'tags2' => 'Tags 2',
                                'Tags3' => 'Tags 3',

                            ])
                            ->multiple()
                            ->searchable(),
                        Select::make('categories')
                            ->options([
                                'category1'   => 'Category 1',
                                'category2' => 'Category 2',
                                'category3' => 'Category 3',

                            ])
                            ->multiple()
                            ->searchable()
                    ]),
                Section::make()
                    ->columns(1)
                    ->schema([
                        TextInput::make('meta_title')->required(),
                        Textarea::make('meta_description')->required(),
                    ]),
                Section::make()
                    ->columns(1)
                    ->schema([
                        Select::make('author_id')
                            ->label('Author')
                            ->options(User::latest()
                                ->get()
                                ->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('status')
                            ->options(StatusEnum::class)
                    ]),





            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('brief_description'),
                TextColumn::make('status'),

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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePosts::route('/create'),
            'edit' => Pages\EditPosts::route('/{record}/edit'),
        ];
    }
}
