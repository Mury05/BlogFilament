<?php

namespace App\Filament\Resources\PostResource\Pages;

// Utilise la ressource PostResource de l'application
use App\Filament\Resources\PostResource;
// Utilise les actions de Filament
use Filament\Actions;
// Utilise les pages ListRecords de Filament
use Filament\Resources\Pages\ListRecords;

// Déclare une classe ListPosts qui étend ListRecords
class ListPosts extends ListRecords
{
    // Définit la ressource associée à cette classe
    protected static string $resource = PostResource::class;

    // Définit les actions de l'en-tête
    protected function getHeaderActions(): array
    {
        // Retourne un tableau contenant l'action de création
        return [
            Actions\CreateAction::make(),
        ];
    }
}