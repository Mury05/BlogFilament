<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Http\Middleware\CheckRole;
use App\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Blog Management';
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->role === 'super-admin' || Auth::user()->role === 'admin';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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

                Forms\Components\Select::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                    ])
                    ->default('user')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'user' => 'info',
                        'admin' => 'success',
                        'super-admin' => 'success',
                    })->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                        'super-admin' => 'Super Admin'
                    ])
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),

                Action::make('changePassword')
                    ->action(function (User $record, array $data): void {
                        $record->update([
                            'password' => Hash::make($data['new_password']),
                        ]);

                        // Filament::notify('success', 'Password changed successfully.');
                        Notification::make()
                            ->title('Password changed successfully.')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Forms\Components\TextInput::make('new_password')
                            ->password()
                            ->label('New Password')
                            ->required(),
                        Forms\Components\TextInput::make('new_password_confirmation')
                            ->password()
                            ->label('Confirm New Password')
                            ->rule('required', fn($get) => !!$get('new_password'))
                            ->same('new_password'),
                    ])
                    ->icon('heroicon-o-key')
                    ->visible(fn(): bool => Auth::user()->role === "super-admin"),


                Action::make('changeRole')
                    ->action(function (User $record, array $data): void {
                        $record->update([
                            'role' => $data['new_role'],
                        ]);

                        // Filament::notify('success', 'Role updated successfully.');
                        Notification::make()
                            ->title('Role updated successfully.')
                            ->success()
                            ->send();

                    })
                    ->form([
                        Forms\Components\Select::make('new_role')
                            ->options([
                                'user' => 'User',
                                'admin' => 'Admin',
                            ])
                            ->default(fn(User $record) => $record->role)
                            ->required(),
                    ])
                    ->icon('heroicon-c-arrow-path-rounded-square')
                    ->color('info')
                    ->visible(fn(): bool => Auth::user()->role === "super-admin"),
                // ->visible(fn (User $record): bool => $record->role === "super-admin" || $record->role === "admin"),


                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()->visible(fn(): bool => Auth::user()->role === "super-admin"),
                    Tables\Actions\DeleteAction::make()->visible(fn(): bool => Auth::user()->role === "super-admin")
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn(): bool => Auth::user()->role === "super-admin"),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
