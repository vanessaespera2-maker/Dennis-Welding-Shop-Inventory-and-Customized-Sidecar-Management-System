<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandName(fn (): string => (string) setting('shop_name', 'Dennis Welding Shop'))
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Sky,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
            ])
            ->navigationGroups([
                NavigationGroup::make('Dashboard')
                    ->icon(Heroicon::OutlinedHome),
                NavigationGroup::make('Sidecars')
                    ->icon(Heroicon::OutlinedTruck),
                NavigationGroup::make('Inventory')
                    ->icon(Heroicon::OutlinedArchiveBox),
                NavigationGroup::make('Customization')
                    ->icon(Heroicon::OutlinedPaintBrush),
                NavigationGroup::make('Customers')
                    ->icon(Heroicon::OutlinedUsers),
                NavigationGroup::make('Suppliers')
                    ->icon(Heroicon::OutlinedBuildingStorefront),
                NavigationGroup::make('Reports')
                    ->icon(Heroicon::OutlinedDocumentChartBar),
                NavigationGroup::make('System')
                    ->icon(Heroicon::OutlinedCog6Tooth),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\MonthlyCustomizationRequestsChart::class,
                \App\Filament\Widgets\RequestStatusChart::class,
                \App\Filament\Widgets\MonthlySalesChart::class,
                \App\Filament\Widgets\InventoryLevelsChart::class,
                \App\Filament\Widgets\RecentCustomizationRequests::class,
                \App\Filament\Widgets\LowStockItems::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
