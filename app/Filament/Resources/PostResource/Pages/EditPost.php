<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function authorizeAccess(): void
    {
        $post = $this->record;

        // Super admin and admin can edit any post
        if (Auth::user()->role === 'super-admin' || Auth::user()->role === 'admin') {
            return;
        }

        // Users can only edit their own posts
        if (Auth::user()->id !== $post->author_id) {
            // Le renvoyer vers sa requete précédente
            redirect()->back()->send();
            return;
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
