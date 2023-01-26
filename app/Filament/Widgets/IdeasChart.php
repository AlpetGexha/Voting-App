<?php

namespace App\Filament\Widgets;

use App\Actions\Trend as ActionsTrend;
use App\Models\Ideas;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\TrendValue;

class IdeasChart extends LineChartWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Ideas Chart';

    public ?string $filter = 'this_month';

    public bool $readyToLoad = false;

    protected function getHeading(): string
    {
        return 'Ideas Chard';
    }

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

        $data = ActionsTrend::model(Ideas::class)
            ->filterBy($activeFilter)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Ideas Publish',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    public function getSkeletonLoad()
    {
        return [
            'datasets' => [
                [
                    'label' => 'Ideas Loading',
                    'data' => [],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [],
        ];
    }

    protected function getFilters(): ?array
    {
        return ActionsTrend::filterType();
    }
}
