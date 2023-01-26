<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdeasResource\Pages;
use App\Models\Ideas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;

class IdeasResource extends Resource
{
    protected static ?string $model = Ideas::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('category_id')
                    ->required(),
                Forms\Components\TextInput::make('status_id')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255),
                Forms\Components\Textarea::make('body')
                    ->required()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        Column::configureUsing(function (Column $column): void {
            $column
                ->toggleable()
                ->searchable()
                ->sortable();
        });

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\BadgeColumn::make('status.name')
                    ->colors([
                        'success' => 'Open',
                        'danger' => 'Close',
                        'primary' => 'Considering',
                        'warning' => 'In Progres',
                        'secondary' => 'Implemented',
                    ]),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('votes_count')->counts('votes'),
                Tables\Columns\TextColumn::make('comments_count')->counts('comments'),

                Tables\Columns\TextColumn::make('body')
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status_id')
                    ->label('Status')
                    ->placeholder('Select a Status')
                    ->relationship('status', 'name'),
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->placeholder('Select a Category')
                    ->relationship('category', 'name'),
                // filter by vote count
                // SelectFilter::make('votes_count'),
                TextFilter::make('title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
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
            'index' => Pages\ListIdeas::route('/'),
            'create' => Pages\CreateIdeas::route('/create'),
            'edit' => Pages\EditIdeas::route('/{record}/edit'),
        ];
    }
}
