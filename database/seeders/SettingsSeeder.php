<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'shop_name', 'value' => 'Dennis Welding Shop', 'group' => 'general'],
            ['key' => 'shop_tagline', 'value' => 'Quality Sidecars Built to Match Your Style', 'group' => 'general'],
            ['key' => 'shop_description', 'value' => 'Dennis Welding Shop is your trusted partner for quality sidecar fabrication, customization, and reliable welding services.', 'group' => 'general'],
            ['key' => 'shop_logo', 'value' => null, 'group' => 'general'],
            ['key' => 'shop_address', 'value' => 'National Highway, Brgy. San Isidro, Cabuyao, Laguna', 'group' => 'contact'],
            ['key' => 'shop_phone', 'value' => '0917 123 4567', 'group' => 'contact'],
            ['key' => 'shop_email', 'value' => 'denniswelding@example.com', 'group' => 'contact'],
            ['key' => 'shop_hours', 'value' => 'Monday - Saturday: 8:00 AM - 6:00 PM', 'group' => 'contact'],
            ['key' => 'shop_facebook', 'value' => 'https://facebook.com/denniswelding', 'group' => 'contact'],
            ['key' => 'shop_footer_text', 'value' => 'Customized sidecars and quality welding services.', 'group' => 'general'],
            ['key' => 'contact_map_embed', 'value' => null, 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
