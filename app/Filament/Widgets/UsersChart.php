<?php

namespace App\Filament\Widgets;

use App\Actions\Trend;
use App\Models\User;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\TrendValue;

class UsersChart extends LineChartWidget
{
    protected static ?int $sort = 4;

    protected static ?string $heading = 'Users Chart';

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

        $users = Trend::model(User::class)
            ->filterBy($activeFilter)
            ->count();

        $usersBan = Trend::query(
            User::query()->isBan()
        )
            ->filterBy($activeFilter)
            ->count();

        $usersVerified = Trend::query(
            User::query()->isBan()
        )
            ->filterBy($activeFilter)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $users->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgb(255, 99, 132)',
                ],
                [
                    'label' => 'Users Ban',
                    'data' => $usersBan->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                    'borderColor' => 'rgb(153, 102, 255)',
                ],
                [
                    'label' => 'Users Verified',
                    'data' => $usersVerified->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgb(75, 192, 192)',
                ],
            ],
            'labels' => $users->map(fn (TrendValue $value) => $value->date),
        ];
    }

    private function getSkeletonLoad()
    {
        return [
            'datasets' => [
                [
                    'label' => 'Users Loading',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgb(255, 99, 132)',
                ],
                [
                    'label' => 'Users Ban Loading',
                    'data' => [],
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                    'borderColor' => 'rgb(153, 102, 255)',
                ],
                [
                    'label' => 'Users Verified Loading',
                    'data' => [],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgb(75, 192, 192)',
                ],
            ],
            'labels' => [],
        ];
    }

    protected function getFilters(): ?array
    {
        return Trend::filterType();
    }
}
