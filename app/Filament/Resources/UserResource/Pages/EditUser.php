<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Http\Middleware\SuperAdmin;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

        // Mettre le middleware CheckRole pour vérifier si l'utilisateur est admin ou super-admin
        protected static array|string $routeMiddleware = [SuperAdmin::class];

        protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
