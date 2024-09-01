<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LikesResource\Pages;
use App\Filament\Resources\LikesResource\RelationManagers;
use App\Models\Likes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LikesResource extends Resource
{
    protected static ?string $model = Likes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->required()
                ->relationship('user', 'name')
                ->label('User'),
                Forms\Components\Select::make('comment_id')
                    ->required()
                    ->relationship('comment', 'comment_text')
                    ->label('Comments'),
                Forms\Components\TextInput::make('type')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                ->sortable()
                ->label('User'),
                Tables\Columns\TextColumn::make('comment.comment_text')
                    ->sortable()
                    ->label('Comments'),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLikes::route('/'),
            'create' => Pages\CreateLikes::route('/create'),
            'view' => Pages\ViewLikes::route('/{record}'),
            'edit' => Pages\EditLikes::route('/{record}/edit'),
        ];
    }
}
