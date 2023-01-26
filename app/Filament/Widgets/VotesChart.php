<?php

namespace App\Filament\Widgets;

use App\Actions\Trend as ActionsTrend;
use App\Models\Comments;
use App\Models\Vote;
use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\TrendValue;

class VotesChart extends BarChartWidget
{
    protected static ?int $sort = 5;

    protected static ?string $heading = 'Votes Chart';

    public ?string $filter = 'this_month';

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    protected function getData(): array
    {
        if (! $this->readyToLoad) {
            $this->getSkeletonLoad();
        }

        $activeFilter = $this->filter;

        $data = ActionsTrend::model(Vote::class)
            ->filterBy($activeFilter)
            ->count();

        $comments = ActionsTrend::model(Comments::class)
            ->filterBy($activeFilter)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Vote Publish',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                    'borderColor' => 'rgb(255, 205, 86)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Comments',
                    'data' => $comments->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                    'borderColor' => 'rgb(255, 159, 64)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        return ActionsTrend::filterType();
    }

    private function getSkeletonLoad()
    {
        return [
            'datasets' => [
                [
                    'label' => 'Vote Loading',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                    'borderColor' => 'rgb(255, 205, 86)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Comments',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                    'borderColor' => 'rgb(255, 159, 64)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [],
        ];
    }

    protected static function color()
    {
        return [
            'backgroundColor' => [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',

                'rgba(153, 102, 255, 0.2)',
                'rgb(153, 102, 255)',

                'rgba(201, 203, 207, 0.2)',
            ],
            'borderColor' => [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)',
            ],
            'borderWidth' => 1,
        ];
    }
}
