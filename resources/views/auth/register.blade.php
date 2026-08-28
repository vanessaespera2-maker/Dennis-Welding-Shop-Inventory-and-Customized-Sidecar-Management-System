<x-app-layout :title="'Register'">
    <div class="max-w-md mx-auto px-4 py-16">
        <div class="rounded-xl border border-gray-800 bg-gray-900 p-8">
            <h1 class="text-2xl font-bold text-white">Create your account</h1>
            <p class="mt-1 text-sm text-gray-400">Sign up to customize sidecars and track your requests.</p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg bg-rose-500/10 border border-rose-500/30 px-4 py-3 text-sm text-rose-300">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-medium text-white">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none" placeholder="Juan Dela Cruz">
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none" placeholder="you@example.com">
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Phone (optional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none" placeholder="0917 000 0000">
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Address (optional)</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Password</label>
                    <input type="password" name="password" required class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none" placeholder="At least 8 characters">
                </div>
                <div>
                    <label class="text-sm font-medium text-white">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="mt-1 w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none">
                </div>
                <button type="submit" class="w-full rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">Create Account</button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-400">
                Already have an account? <a href="{{ route('login') }}" class="font-semibold text-amber-400 hover:text-amber-300">Log in</a>
            </p>
        </div>
    </div>
</x-app-layout>
