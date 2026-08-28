<?php

namespace App\Filament\Resources\CustomizationRequests\Tables;

use App\Models\CustomizationRequest;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CustomizationRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('request_number')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->color('primary'),
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sidecar.name')
                    ->label('Sidecar')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('material.name')
                    ->label('Material')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('color.name')
                    ->label('Color')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('estimated_price')
                    ->label('Estimated')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('final_price')
                    ->label('Final')
                    ->money('PHP')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => CustomizationRequest::STATUS_COLORS[$state] ?? 'gray'),
                SelectColumn::make('status')
                    ->label('Update Status')
                    ->options(CustomizationRequest::STATUSES)
                    ->tooltip('Change the status of this request'),
                TextColumn::make('date_submitted')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(CustomizationRequest::STATUSES),
                SelectFilter::make('sidecar_id')
                    ->label('Sidecar')
                    ->relationship('sidecar', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('user_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
