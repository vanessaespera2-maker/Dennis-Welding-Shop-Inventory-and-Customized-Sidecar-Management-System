<?php

namespace App\Filament\Widgets;

use App\Models\CustomizationRequest;
use App\Models\InventoryItem;
use App\Models\Sidecar;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $lowStock = InventoryItem::lowStock()->count();

        return [
            Stat::make('Total Customers', User::role('customer')->count())
                ->icon(Heroicon::OutlinedUsers)
                ->description('Registered customers')
                ->descriptionIcon(Heroicon::OutlinedArrowTrendingUp)
                ->color('primary'),

            Stat::make('Total Sidecars', Sidecar::count())
                ->icon(Heroicon::OutlinedTruck)
                ->description('Sidecar models available')
                ->color('info'),

            Stat::make('Total Inventory Items', InventoryItem::count())
                ->icon(Heroicon::OutlinedArchiveBox)
                ->description('Items tracked in inventory')
                ->color('success'),

            Stat::make('Low Stock Items', $lowStock)
                ->icon(Heroicon::OutlinedExclamationTriangle)
                ->description($lowStock > 0 ? 'Needs restocking' : 'All good')
                ->descriptionIcon($lowStock > 0 ? Heroicon::OutlinedExclamationTriangle : Heroicon::OutlinedCheckCircle)
                ->color($lowStock > 0 ? 'danger' : 'success'),

            Stat::make('Pending Customizations', CustomizationRequest::where('status', 'pending')->count())
                ->icon(Heroicon::OutlinedClock)
                ->color('warning'),

            Stat::make('Approved Customizations', CustomizationRequest::where('status', 'approved')->count())
                ->icon(Heroicon::OutlinedCheckBadge)
                ->color('success'),

            Stat::make('In Production', CustomizationRequest::where('status', 'in_production')->count())
                ->icon(Heroicon::OutlinedCog6Tooth)
                ->color('info'),

            Stat::make('Completed Requests', CustomizationRequest::where('status', 'completed')->count())
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success'),
        ];
    }
}
