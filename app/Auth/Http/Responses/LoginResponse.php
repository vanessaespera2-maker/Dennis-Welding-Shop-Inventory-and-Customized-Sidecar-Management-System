<?php

namespace App\Auth\Http\Responses;

use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as Responsable;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->hasAnyRole(['super_admin', 'staff'])) {
            return redirect()->intended(Filament::getUrl());
        }

        return redirect()->intended(route('dashboard'));
    }
}
