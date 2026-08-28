<?php

namespace App\Filament\Widgets;

use App\Models\CustomizationRequest;
use Filament\Widgets\ChartWidget;

class RequestStatusChart extends ChartWidget
{
    protected ?string $heading = 'Request Status Distribution';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $statuses = [
            'pending' => ['Pending', '#f59e0b'],
            'reviewing' => ['Reviewing', '#38bdf8'],
            'approved' => ['Approved', '#10b981'],
            'in_production' => ['In Production', '#6366f1'],
            'ready_for_pickup' => ['Ready for Pickup', '#22d3ee'],
            'completed' => ['Completed', '#34d399'],
            'cancelled' => ['Cancelled', '#9ca3af'],
            'rejected' => ['Rejected', '#f43f5e'],
        ];

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($statuses as $key => [$label, $color]) {
            $count = CustomizationRequest::where('status', $key)->count();
            if ($count > 0) {
                $labels[] = $label;
                $data[] = $count;
                $colors[] = $color;
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['position' => 'right'],
            ],
        ];
    }
}
