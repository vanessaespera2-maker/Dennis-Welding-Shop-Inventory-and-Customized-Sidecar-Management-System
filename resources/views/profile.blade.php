<x-customer-layout :title="'My Profile'">
    <div class="max-w-2xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-extrabold text-gray-950">My Profile</h1>
        <p class="mt-1 text-gray-500">Update your account details.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-lg bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="mt-6 rounded-xl border border-gray-200 bg-white p-8 shadow-sm space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full rounded-lg bg-gray-50 border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full rounded-lg bg-gray-50 border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full rounded-lg bg-gray-50 border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="mt-1 w-full rounded-lg bg-gray-50 border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition">
            </div>
            <button type="submit" class="rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">Update Profile</button>
        </form>
    </div>
</x-customer-layout>
