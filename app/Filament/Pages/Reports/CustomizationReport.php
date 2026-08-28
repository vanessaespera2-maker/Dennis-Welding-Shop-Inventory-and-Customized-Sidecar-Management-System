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

class CustomizationReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.reports.customization-report';

    protected static ?string $slug = 'reports/customizations';

    protected ?string $heading = 'Customization Report';

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Customization Report';

    protected static ?int $navigationSort = 3;

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

    public function getRequests(): \Illuminate\Support\Collection
    {
        $data = $this->form->getState();

        $start = \Carbon\Carbon::parse($data['start_date'] ?? now()->subDays(30))->startOfDay();
        $end = \Carbon\Carbon::parse($data['end_date'] ?? now())->endOfDay();

        return CustomizationRequest::query()
            ->with(['customer', 'sidecar', 'material', 'color'])
            ->whereBetween('date_submitted', [$start, $end])
            ->orderBy('date_submitted', 'desc')
            ->get();
    }

    public function getStatusBreakdown(): array
    {
        $requests = $this->getRequests();

        return [
            'total' => $requests->count(),
            'pending' => $requests->where('status', 'pending')->count(),
            'in_production' => $requests->where('status', 'in_production')->count(),
            'completed' => $requests->where('status', 'completed')->count(),
            'cancelled' => $requests->where('status', 'cancelled')->count(),
            'rejected' => $requests->where('status', 'rejected')->count(),
            'revenue' => $requests
                ->where('status', 'completed')
                ->sum(fn ($request) => (float) ($request->final_price ?? $request->estimated_price)),
        ];
    }

    public function getSubtitle(): string
    {
        return 'Generated on ' . now()->format('F j, Y h:i A');
    }
}
