<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | Dennis Welding Shop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        .fi-sidebar {
            position: fixed;
            inset-inline-start: 0;
            inset-block: 0;
            z-index: 30;
            display: flex;
            flex-direction: column;
            align-content: flex-start;
            background-color: var(--color-white);
            height: 100dvh;
            transition: all 0.2s ease;
            transform: translateX(-100%);
        }
        .fi-sidebar.fi-sidebar-open {
            width: var(--sidebar-width, 16rem);
            transform: translateX(0);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        @media (min-width: 1024px) {
            .fi-sidebar {
                z-index: 20;
                background-color: transparent;
                transform: translateX(0);
                width: var(--sidebar-width, 16rem);
                position: sticky;
            }
            .fi-sidebar.fi-sidebar-open {
                box-shadow: none;
            }
        }

        .fi-sidebar-header-ctn { overflow-x: clip; }
        .fi-sidebar-header { display: flex; height: 4rem; align-items: center; justify-content: center; }
        .fi-sidebar-nav { display: flex; flex: 1; flex-direction: column; gap: 1.75rem; overflow-x: hidden; overflow-y: auto; padding: 2rem 1.5rem; scrollbar-gutter: stable; }
        .fi-sidebar-nav-groups { display: flex; flex-direction: column; gap: 1.75rem; margin-inline: -0.5rem; }
        .fi-sidebar-group { display: flex; flex-direction: column; gap: 0.25rem; }
        .fi-sidebar-group-items { display: flex; flex-direction: column; gap: 0.25rem; list-style: none; padding: 0; margin: 0; }
        .fi-sidebar-group-label { flex: 1; font-size: 0.875rem; line-height: 1.5rem; font-weight: 500; color: var(--color-gray-500); padding: 0 0.5rem; margin-bottom: 0.25rem; }
        .fi-sidebar-item { display: flex; flex-direction: column; gap: 0.25rem; list-style: none; }
        .fi-sidebar-item.fi-active > .fi-sidebar-item-btn { background-color: var(--color-gray-100); }
        .fi-sidebar-item.fi-active > .fi-sidebar-item-btn > .fi-icon { color: var(--color-primary-600); }
        .fi-sidebar-item.fi-active > .fi-sidebar-item-btn > .fi-sidebar-item-label { color: var(--color-primary-600); }
        .fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:hover { background-color: var(--color-gray-100); }
        .fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:focus-visible { background-color: var(--color-gray-100); }
        .fi-sidebar-item-btn {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 0.5rem;
            padding: 0.5rem;
            outline: none;
            transition: background-color 75ms ease;
            text-decoration: none;
        }
        .fi-sidebar-item-btn > .fi-icon { color: var(--color-gray-400); width: 1.25rem; height: 1.25rem; flex-shrink: 0; }
        .fi-sidebar-item-label { flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.875rem; font-weight: 500; color: var(--color-gray-700); }
        .fi-sidebar-footer { margin-inline: 1rem; margin-block: 0.75rem; display: grid; gap: 0.75rem; }
        .fi-sidebar-open-sidebar-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 0.5rem; padding: 0.5rem; color: var(--color-gray-400); }
        .fi-sidebar-open-sidebar-btn:hover { color: var(--color-gray-500); background-color: var(--color-gray-100); }

        .fi-topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid var(--color-gray-200);
            background-color: var(--color-white);
            padding: 0 1rem;
            min-height: 4rem;
        }
        @media (min-width: 640px) { .fi-topbar { padding: 0 1.5rem; } }
        @media (min-width: 1024px) { .fi-topbar { padding: 0 2rem; } }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-950 min-h-screen" x-data="{ sidebarOpen: false }">

    {{-- Mobile sidebar overlay --}}
    <div x-show="sidebarOpen" x-cloak
         x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition duration-300 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-30 bg-gray-950/50 lg:hidden" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <div x-cloak="-lg" x-bind:class="{ 'fi-sidebar-open': sidebarOpen || true }" class="fi-sidebar" style="--sidebar-width: 16rem;">
        <div class="fi-sidebar-header-ctn">
            <header class="fi-sidebar-header">
                <div class="flex-1 flex items-center justify-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        @if (setting('shop_logo'))
                            <img src="{{ \Storage::url(setting('shop_logo')) }}" alt="Logo" class="h-8 w-8 rounded-lg object-cover">
                        @else
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary-600 text-white font-black text-sm">{{ strtoupper(substr(setting('shop_name', 'DW'), 0, 2)) }}</span>
                        @endif
                        <span class="font-bold text-gray-950 tracking-tight text-sm">{{ setting('shop_name', 'Dennis Welding Shop') }}</span>
                    </a>
                </div>
            </header>
        </div>

        <nav aria-label="Customer navigation" class="fi-sidebar-nav">
            <ul class="fi-sidebar-nav-groups">
                <li class="fi-sidebar-group">
                    <ul class="fi-sidebar-group-items">
                        <li class="fi-sidebar-item fi-sidebar-item-has-url {{ request()->routeIs('dashboard') ? 'fi-active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="fi-sidebar-item-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="fi-icon h-5 w-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span class="fi-sidebar-item-label">Dashboard</span>
                            </a>
                        </li>
                        <li class="fi-sidebar-item fi-sidebar-item-has-url {{ request()->routeIs('requests.*') ? 'fi-active' : '' }}">
                            <a href="{{ route('requests.index') }}" class="fi-sidebar-item-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="fi-icon h-5 w-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75v7.5m3-7.5h6m-6 3h6M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                <span class="fi-sidebar-item-label">My Requests</span>
                            </a>
                        </li>
                        <li class="fi-sidebar-item fi-sidebar-item-has-url">
                            <a href="{{ route('customize') }}" class="fi-sidebar-item-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="fi-icon h-5 w-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="fi-sidebar-item-label">New Customization</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="fi-sidebar-group">
                    <span class="fi-sidebar-group-label">Account</span>
                    <ul class="fi-sidebar-group-items">
                        <li class="fi-sidebar-item fi-sidebar-item-has-url {{ request()->routeIs('profile') ? 'fi-active' : '' }}">
                            <a href="{{ route('profile') }}" class="fi-sidebar-item-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="fi-icon h-5 w-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <span class="fi-sidebar-item-label">My Profile</span>
                            </a>
                        </li>
                        <li class="fi-sidebar-item fi-sidebar-item-has-url">
                            <a href="{{ route('home') }}" class="fi-sidebar-item-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="fi-icon h-5 w-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                <span class="fi-sidebar-item-label">Back to Site</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="fi-sidebar-footer">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex w-full items-center gap-x-3 rounded-lg p-2 text-start outline-none transition duration-75 hover:bg-gray-100 focus-visible:bg-gray-100">
                    <span class="relative flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-600">
                        <span class="text-sm font-medium text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </span>
                    <span class="flex-1 truncate text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0 text-gray-400" x-bind:class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak
                     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="absolute bottom-full left-0 right-0 mb-1 rounded-xl bg-white shadow-xl ring-1 ring-gray-950/5 z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="p-1">
                        <a href="{{ route('profile') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                </svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main content --}}
    <div class="lg:ml-[16rem] min-h-screen flex flex-col">
        <header class="fi-topbar">
            <button x-on:click="sidebarOpen = true" class="fi-sidebar-open-sidebar-btn xl:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <div class="flex-1 flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary-600 transition">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-950 font-medium">{{ $title ?? 'Dashboard' }}</span>
            </div>
            @if (auth()->user()->hasAnyRole(['super_admin', 'staff']))
                <a href="/admin" class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.204-.107-.397.165-.71.505-.78.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Admin Panel
                </a>
            @endif
        </header>

        @if (session('status'))
            <div class="px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-lg bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
