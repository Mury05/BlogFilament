<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if(Auth::user()->role === "user") {
            $data['author_id'] = Auth::id();
            return $data;
        }
        return $data;

    }

    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
