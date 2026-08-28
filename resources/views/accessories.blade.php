<x-app-layout :title="'Accessories'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-white">Accessories</h1>
        <p class="mt-2 text-gray-400">Add extras to make your sidecar more comfortable, durable, and functional.</p>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($accessories as $accessory)
                <div class="rounded-xl border border-gray-800 bg-gray-900 overflow-hidden hover:border-amber-500/40 transition">
                    @if ($accessory->image)
                        <img src="{{ \Storage::url($accessory->image) }}" alt="{{ $accessory->name }}" class="w-full h-40 object-cover">
                    @endif
                    <div class="p-5">
                        <h3 class="font-semibold text-white">{{ $accessory->name }}</h3>
                        <p class="mt-2 text-sm text-gray-400 leading-relaxed line-clamp-2">{{ $accessory->description }}</p>
                        <p class="mt-3 font-bold text-amber-400">₱{{ number_format($accessory->price, 2) }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-400 py-12">No accessories available yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
