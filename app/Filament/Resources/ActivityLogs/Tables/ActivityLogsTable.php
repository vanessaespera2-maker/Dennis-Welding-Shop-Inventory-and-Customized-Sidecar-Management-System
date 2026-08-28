<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->placeholder('System'),
                TextColumn::make('action')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->weight('semibold'),
                TextColumn::make('description')
                    ->searchable()
                    ->wrap()
                    ->limit(60),
                TextColumn::make('model_type')
                    ->label('Module')
                    ->formatStateUsing(fn (?string $state): ?string => $state
                        ? class_basename($state)
                        : null)
                    ->badge()
                    ->color('gray')
                    ->toggleable(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->label('Action')
                    ->options([
                        'Login' => 'Login',
                        'Stock In' => 'Stock In',
                        'Stock Out' => 'Stock Out',
                        'Adjustment' => 'Adjustment',
                        'Created' => 'Created',
                        'Updated' => 'Updated',
                        'Deleted' => 'Deleted',
                    ]),
                SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
