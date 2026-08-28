<?php

namespace App\Filament\Resources\CustomizationRequests\Pages;

use App\Filament\Resources\CustomizationRequests\CustomizationRequestResource;
use App\Filament\Resources\CustomizationRequests\Schemas\CustomizationRequestInfolist;
use App\Models\CustomizationRequest;
use App\Models\CustomizationRequestItem;
use App\Services\InventoryService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;

class ViewCustomizationRequest extends ViewRecord
{
    protected static string $resource = CustomizationRequestResource::class;

    public function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return CustomizationRequestInfolist::configure($schema);
    }

    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        return view('components.status-stepper', ['request' => $this->record]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn (): bool => in_array($this->record->status, [
                    CustomizationRequest::STATUS_PENDING,
                    CustomizationRequest::STATUS_REVIEWING,
                    CustomizationRequest::STATUS_APPROVED,
                ])),
            $this->buildApproveAction(),
            $this->buildRejectAction(),
            $this->buildStartProductionAction(),
            $this->buildReadyForPickupAction(),
            $this->buildCompleteAction(),
            $this->buildCancelAction(),
        ];
    }

    protected function buildApproveAction(): Action
    {
        return Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->visible(fn (): bool => in_array($this->record->status, [
                CustomizationRequest::STATUS_PENDING,
                CustomizationRequest::STATUS_REVIEWING,
            ]))
            ->action(function (): void {
                $this->record->update([
                    'status' => CustomizationRequest::STATUS_APPROVED,
                    'approved_at' => now(),
                    'status_notes' => 'Approved by ' . auth()->user()?->name,
                ]);
                Notification::make()->title('Request approved.')->success()->send();
            });
    }

    protected function buildRejectAction(): Action
    {
        return Action::make('reject')
            ->label('Reject')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->requiresConfirmation()
            ->form([
                \Filament\Forms\Components\Textarea::make('reason')
                    ->label('Reason for rejection')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->visible(fn (): bool => in_array($this->record->status, [
                CustomizationRequest::STATUS_PENDING,
                CustomizationRequest::STATUS_REVIEWING,
            ]))
            ->action(function (array $data): void {
                $this->record->update([
                    'status' => CustomizationRequest::STATUS_REJECTED,
                    'rejected_at' => now(),
                    'status_notes' => 'Rejected: ' . $data['reason'],
                ]);
                Notification::make()->title('Request rejected.')->danger()->send();
            });
    }

    protected function buildStartProductionAction(): Action
    {
        return Action::make('startProduction')
            ->label('Start Production')
            ->icon('heroicon-o-wrench-screwdriver')
            ->color('primary')
            ->requiresConfirmation()
            ->visible(fn (): bool => $this->record->status === CustomizationRequest::STATUS_APPROVED)
            ->action(function (): void {
                try {
                    DB::transaction(function (): void {
                        $record = $this->record;
                        $service = app(InventoryService::class);
                        $items = [];

                        if ($record->material && $record->material->inventory_item_id) {
                            $items[] = [
                                'item' => $record->material->inventoryItem,
                                'quantity' => (float) $record->material->quantity_required,
                                'unit_cost' => (float) $record->material->inventoryItem->unit_cost,
                            ];
                        }

                        foreach ($record->accessories as $accessory) {
                            if ($accessory->inventory_item_id) {
                                $items[] = [
                                    'item' => $accessory->inventoryItem,
                                    'quantity' => (float) $accessory->quantity_required,
                                    'unit_cost' => (float) $accessory->inventoryItem->unit_cost,
                                ];
                            }
                        }

                        foreach ($items as $entry) {
                            $service->stockOut(
                                $entry['item'],
                                $entry['quantity'],
                                'Production - ' . $record->request_number,
                                $record->id
                            );
                            CustomizationRequestItem::create([
                                'customization_request_id' => $record->id,
                                'inventory_item_id' => $entry['item']->id,
                                'quantity' => $entry['quantity'],
                                'unit_cost' => $entry['unit_cost'],
                            ]);
                        }

                        $record->update([
                            'status' => CustomizationRequest::STATUS_IN_PRODUCTION,
                            'in_production_at' => now(),
                            'status_notes' => 'Production started by ' . auth()->user()?->name,
                        ]);
                    });

                    Notification::make()
                        ->title('Production started. Inventory has been deducted.')
                        ->success()
                        ->send();
                } catch (\InvalidArgumentException $e) {
                    Notification::make()
                        ->title('Insufficient Stock')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    protected function buildReadyForPickupAction(): Action
    {
        return Action::make('readyForPickup')
            ->label('Mark Ready for Pickup')
            ->icon('heroicon-o-truck')
            ->color('info')
            ->requiresConfirmation()
            ->visible(fn (): bool => $this->record->status === CustomizationRequest::STATUS_IN_PRODUCTION)
            ->action(function (): void {
                $this->record->update([
                    'status' => CustomizationRequest::STATUS_READY_FOR_PICKUP,
                    'status_notes' => 'Ready for pickup by ' . auth()->user()?->name,
                ]);
                Notification::make()->title('Marked as ready for pickup.')->success()->send();
            });
    }

    protected function buildCompleteAction(): Action
    {
        return Action::make('complete')
            ->label('Mark Completed')
            ->icon('heroicon-o-check-badge')
            ->color('success')
            ->requiresConfirmation()
            ->visible(fn (): bool => $this->record->status === CustomizationRequest::STATUS_READY_FOR_PICKUP)
            ->action(function (): void {
                $this->record->update([
                    'status' => CustomizationRequest::STATUS_COMPLETED,
                    'completed_at' => now(),
                    'final_price' => $this->record->final_price ?? $this->record->estimated_price,
                    'status_notes' => 'Completed by ' . auth()->user()?->name,
                ]);
                Notification::make()->title('Request completed.')->success()->send();
            });
    }

    protected function buildCancelAction(): Action
    {
        return Action::make('cancel')
            ->label('Cancel Request')
            ->icon('heroicon-o-x-mark')
            ->color('gray')
            ->requiresConfirmation()
            ->visible(fn (): bool => in_array($this->record->status, [
                CustomizationRequest::STATUS_PENDING,
                CustomizationRequest::STATUS_REVIEWING,
                CustomizationRequest::STATUS_APPROVED,
            ]))
            ->action(function (): void {
                $this->record->update([
                    'status' => CustomizationRequest::STATUS_CANCELLED,
                    'status_notes' => 'Cancelled by ' . auth()->user()?->name,
                ]);
                Notification::make()->title('Request cancelled.')->success()->send();
            });
    }
}
