<?php

namespace App\Filament\Widgets;

use App\Models\CustomizationRequest;
use Filament\Widgets\ChartWidget;

class MonthlyCustomizationRequestsChart extends ChartWidget
{
    protected ?string $heading = 'Customization Requests (Monthly)';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        for ($month = 5; $month >= 0; $month--) {
            $date = now()->subMonths($month);
            $labels[] = $date->format('M Y');
            $data[] = CustomizationRequest::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Requests',
                    'data' => $data,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]],
            ],
        ];
    }
}
