<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use App\Filament\Resources\CommentsResource\Pages;
use App\Filament\Resources\CommentsResource\RelationManagers;
use App\Models\Comments;
use Yepsua\Filament\Forms\Components\Rating;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Mokhosh\FilamentRating\Columns\RatingColumn;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;

class CommentsResource extends Resource
{
    protected static ?string $model = Comments::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->required()
                ->label('User')

                ->default(Auth::user()->id),
                Forms\Components\Select::make('content_id')
                ->required()
                ->relationship('content', 'title')
                ->label('Content'),
                Forms\Components\Textarea::make('comment_text')
                    ->required()
                    ->columnSpanFull()
                    ->label('Comment Text'),
                Rating::make('rating')
                    ->min(0)
                    ->max(5),
                Forms\Components\TextInput::make('likes')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Likes'),
                Forms\Components\TextInput::make('dislikes')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Dislikes'),
                Forms\Components\Toggle::make('is_reported')
                    ->required()
                    ->label('Is Reported'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    Tables\Columns\TextColumn::make('user.name') // Assuming User model has a 'name' field
                    ->sortable()
                    ->label('User')
                    ->default(Auth::user()->id),
                Tables\Columns\TextColumn::make('content.title') // Assuming Content model has a 'title' field
                    ->sortable()
                    ->label('Content'),
                RatingColumn::make('rating'),
                Tables\Columns\TextColumn::make('comment_text')
                ->sortable()
                ->label('Comment Text'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
                Tables\Columns\TextColumn::make('likes')
                    ->numeric()
                    ->sortable()
                    ->label('Likes'),
                Tables\Columns\TextColumn::make('dislikes')
                    ->numeric()
                    ->sortable()
                    ->label('Dislikes'),
                Tables\Columns\IconColumn::make('is_reported')
                    ->boolean()
                    ->label('Reported'),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            // Define any relations you want here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComments::route('/create'),
            'view' => Pages\ViewComments::route('/{record}'),
            'edit' => Pages\EditComments::route('/{record}/edit'),
        ];
    }
}
