<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Color;
use App\Models\CustomizationRequest;
use App\Models\Material;
use App\Models\Sidecar;
use App\Services\PriceCalculator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomizationController extends Controller
{
    public function customize(Request $request)
    {
        $preselected = Sidecar::where('slug', $request->query('sidecar'))->first();

        $sidecars = Sidecar::where('status', 'available')
            ->with('category')
            ->get()
            ->map(fn (Sidecar $sidecar) => [
                'id' => $sidecar->id,
                'name' => $sidecar->name,
                'description' => $sidecar->description,
                'base_price' => (float) $sidecar->base_price,
                'category_name' => $sidecar->category?->name,
            ])->values();

        $materials = Material::where('is_active', true)
            ->get()
            ->map(fn (Material $material) => [
                'id' => $material->id,
                'name' => $material->name,
                'description' => $material->description,
                'additional_price' => (float) $material->additional_price,
            ])->values();

        $colors = Color::where('is_active', true)
            ->get()
            ->map(fn (Color $color) => [
                'id' => $color->id,
                'name' => $color->name,
                'color_code' => $color->color_code,
                'additional_price' => (float) $color->additional_price,
            ])->values();

        $accessories = Accessory::where('is_active', true)
            ->get()
            ->map(fn (Accessory $accessory) => [
                'id' => $accessory->id,
                'name' => $accessory->name,
                'description' => $accessory->description,
                'price' => (float) $accessory->price,
            ])->values();

        return view('customize', compact('sidecars', 'materials', 'colors', 'accessories', 'preselected'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sidecar_id' => ['required', 'exists:sidecars,id'],
            'material_id' => ['nullable', 'exists:materials,id'],
            'color_id' => ['nullable', 'exists:colors,id'],
            'accessories' => ['nullable', 'array'],
            'accessories.*' => ['exists:accessories,id'],
            'special_instructions' => ['nullable', 'string', 'max:1000'],
            'preferred_dimensions' => ['nullable', 'string', 'max:255'],
            'design_notes' => ['nullable', 'string', 'max:2000'],
            'design_image' => ['nullable', 'image', 'max:4096'],
        ], [
            'sidecar_id.required' => 'Please choose a sidecar to customize.',
        ]);

        $sidecar = Sidecar::findOrFail($validated['sidecar_id']);
        $material = isset($validated['material_id']) ? Material::find($validated['material_id']) : null;
        $color = isset($validated['color_id']) ? Color::find($validated['color_id']) : null;

        $accessoryIds = $validated['accessories'] ?? [];
        $accessories = Accessory::whereIn('id', $accessoryIds)->get();
        $accessoryMap = [];
        foreach ($accessories as $accessory) {
            $accessoryMap[$accessory->id] = $accessory;
        }

        $estimated = PriceCalculator::calculate($sidecar, $material, $color, $accessoryMap);

        $request = CustomizationRequest::create([
            'request_number' => CustomizationRequest::generateRequestNumber(),
            'user_id' => auth()->id(),
            'sidecar_id' => $sidecar->id,
            'material_id' => $material?->id,
            'color_id' => $color?->id,
            'estimated_price' => $estimated,
            'status' => CustomizationRequest::STATUS_PENDING,
            'special_instructions' => $validated['special_instructions'] ?? null,
            'preferred_dimensions' => $validated['preferred_dimensions'] ?? null,
            'design_notes' => $validated['design_notes'] ?? null,
            'design_image' => isset($validated['design_image'])
                ? $validated['design_image']->store('designs', 'public')
                : null,
            'date_submitted' => now(),
        ]);

        if ($accessories->isNotEmpty()) {
            foreach ($accessories as $accessory) {
                $request->accessories()->attach($accessory->id, [
                    'price' => $accessory->price,
                    'quantity' => 1,
                ]);
            }
        }

        \App\Models\ActivityLog::log('Created', "Customization request {$request->request_number} was submitted by {$request->customer->name}.");

        return redirect()->route('requests.show', $request)
            ->with('status', 'Your customization request has been submitted. Our team will review it shortly.');
    }
}
