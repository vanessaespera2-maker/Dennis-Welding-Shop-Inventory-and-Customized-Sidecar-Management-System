<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\CustomizationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        return view('dashboard', [
            'requests' => $user->customizationRequests()
                ->with(['sidecar', 'material', 'color'])
                ->latest()
                ->take(5)
                ->get(),
            'requestCount' => $user->customizationRequests()->count(),
            'pendingCount' => $user->customizationRequests()->where('status', 'pending')->count(),
            'completedCount' => $user->customizationRequests()->where('status', 'completed')->count(),
            'totalSpent' => $user->customizationRequests()
                ->where('status', 'completed')
                ->get()
                ->sum(fn ($request) => (float) ($request->final_price ?? $request->estimated_price)),
        ]);
    }

    public function requests()
    {
        return view('requests.index', [
            'requests' => Auth::user()->customizationRequests()
                ->with(['sidecar', 'material', 'color'])
                ->latest()
                ->paginate(10),
        ]);
    }

    public function requestShow(CustomizationRequest $request)
    {
        abort_unless($request->user_id === Auth::id(), 403);

        return view('requests.show', [
            'request' => $request->load(['sidecar', 'material', 'color', 'accessories', 'requestItems.inventoryItem']),
        ]);
    }

    public function profile()
    {
        return view('profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($validated);

        ActivityLog::log('Updated', "{$user->name} updated their profile.");

        return back()->with('status', 'Profile updated successfully.');
    }
}
