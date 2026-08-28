<header x-data="{ open: false }" class="bg-gray-900 border-b border-gray-800 sticky top-0 z-40">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    @if (setting('shop_logo'))
                        <img src="{{ \Storage::url(setting('shop_logo')) }}" alt="Logo" class="h-9 w-9 rounded-lg object-cover">
                    @else
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500 text-gray-950 font-black text-lg">DW</span>
                    @endif
                    <span class="font-bold text-white tracking-tight hidden sm:block">{{ setting('shop_name', 'Dennis Welding Shop') }}</span>
                </a>
                <div class="hidden lg:flex items-center gap-6 text-sm">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-amber-400 transition">Home</a>
                    <a href="{{ route('sidecars.index') }}" class="text-gray-300 hover:text-amber-400 transition">Sidecars</a>
                    <a href="{{ route('customize') }}" class="text-gray-300 hover:text-amber-400 transition">Customize</a>
                    <a href="{{ route('materials') }}" class="text-gray-300 hover:text-amber-400 transition">Materials</a>
                    <a href="{{ route('accessories') }}" class="text-gray-300 hover:text-amber-400 transition">Accessories</a>
                    <a href="{{ route('about') }}" class="text-gray-300 hover:text-amber-400 transition">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-300 hover:text-amber-400 transition">Contact</a>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <span class="text-sm text-gray-300 hidden sm:block">{{ auth()->user()->name }}</span>
                    @if (auth()->user()->hasAnyRole(['super_admin', 'staff']))
                        <a href="/admin" class="inline-flex items-center gap-1.5 rounded-lg bg-gray-800 px-3 py-1.5 text-sm font-medium text-white hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.204-.107-.397.165-.71.505-.78.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Admin Panel
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-gray-800 px-3 py-1.5 text-sm font-medium text-white hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-400 hover:text-rose-400 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-amber-400 transition">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center rounded-lg bg-amber-500 px-3 py-1.5 text-sm font-semibold text-gray-950 hover:bg-amber-400 transition">Sign Up</a>
                @endauth
                <button x-on:click="open = !open" class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-300 hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    <div x-show="open" @click.outside="open = false" x-collapse class="lg:hidden border-t border-gray-800">
        <div class="px-4 py-3 space-y-2 text-sm">
            <a href="{{ route('home') }}" class="block text-gray-300 hover:text-amber-400">Home</a>
            <a href="{{ route('sidecars.index') }}" class="block text-gray-300 hover:text-amber-400">Sidecars</a>
            <a href="{{ route('customize') }}" class="block text-gray-300 hover:text-amber-400">Customize</a>
            <a href="{{ route('materials') }}" class="block text-gray-300 hover:text-amber-400">Materials</a>
            <a href="{{ route('accessories') }}" class="block text-gray-300 hover:text-amber-400">Accessories</a>
            <a href="{{ route('about') }}" class="block text-gray-300 hover:text-amber-400">About</a>
            <a href="{{ route('contact') }}" class="block text-gray-300 hover:text-amber-400">Contact</a>
        </div>
    </div>
</header>
