<x-app-layout :title="'Login'">
    <div class="max-w-md mx-auto px-4 py-16">
        <div class="rounded-xl border border-gray-800 bg-gray-900 p-8">
            <h1 class="text-2xl font-bold text-white">Welcome back</h1>
            <p class="mt-1 text-sm text-gray-400">Log in to manage your customization requests.</p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg bg-rose-500/10 border border-rose-500/30 px-4 py-3 text-sm text-rose-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-medium text-white">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none" placeholder="you@example.com">
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Password</label>
                    <input type="password" name="password" required class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none" placeholder="••••••••">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-400">
                    <input type="checkbox" name="remember" class="rounded bg-gray-800 border-gray-700 text-amber-500 focus:ring-amber-500">
                    Remember me
                </label>
                <button type="submit" class="w-full rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">Log In</button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-400">
                Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-amber-400 hover:text-amber-300">Sign up</a>
            </p>
        </div>
    </div>
</x-app-layout>
