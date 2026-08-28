<?php

namespace Tests\Feature;

use App\Models\Accessory;
use App\Models\ActivityLog;
use App\Models\Color;
use App\Models\CustomizationRequest;
use App\Models\InventoryItem;
use App\Models\Material;
use App\Models\Sidecar;
use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_stock_in_and_out_updates_inventory(): void
    {
        $item = InventoryItem::where('current_stock', '>', 0)->firstOrFail();
        $service = app(InventoryService::class);

        $before = (float) $item->current_stock;
        $transactionsBefore = $item->transactions()->count();

        $service->stockIn($item, 10, 'REF-TEST', 'Test stock in');
        $item->refresh();
        $this->assertEquals($before + 10, (float) $item->current_stock);

        $service->stockOut($item, 4, 'Test stock out');
        $item->refresh();
        $this->assertEquals($before + 6, (float) $item->current_stock);

        $this->assertEquals($transactionsBefore + 2, $item->transactions()->count());
    }

    public function test_stock_out_rejects_insufficient_quantity(): void
    {
        $item = InventoryItem::where('current_stock', '>', 0)->firstOrFail();
        $service = app(InventoryService::class);
        $before = (float) $item->current_stock;
        $transactionsBefore = $item->transactions()->count();

        try {
            $service->stockOut($item, $before + 999, 'Should fail');
            $this->fail('Expected InvalidArgumentException');
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('Insufficient stock', $e->getMessage());
        }

        $item->refresh();
        $this->assertEquals($before, (float) $item->current_stock);
        $this->assertEquals($transactionsBefore, $item->transactions()->count());
    }

    public function test_contact_form_submission_logs_message(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Hello, this is a test message.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('sent');
        $this->assertGreaterThan(0, ActivityLog::where('description', 'like', '%Test User%')->count());
    }

    public function test_customer_can_submit_customization_request(): void
    {
        $user = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->first();
        Auth::login($user);

        $sidecar = Sidecar::where('status', 'available')->first();
        $material = Material::where('is_active', true)->first();
        $color = Color::where('is_active', true)->first();
        $accessories = Accessory::where('is_active', true)->take(2)->pluck('id')->toArray();

        $response = $this->actingAs($user)->post('/customize', [
            'sidecar_id' => $sidecar->id,
            'material_id' => $material->id,
            'color_id' => $color->id,
            'accessories' => $accessories,
            'special_instructions' => 'Make the sidecar extra sturdy.',
            'preferred_dimensions' => '150cm x 90cm',
        ]);

        $request = CustomizationRequest::where('user_id', $user->id)->orderBy('id', 'desc')->first();

        $response->assertRedirect(route('requests.show', $request));
        $this->assertNotNull($request);
        $this->assertEquals(CustomizationRequest::STATUS_PENDING, $request->status);
        $this->assertEquals($sidecar->id, $request->sidecar_id);
        $this->assertEquals(2, $request->accessories()->count());
        $this->assertTrue($request->estimated_price > 0);
        $this->assertGreaterThan(0, ActivityLog::where('description', 'like', "%{$request->request_number}%")->count());
    }
}
