<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('content')->label('Contenu'),
            TextColumn::make('post.title')->label('Article'),
            TextColumn::make('user.name')->label('Auteur')->sortable(),
            TextColumn::make('created_at')->label('Créé le')->dateTime(),
        ];
    }
}
