<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;

    protected function getFormSchema(): array
    {
        return [
            Textarea::make('content')
                ->required()
                ->maxLength(500)
                ->label('Contenu'),
            
            BelongsToSelect::make('post_id')
                ->relationship('post', 'title')
                ->required()
                ->label('Article'),
            
            BelongsToSelect::make('user_id')
                ->relationship('user', 'name')
                ->nullable()
                ->label('Auteur'),
        ];
    }
}