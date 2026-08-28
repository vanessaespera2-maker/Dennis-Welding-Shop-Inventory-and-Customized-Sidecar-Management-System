<?php

namespace App\Filament\Widgets;

use App\Models\CustomizationRequest;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentCustomizationRequests extends TableWidget
{
    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CustomizationRequest::query()
                    ->with(['customer', 'sidecar'])
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('request_number')
                    ->label('Request #')
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('sidecar.name')
                    ->label('Sidecar'),
                TextColumn::make('estimated_price')
                    ->label('Estimated Price')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => CustomizationRequest::STATUS_COLORS[$state] ?? 'gray'),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
