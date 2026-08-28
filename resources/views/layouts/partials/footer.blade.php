<footer class="bg-gray-900 border-t border-gray-800 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    @if (setting('shop_logo'))
                        <img src="{{ \Storage::url(setting('shop_logo')) }}" alt="Logo" class="h-8 w-8 rounded-lg object-cover">
                    @else
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500 text-gray-950 font-black">DW</span>
                    @endif
                    <span class="font-bold text-white">{{ setting('shop_name', 'Dennis Welding Shop') }}</span>
                </div>
                <p class="text-sm text-gray-400">{{ setting('shop_footer_text', 'Customized sidecars and quality welding services.') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">Quick Links</h3>
                <div class="space-y-2 text-sm text-gray-400">
                    <a href="{{ route('sidecars.index') }}" class="block hover:text-amber-400">Sidecars</a>
                    <a href="{{ route('customize') }}" class="block hover:text-amber-400">Customize a Sidecar</a>
                    <a href="{{ route('materials') }}" class="block hover:text-amber-400">Materials</a>
                    <a href="{{ route('accessories') }}" class="block hover:text-amber-400">Accessories</a>
                    <a href="{{ route('contact') }}" class="block hover:text-amber-400">Contact Us</a>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">Contact</h3>
                <div class="space-y-2 text-sm text-gray-400">
                    <p>{{ setting('shop_address', '') }}</p>
                    <p>{{ setting('shop_phone', '') }}</p>
                    <p>{{ setting('shop_email', '') }}</p>
                    <p>{{ setting('shop_hours', '') }}</p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-6 text-center text-xs text-gray-500">
            &copy; {{ now()->year }} {{ setting('shop_name', 'Dennis Welding Shop') }}. All rights reserved.
        </div>
    </div>
</footer>
