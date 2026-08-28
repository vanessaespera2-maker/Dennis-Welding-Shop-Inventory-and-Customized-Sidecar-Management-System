<x-app-layout :title="$sidecar->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('sidecars.index') }}" class="text-sm text-gray-400 hover:text-amber-400">← Back to sidecars</a>
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="rounded-xl border border-gray-800 bg-gray-900 overflow-hidden">
                @if ($sidecar->image)
                    <img src="{{ \Storage::url($sidecar->image) }}" alt="{{ $sidecar->name }}" class="w-full h-full object-cover">
                @else
                    <div class="aspect-[4/3] flex items-center justify-center bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-24 h-24 text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                    </div>
                @endif
            </div>
            <div>
                <p class="text-sm font-semibold text-amber-400 uppercase tracking-wider">{{ $sidecar->category?->name }}</p>
                <h1 class="mt-2 text-3xl font-extrabold text-white">{{ $sidecar->name }}</h1>
                <p class="mt-4 text-gray-300 leading-relaxed">{{ $sidecar->description }}</p>
                <div class="mt-6 flex items-center gap-4">
                    <p class="text-2xl font-extrabold text-white">₱{{ number_format($sidecar->base_price, 2) }}</p>
                    <span class="rounded-full bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 text-xs font-semibold text-emerald-300">
                        {{ $sidecar->available_quantity > 0 ? $sidecar->available_quantity . ' available' : 'Out of stock' }}
                    </span>
                </div>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('customize', ['sidecar' => $sidecar->slug]) }}" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">
                        Customize This Model
                    </a>
                    <a href="{{ route('customize') }}" class="inline-flex items-center rounded-lg bg-gray-800 px-6 py-3 font-semibold text-white hover:bg-gray-700 transition">Start From Scratch</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
