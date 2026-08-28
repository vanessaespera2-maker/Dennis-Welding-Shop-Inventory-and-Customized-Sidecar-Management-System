<?php

namespace App\Filament\Pages\Reports;

use App\Models\User;
use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class CustomerReport extends Page
{
    protected string $view = 'filament.pages.reports.customer-report';

    protected static ?string $slug = 'reports/customers';

    protected ?string $heading = 'Customer Report';

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Customer Report';

    protected static ?int $navigationSort = 5;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('reports.view') ?? false;
    }

    public function getCustomers(): \Illuminate\Support\Collection
    {
        return User::query()
            ->whereHas('roles', fn ($query) => $query->where('name', 'customer'))
            ->withCount('customizationRequests')
            ->orderBy('customization_requests_count', 'desc')
            ->get()
            ->map(function (User $user) {
                $completed = $user->customizationRequests()
                    ->where('status', 'completed')
                    ->get();

                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '—',
                    'requests' => $user->customization_requests_count,
                    'completed' => $completed->count(),
                    'spend' => $completed->sum(fn ($request) => (float) ($request->final_price ?? $request->estimated_price)),
                ];
            });
    }

    public function getSummary(): array
    {
        $customers = $this->getCustomers();

        return [
            'total' => $customers->count(),
            'total_spend' => $customers->sum('spend'),
            'total_requests' => $customers->sum('requests'),
        ];
    }

    public function getSubtitle(): string
    {
        return 'Generated on ' . now()->format('F j, Y h:i A');
    }
}
