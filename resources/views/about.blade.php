<x-app-layout :title="'About Us'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">About Dennis Welding Shop</h1>
        <div class="mt-6 prose prose-invert max-w-none text-gray-300 leading-relaxed">
            <p>{{ setting('shop_description', 'Dennis Welding Shop is your trusted partner for quality sidecar fabrication, customization, and reliable welding services.') }}</p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-6">
                <h3 class="font-semibold text-white">Our Craft</h3>
                <p class="mt-2 text-sm text-gray-400 leading-relaxed">Every sidecar is designed, cut, welded, and finished in-house. We use quality steel and take pride in every weld.</p>
            </div>
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-6">
                <h3 class="font-semibold text-white">Customization</h3>
                <p class="mt-2 text-sm text-gray-400 leading-relaxed">From standard passenger sidecars to cargo and delivery builds, we tailor the size, material, color, and accessories to your needs.</p>
            </div>
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-6">
                <h3 class="font-semibold text-white">Service</h3>
                <p class="mt-2 text-sm text-gray-400 leading-relaxed">We keep you informed from request to pickup. Track your customization online and communicate with our team anytime.</p>
            </div>
        </div>

        <div class="mt-12 rounded-xl border border-gray-800 bg-gray-900 p-6 sm:p-8">
            <h2 class="text-xl font-bold text-white">Visit Our Shop</h2>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-300">
                <p><strong class="text-white">Address:</strong> {{ setting('shop_address', '—') }}</p>
                <p><strong class="text-white">Phone:</strong> {{ setting('shop_phone', '—') }}</p>
                <p><strong class="text-white">Email:</strong> {{ setting('shop_email', '—') }}</p>
                <p><strong class="text-white">Hours:</strong> {{ setting('shop_hours', '—') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
