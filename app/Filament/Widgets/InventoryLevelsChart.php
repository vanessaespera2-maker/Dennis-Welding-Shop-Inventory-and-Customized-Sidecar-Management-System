<?php

namespace App\Filament\Widgets;

use App\Models\InventoryItem;
use Filament\Widgets\ChartWidget;

class InventoryLevelsChart extends ChartWidget
{
    protected ?string $heading = 'Inventory Stock Levels (Top 10)';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $items = InventoryItem::with('category')
            ->orderByDesc('current_stock')
            ->take(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Current Stock',
                    'data' => $items->map(fn ($item) => (float) $item->current_stock)->all(),
                    'backgroundColor' => '#6366f1',
                    'borderColor' => '#4f46e5',
                ],
                [
                    'label' => 'Minimum Stock',
                    'data' => $items->map(fn ($item) => (float) $item->minimum_stock)->all(),
                    'backgroundColor' => '#f43f5e',
                    'borderColor' => '#e11d48',
                ],
            ],
            'labels' => $items->map(fn ($item) => $item->name)->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => ['position' => 'top'],
            ],
            'scales' => [
                'x' => ['beginAtZero' => true],
            ],
        ];
    }
}
