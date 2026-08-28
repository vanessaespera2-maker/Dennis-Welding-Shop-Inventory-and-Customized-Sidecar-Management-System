<x-app-layout :title="setting('shop_tagline', 'Quality Sidecars Built to Match Your Style')">
    <div class="relative overflow-hidden bg-gray-900">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(245,158,11,0.12),transparent_60%)]"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-flex items-center rounded-full bg-amber-500/10 border border-amber-500/30 px-3 py-1 text-xs font-semibold text-amber-400 uppercase tracking-wider">Welding & Sidecar Fabrication</span>
                    <h1 class="mt-5 text-4xl sm:text-5xl font-extrabold text-white leading-tight tracking-tight">
                        {{ setting('shop_tagline', 'Quality Sidecars Built to Match Your Style') }}
                    </h1>
                    <p class="mt-5 text-lg text-gray-300 leading-relaxed">
                        {{ setting('shop_description', 'Dennis Welding Shop is your trusted partner for quality sidecar fabrication, customization, and reliable welding services.') }}
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('customize') }}" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">
                            Customize Your Sidecar
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </a>
                        <a href="{{ route('sidecars.index') }}" class="inline-flex items-center rounded-lg bg-gray-800 px-6 py-3 font-semibold text-white hover:bg-gray-700 transition">Browse Sidecars</a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl border border-gray-700 bg-gray-800/60 p-6">
                        <p class="text-3xl font-extrabold text-amber-400">{{ $sidecars->count() }}+</p>
                        <p class="mt-1 text-sm text-gray-400">Sidecar Models</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-800/60 p-6">
                        <p class="text-3xl font-extrabold text-amber-400">{{ $materials->count() }}+</p>
                        <p class="mt-1 text-sm text-gray-400">Material Options</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-800/60 p-6">
                        <p class="text-3xl font-extrabold text-amber-400">{{ $accessories->count() }}+</p>
                        <p class="mt-1 text-sm text-gray-400">Accessories</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-800/60 p-6">
                        <p class="text-3xl font-extrabold text-amber-400">100%</p>
                        <p class="mt-1 text-sm text-gray-400">Custom Built</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Featured Sidecars</h2>
                <p class="mt-1 text-gray-400">Handcrafted models ready for your customization.</p>
            </div>
            <a href="{{ route('sidecars.index') }}" class="text-sm font-semibold text-amber-400 hover:text-amber-300">View all →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($sidecars as $sidecar)
                <a href="{{ route('sidecars.show', $sidecar) }}" class="group rounded-xl border border-gray-800 bg-gray-900 overflow-hidden hover:border-amber-500/40 transition">
                    <div class="aspect-[4/3] bg-gray-800 flex items-center justify-center">
                        @if ($sidecar->image)
                            <img src="{{ \Storage::url($sidecar->image) }}" alt="{{ $sidecar->name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-semibold text-amber-400 uppercase tracking-wider">{{ $sidecar->category?->name }}</p>
                        <h3 class="mt-1 font-semibold text-white group-hover:text-amber-400 transition">{{ $sidecar->name }}</h3>
                        <p class="mt-2 text-sm text-gray-400 line-clamp-2">{{ $sidecar->description }}</p>
                        <p class="mt-3 font-bold text-white">₱{{ number_format($sidecar->base_price, 2) }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-gray-400">No sidecars available yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-gray-900 border-y border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Built to Your Specifications</h2>
                <p class="mt-4 text-gray-300 leading-relaxed">Pick a base sidecar, choose your material, color, and accessories — and our team will fabricate a sidecar that's truly yours. Each build is welded and finished by hand.</p>
                <div class="mt-6 space-y-3 text-sm text-gray-300">
                    <p class="flex items-center gap-3"><span class="text-amber-400">✓</span> Real-time price estimate as you build</p>
                    <p class="flex items-center gap-3"><span class="text-amber-400">✓</span> Quality materials and safety-tested welds</p>
                    <p class="flex items-center gap-3"><span class="text-amber-400">✓</span> Track your request status online</p>
                </div>
                <a href="{{ route('customize') }}" class="mt-8 inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">
                    Start Customizing
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($materials as $material)
                    <div class="rounded-xl border border-gray-800 bg-gray-800/50 p-5">
                        <h3 class="font-semibold text-white">{{ $material->name }}</h3>
                        <p class="mt-1 text-sm text-gray-400 line-clamp-2">{{ $material->description }}</p>
                        <p class="mt-2 text-sm font-bold text-amber-400">+₱{{ number_format($material->additional_price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
