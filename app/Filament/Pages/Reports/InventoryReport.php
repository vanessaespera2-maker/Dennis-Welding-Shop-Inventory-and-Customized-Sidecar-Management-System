<?php

namespace App\Filament\Pages\Reports;

use App\Models\InventoryItem;
use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class InventoryReport extends Page
{
    protected string $view = 'filament.pages.reports.inventory-report';

    protected static ?string $slug = 'reports/inventory';

    protected ?string $heading = 'Inventory Report';

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Inventory Report';

    protected static ?int $navigationSort = 1;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('reports.view') ?? false;
    }

    public function getItems(): \Illuminate\Support\Collection
    {
        return InventoryItem::query()
            ->with(['category', 'supplier'])
            ->orderBy('name')
            ->get()
            ->map(fn (InventoryItem $item) => [
                'name' => $item->name,
                'sku' => $item->sku,
                'category' => $item->category?->name ?? '—',
                'supplier' => $item->supplier?->name ?? '—',
                'current_stock' => (float) $item->current_stock,
                'unit' => $item->unit,
                'reorder_level' => (float) $item->reorder_level,
                'unit_cost' => (float) $item->unit_cost,
                'stock_value' => $item->stockValue(),
                'status' => $item->current_stock <= $item->reorder_level ? 'Low Stock' : 'OK',
            ]);
    }

    public function getTotals(): array
    {
        $items = InventoryItem::all();

        return [
            'total_items' => $items->count(),
            'total_value' => $items->sum(fn ($item) => $item->stockValue()),
            'low_stock' => $items->filter(fn ($item) => $item->isLowStock())->count(),
        ];
    }

    public function getSubtitle(): string
    {
        return 'Generated on ' . now()->format('F j, Y h:i A') . ' | PHP ' . $this->getTotals()['total_value'];
    }
}
