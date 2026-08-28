<?php

namespace App\Filament\Widgets;

use App\Models\CustomizationRequest;
use Filament\Widgets\ChartWidget;

class MonthlySalesChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Sales';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        for ($month = 5; $month >= 0; $month--) {
            $date = now()->subMonths($month);
            $labels[] = $date->format('M Y');

            $total = CustomizationRequest::whereIn('status', ['completed'])
                ->whereYear('completed_at', $date->year)
                ->whereMonth('completed_at', $date->month)
                ->sum('final_price');

            $data[] = (float) $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Sales (₱)',
                    'data' => $data,
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#059669',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true],
            ],
        ];
    }
}
