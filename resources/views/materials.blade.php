<x-app-layout :title="'Materials'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-white">Materials</h1>
        <p class="mt-2 text-gray-400">Choose the material your sidecar will be built from. Each adds a different look, weight, and durability.</p>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($materials as $material)
                <div class="rounded-xl border border-gray-800 bg-gray-900 p-6 hover:border-amber-500/40 transition">
                    <h3 class="text-lg font-semibold text-white">{{ $material->name }}</h3>
                    <p class="mt-2 text-sm text-gray-400 leading-relaxed">{{ $material->description }}</p>
                    <p class="mt-4 font-bold text-amber-400">+₱{{ number_format($material->additional_price, 2) }}</p>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-400 py-12">No materials available yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
