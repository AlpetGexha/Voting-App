<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class UserOverview extends BaseWidget
{
    protected static ?int $sort = 3;

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    protected function getCards(): array
    {
        if (! $this->readyToLoad) {
            return [
                Card::make('Total Users', 'loading...'),
                Card::make('Total Votes', 'loading...'),
            ];
        }

        $users = DB::table('users')->count();
        $votes = DB::table('votes')->count();

        return [
            Card::make('Total Users', getAmount2($users)),
            Card::make('Total Votes', getAmount2($votes)),
        ];
    }
}
