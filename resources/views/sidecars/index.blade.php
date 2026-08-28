<x-app-layout :title="'Sidecars'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-white">Our Sidecars</h1>
        <p class="mt-2 text-gray-400">Explore our handcrafted models, then customize one to your style.</p>

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="{{ route('sidecars.index') }}" class="rounded-full px-4 py-1.5 text-sm font-medium {{ ! request()->filled('category') ? 'bg-amber-500 text-gray-950' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">All</a>
            @foreach ($categories as $category)
                <a href="{{ route('sidecars.index', ['category' => $category->id]) }}" class="rounded-full px-4 py-1.5 text-sm font-medium {{ request()->query('category') == $category->id ? 'bg-amber-500 text-gray-950' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">{{ $category->name }}</a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('sidecars.index') }}" class="mt-6 flex gap-3">
            <input type="text" name="search" value="{{ request()->query('search') }}" placeholder="Search sidecars..." class="w-full sm:w-72 rounded-lg bg-gray-900 border border-gray-800 px-4 py-2 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none">
            <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Search</button>
        </form>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($sidecars as $sidecar)
                <div class="rounded-xl border border-gray-800 bg-gray-900 overflow-hidden hover:border-amber-500/40 transition group">
                    <a href="{{ route('sidecars.show', $sidecar) }}" class="block aspect-[4/3] bg-gray-800 flex items-center justify-center">
                        @if ($sidecar->image)
                            <img src="{{ \Storage::url($sidecar->image) }}" alt="{{ $sidecar->name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                        @endif
                    </a>
                    <div class="p-5">
                        <p class="text-xs font-semibold text-amber-400 uppercase tracking-wider">{{ $sidecar->category?->name }}</p>
                        <h3 class="mt-1 font-semibold text-white">{{ $sidecar->name }}</h3>
                        <p class="mt-2 text-sm text-gray-400 line-clamp-2">{{ $sidecar->description }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <p class="font-bold text-white">₱{{ number_format($sidecar->base_price, 2) }}</p>
                            <a href="{{ route('sidecars.show', $sidecar) }}" class="text-sm font-semibold text-amber-400 hover:text-amber-300">View →</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-400 py-12">No sidecars match your search.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $sidecars->links() }}</div>
    </div>
</x-app-layout>
