<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Material;
use App\Models\Sidecar;
use App\Models\SidecarCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('home', [
            'sidecars' => Sidecar::where('status', 'available')
                ->with('category')
                ->take(3)
                ->get(),
            'materials' => Material::where('is_active', true)->take(4)->get(),
            'accessories' => Accessory::where('is_active', true)->take(4)->get(),
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function sidecars(Request $request)
    {
        return view('sidecars.index', [
            'categories' => SidecarCategory::where('is_active', true)->orderBy('sort_order')->get(),
            'sidecars' => Sidecar::query()
                ->when($request->filled('category'), fn ($q) => $q->where('sidecar_category_id', $request->query('category')))
                ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%' . $request->query('search') . '%'))
                ->with('category')
                ->orderBy('name')
                ->paginate(9)
                ->withQueryString(),
        ]);
    }

    public function sidecarShow(Sidecar $sidecar)
    {
        return view('sidecars.show', [
            'sidecar' => $sidecar,
        ]);
    }

    public function materials()
    {
        return view('materials', [
            'materials' => Material::where('is_active', true)->get(),
        ]);
    }

    public function accessories()
    {
        return view('accessories', [
            'accessories' => Accessory::where('is_active', true)->get(),
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        \App\Models\ActivityLog::log('Message', "Contact message received from {$validated['name']} ({$validated['email']}): " . \Illuminate\Support\Str::limit($validated['message'], 100));

        return back()->with('sent', true);
    }
}
