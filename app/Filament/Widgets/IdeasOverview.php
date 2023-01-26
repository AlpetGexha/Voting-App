<?php

namespace App\Filament\Widgets;

use App\Models\Ideas;
use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class IdeasOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    protected function getCards(): array
    {
        if (! $this->readyToLoad) {
            return [
                Card::make('Total Ideas', 'loading...'),
                Card::make('Ideas Open', 'loading...'),
                Card::make('Reported Closed', 'loading...'),
            ];
        }

        // get all report from report who have App\Models\Ideas
        $ideas_report = Report::where('reportable_type', Ideas::class)->count();

        $ideas = Ideas::query()
            ->selectRaw('count(*) as total')
            ->selectRaw('count(case when status_id = 1 then 1 end) as open')
            ->selectRaw('count(case when status_id = 2 then 1 end) as considering')
            ->selectRaw('count(case when status_id = 3 then 1 end) as in_progress')
            ->selectRaw('count(case when status_id = 4 then 1 end) as implemented')
            ->selectRaw('count(case when status_id = 5 then 1 end) as closed')

            // ->selectRaw('count(case when MONTH(created_at) = 1 then 1 end) as jan')
            // ->selectRaw('count(case when MONTH(created_at) = 2 then 1 end) as feb')
            // ->selectRaw('count(case when MONTH(created_at) = 3 then 1 end) as mar')
            // ->selectRaw('count(case when MONTH(created_at) = 4 then 1 end) as apr')
            // ->selectRaw('count(case when MONTH(created_at) = 5 then 1 end) as may')
            // ->selectRaw('count(case when MONTH(created_at) = 6 then 1 end) as jun')
            // ->selectRaw('count(case when MONTH(created_at) = 7 then 1 end) as jul')
            // ->selectRaw('count(case when MONTH(created_at) = 8 then 1 end) as aug')
            // ->selectRaw('count(case when MONTH(created_at) = 9 then 1 end) as sep')
            // ->selectRaw('count(case when MONTH(created_at) = 10 then 1 end) as oct')
            // ->selectRaw('count(case when MONTH(created_at) = 11 then 1 end) as nov')
            // ->selectRaw('count(case when MONTH(created_at) = 12 then 1 end) as dec')

            ->first()
            ->toArray();
        // dd($ideas);

        return [
            Card::make('Total Ideas', getAmount2($ideas['total']))
            // ->description('32k increase')
            // ->descriptionIcon('heroicon-s-trending-up')
            // ->chart([7, 2, 10, 3, 15, 4, 17])
            // ->color('success')
            ,
            Card::make('Open Ideas', getAmount2($ideas['open'])),
            // Card::make('Closed Ideas', getAmount($ideas['closed'])),
            Card::make('Reported Ideas', getAmount($ideas_report)),
        ];
    }
}
