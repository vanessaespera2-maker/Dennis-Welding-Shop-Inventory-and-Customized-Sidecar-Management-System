<?php

namespace App\Filament\Pages\Reports;

use App\Models\InventoryTransaction;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use UnitEnum;

class StockMovementReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.reports.stock-movement-report';

    protected static ?string $slug = 'reports/stock-movement';

    protected ?string $heading = 'Stock Movement Report';

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Stock Movement Report';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldSkipAuthorization = true;

    public array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->can('reports.view') ?? false;
    }

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => now()->subDays(30)->toDateString(),
            'end_date' => now()->toDateString(),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make([
                    DatePicker::make('start_date')
                        ->label('From')
                        ->required(),
                    DatePicker::make('end_date')
                        ->label('To')
                        ->required()
                        ->afterOrEqual('start_date'),
                ])->columns(2)->columnSpan(2)->extraAttributes(['class' => 'rounded-lg border border-gray-200 dark:border-gray-700 p-4']),
                Actions::make([
                    \Filament\Actions\Action::make('filter')
                        ->label('Filter')
                        ->submit('filter'),
                ])->columnSpan(1),
            ])
            ->columns(3)
            ->statePath('data');
    }

    public function filter(): void
    {
        //
    }

    public function getTransactions(): \Illuminate\Support\Collection
    {
        $data = $this->form->getState();

        $start = \Carbon\Carbon::parse($data['start_date'] ?? now()->subDays(30))->startOfDay();
        $end = \Carbon\Carbon::parse($data['end_date'] ?? now())->endOfDay();

        return InventoryTransaction::query()
            ->with(['inventoryItem', 'user'])
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getSummary(): array
    {
        $transactions = $this->getTransactions();

        return [
            'stock_in' => $transactions->where('type', 'stock_in')->sum('quantity'),
            'stock_out' => $transactions->where('type', 'stock_out')->sum('quantity'),
            'adjustments' => $transactions->where('type', 'adjustment')->count(),
            'total' => $transactions->count(),
        ];
    }

    public function getSubtitle(): string
    {
        return 'Generated on ' . now()->format('F j, Y h:i A');
    }
}
