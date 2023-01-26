<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
// use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use STS\FilamentImpersonate\Impersonate;
use Webbingbrasil\FilamentAdvancedFilter\Filters\BooleanFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Resources';

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
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                TextFilter::make('name'),
                TextFilter::make('email'),
                BooleanFilter::make('is_verified'),
                BooleanFilter::make('is_banned')->nullsAreFalse(),
                DateFilter::make('published_at'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Impersonate::make('impersonate'),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                \FilamentPro\FilamentBan\Actions\Ban::make('ban'),
                \FilamentPro\FilamentBan\Actions\Unban::make('unban'),
                ExportBulkAction::make(),
            ])
            // ->prependActions([
            //     Impersonate::make('impersonate'), // <---
            // ])
;
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
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
