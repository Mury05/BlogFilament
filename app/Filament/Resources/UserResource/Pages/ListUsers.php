<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Http\Middleware\CheckRole;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->visible(fn(): bool => Auth::user()->role === "super-admin"),
        ];
    }

        // Mettre le middleware CheckRole pour vérifier si l'utilisateur est admin ou super-admin
        // protected static array|string $routeMiddleware = ['CheckRole'];
        protected static array|string $routeMiddleware = [CheckRole::class];

}
