<?php

namespace Tests\Feature;

use App\Models\CustomizationRequest;
use App\Models\Sidecar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_frontend_pages(): void
    {
        foreach (['/', '/about', '/sidecars', '/materials', '/accessories', '/contact', '/customize', '/login', '/register'] as $url) {
            $this->get($url)->assertStatus(200);
        }
    }

    public function test_sidecar_show_by_slug(): void
    {
        $sidecar = Sidecar::first();
        $this->get("/sidecars/{$sidecar->slug}")->assertStatus(200);
    }

    public function test_guest_redirected_from_customer_areas(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/requests')->assertRedirect('/login');
    }

    public function test_customer_area(): void
    {
        $user = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->first();
        $this->actingAs($user);

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/requests')->assertStatus(200);
        $this->get('/profile')->assertStatus(200);
        $this->get('/customize')->assertStatus(200);

        $request = CustomizationRequest::where('user_id', $user->id)->first();
        if ($request) {
            $this->get("/requests/{$request->id}")->assertStatus(200);
        }

        $this->assertTrue(true);
    }

    public function test_admin_panel(): void
    {
        $admin = User::where('email', 'admin@denniswelding.com')->firstOrFail();
        $this->actingAs($admin);

        $this->get('/admin')->assertStatus(200);

        $paths = [
            '/admin/users',
            '/admin/sidecars',
            '/admin/sidecar-categories',
            '/admin/inventory-items',
            '/admin/inventory-categories',
            '/admin/inventory-transactions',
            '/admin/stock-ins',
            '/admin/stock-outs',
            '/admin/materials',
            '/admin/accessories',
            '/admin/colors',
            '/admin/customization-requests',
            '/admin/customization-requests/' . CustomizationRequest::orderBy('id')->value('id'),
            '/admin/suppliers',
            '/admin/roles',
            '/admin/activity-logs',
            '/admin/settings',
            '/admin/reports/inventory',
            '/admin/reports/stock-movement',
            '/admin/reports/customizations',
            '/admin/reports/sales',
            '/admin/reports/customers',
        ];

        foreach ($paths as $path) {
            $response = $this->get($path);
            if ($response->status() !== 200) { file_put_contents('C:/Users/User/AppData/Local/Temp/opencode/err.html', $response->getContent());
                $this->fail("$path returned {$response->status()}");
            }
        }

        $this->assertTrue(true);
    }
}
