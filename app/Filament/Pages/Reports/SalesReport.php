<?php

namespace App\Filament\Pages\Reports;

use App\Models\CustomizationRequest;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use UnitEnum;

class SalesReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.reports.sales-report';

    protected static ?string $slug = 'reports/sales';

    protected ?string $heading = 'Sales Report';

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Sales Report';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldSkipAuthorization = true;

    public array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->can('reports.view') ?? false;
    }

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => now()->startOfMonth()->toDateString(),
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

    public function getSales(): \Illuminate\Support\Collection
    {
        $data = $this->form->getState();

        $start = \Carbon\Carbon::parse($data['start_date'] ?? now()->startOfMonth())->startOfDay();
        $end = \Carbon\Carbon::parse($data['end_date'] ?? now())->endOfDay();

        return CustomizationRequest::query()
            ->with(['customer', 'sidecar'])
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$start, $end])
            ->orderBy('completed_at', 'desc')
            ->get()
            ->map(function (CustomizationRequest $request) {
                return [
                    'request_number' => $request->request_number,
                    'customer' => $request->customer?->name ?? '—',
                    'sidecar' => $request->sidecar?->name ?? '—',
                    'amount' => (float) ($request->final_price ?? $request->estimated_price),
                    'completed_at' => $request->completed_at,
                ];
            });
    }

    public function getSummary(): array
    {
        $sales = $this->getSales();

        return [
            'count' => $sales->count(),
            'revenue' => $sales->sum('amount'),
            'average' => $sales->count() ? $sales->avg('amount') : 0,
        ];
    }

    public function getSubtitle(): string
    {
        return 'Generated on ' . now()->format('F j, Y h:i A');
    }
}
