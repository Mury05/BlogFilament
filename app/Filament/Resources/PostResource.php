<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use Filament\Forms\Components\SpatieTagsInput;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use App\Models\Tag;
use App\Filament\Resources\PostResource\Pages\ManagePostComments;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;    
use Filament\Modals\Modal;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use View;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Blog Management';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))), // Génération automatique du slug

                Forms\Components\TextInput::make('slug')
                ->readonly()
                    ->maxLength(255),

                Forms\Components\MarkdownEditor::make('content')
                    ->required()
                    ->columnSpan('full'),



                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required(),
                    ])
                    // ->hidden(!$user->isAdmin() || !$user->isSuperAdmin())
                    ->required(),

                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required()
                    ->label('Author'),


                Forms\Components\DatePicker::make('published_at'),

                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required(),

                // Champ pour gérer les tags
                Forms\Components\Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->createOptionForm([ // Formulaire modal pour créer un tag

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))), // Génération automatique du slug

                        Forms\Components\TextInput::make('slug')
                        ->readonly()
                            ->unique(Tag::class, 'slug', ignoreRecord: true),
                    ])
                    ->label('Tags')->columnSpan('full'),

                Forms\Components\Section::make('Image')->schema([
                    Forms\Components\FileUpload::make('image_cover')->image()->directory('post-images')->hiddenLabel(),
                ])->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_cover')
                    ->label('Image'),

                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),

                // Tables\Columns\TextColumn::make('category.name')
                //     ->label('Category')
                //     ->sortable()
                //     ->searchable(),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),



                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'archived' => 'Archived',
                            default => $state,
                        };
                    })
                    ->sortable(),

                // Tables\Columns\TextColumn::make('tags.name')
                //     ->label('Tags')
                //     ->separator(', ')
                //     ->limit(3),

                // Tables\Columns\TextColumn::make('published_at')
                //     ->dateTime()
                //     ->label('Published At')
                //     ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created At')
                    ->sortable(),


                // Tables\Columns\TextColumn::make('More actions')
                //     ->label('More actions')
                //     // ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('author')
                    ->relationship('author', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->label('Tags'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make()
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('title'),
                                        Components\TextEntry::make('slug'),
                                        Components\TextEntry::make('published_at')
                                            ->badge()
                                            ->date()
                                            ->color('success'),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('author.name'),
                                        Components\TextEntry::make('category.name'),
                                        Components\TextEntry::make('tags'),
                                    ]),
                                ]),
                            Components\ImageEntry::make('image')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from('lg'),
                    ]),
                Components\Section::make('Content')
                    ->schema([
                        Components\TextEntry::make('content')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
            ]);
    }
    
    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewPost::class,
            Pages\EditPost::class,
            Pages\ManagePostComments::class,
        ]);
    }


    public static function getRelations(): array
    {
        return [
            // Ajoute des RelationManagers si nécessaire
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'comments' => Pages\ManagePostComments::route('/{record}/comments'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'view' => Pages\ViewPost::route('/{record}'),
        ];
    }


    // public static function getGlobalSearchResultDetails(Model $record): array
    // {
    //     /** @var Post $record */
    //     $details = [];

    //     if ($record->author) {
    //         $details['Author'] = $record->author->name;
    //     }

    //     if ($record->category) {
    //         $details['Category'] = $record->category->name;
    //     }

    //     return $details;
    // }
}
