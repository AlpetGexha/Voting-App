<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Webbingbrasil\FilamentAdvancedFilter\Filters\BooleanFilter;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationGroup = 'Resources';

    protected static ?string $navigationIcon = 'heroicon-o-flag';

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
                Tables\Columns\TextColumn::make('reportable_type'),
                Tables\Columns\TextColumn::make('reportable_id'),
                Tables\Columns\TextColumn::make('subject'),
                Tables\Columns\TextColumn::make('reason'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('ip'),
                Tables\Columns\TextColumn::make('user_agent'),
                Tables\Columns\IconColumn::make('is_resolved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('collection_name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                BooleanFilter::make('is_resolved'),
                // filter by reportable_type what exit
                SelectFilter::make('reportable_type')
                    ->options(function () {
                        return Report::select('reportable_type')
                            ->distinct()
                            ->get()
                            ->pluck('reportable_ype', 'reportable_type')
                            ->toArray();
                    }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListReports::route('/'),
            // 'create' => Pages\CreateReport::route('/create'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
