<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),

                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Toggle::make('is_visible')
                    ->label('Approved for public')
                    ->default(true),

                Forms\Components\MarkdownEditor::make('content')
                    ->required()
                    ->label('Content'),
            ])
            ->columns(1);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
