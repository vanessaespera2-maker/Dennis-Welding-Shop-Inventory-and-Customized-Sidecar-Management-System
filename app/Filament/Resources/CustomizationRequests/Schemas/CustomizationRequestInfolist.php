<?php

namespace App\Filament\Resources\CustomizationRequests\Schemas;

use App\Models\CustomizationRequest;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomizationRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(3)
                    ->schema([
                        Group::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Request Details')
                                    ->icon('heroicon-o-clipboard-document-list')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('request_number')
                                                    ->weight('bold')
                                                    ->color('primary'),
                                                TextEntry::make('status')
                                                    ->badge()
                                                    ->color(fn (string $state): string => CustomizationRequest::STATUS_COLORS[$state] ?? 'gray'),
                                                TextEntry::make('date_submitted')
                                                    ->label('Submitted')
                                                    ->dateTime(),
                                                TextEntry::make('customer.name')
                                                    ->label('Customer'),
                                                TextEntry::make('sidecar.name')
                                                    ->label('Sidecar'),
                                                TextEntry::make('material.name')
                                                    ->label('Material')
                                                    ->placeholder('—'),
                                                TextEntry::make('color.name')
                                                    ->label('Color')
                                                    ->placeholder('—'),
                                                TextEntry::make('preferred_dimensions')
                                                    ->label('Preferred Dimensions')
                                                    ->placeholder('—'),
                                            ]),
                                    ]),
                                Section::make('Customer Notes')
                                    ->icon('heroicon-o-chat-bubble-left-right')
                                    ->schema([
                                        TextEntry::make('special_instructions')
                                            ->placeholder('No special instructions')
                                            ->columnSpanFull(),
                                        TextEntry::make('design_notes')
                                            ->label('Design Notes')
                                            ->placeholder('No design notes')
                                            ->columnSpanFull(),
                                        ImageEntry::make('design_image')
                                            ->label('Design Image')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Selected Accessories')
                                    ->icon('heroicon-o-squares-plus')
                                    ->schema([
                                        RepeatableEntry::make('accessories')
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        TextEntry::make('name'),
                                                        TextEntry::make('pivot.price')
                                                            ->label('Price')
                                                            ->money('PHP'),
                                                        TextEntry::make('pivot.quantity')
                                                            ->label('Qty')
                                                            ->numeric(),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                        Group::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Pricing')
                                    ->icon('heroicon-o-banknotes')
                                    ->schema([
                                        TextEntry::make('estimated_price')
                                            ->label('Estimated Price')
                                            ->money('PHP')
                                            ->weight('bold'),
                                        TextEntry::make('final_price')
                                            ->label('Final Price')
                                            ->money('PHP')
                                            ->weight('bold')
                                            ->color('success'),
                                    ]),
                                Section::make('Timeline')
                                    ->icon('heroicon-o-clock')
                                    ->schema([
                                        TextEntry::make('approved_at')
                                            ->label('Approved')
                                            ->dateTime()
                                            ->placeholder('—'),
                                        TextEntry::make('in_production_at')
                                            ->label('In Production')
                                            ->dateTime()
                                            ->placeholder('—'),
                                        TextEntry::make('completed_at')
                                            ->label('Completed')
                                            ->dateTime()
                                            ->placeholder('—'),
                                        TextEntry::make('rejected_at')
                                            ->label('Rejected')
                                            ->dateTime()
                                            ->placeholder('—'),
                                    ]),
                                Section::make('Production Usage')
                                    ->icon('heroicon-o-archive-box')
                                    ->schema([
                                        RepeatableEntry::make('requestItems')
                                            ->label('Items Deducted')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('inventoryItem.name')
                                                            ->label('Item'),
                                                        TextEntry::make('quantity')
                                                            ->numeric()
                                                            ->label('Qty'),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
