<x-app-layout :title="'Contact Us'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-white">Contact Us</h1>
        <p class="mt-2 text-gray-400">We'd love to hear about your project.</p>

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-6 space-y-4 text-sm">
                <p><strong class="text-white">Address</strong><br><span class="text-gray-400">{{ setting('shop_address', '—') }}</span></p>
                <p><strong class="text-white">Phone</strong><br><span class="text-gray-400">{{ setting('shop_phone', '—') }}</span></p>
                <p><strong class="text-white">Email</strong><br><span class="text-gray-400">{{ setting('shop_email', '—') }}</span></p>
                <p><strong class="text-white">Business Hours</strong><br><span class="text-gray-400">{{ setting('shop_hours', '—') }}</span></p>
                @if (setting('shop_facebook'))
                    <p><strong class="text-white">Facebook</strong><br><a href="{{ setting('shop_facebook') }}" target="_blank" class="text-amber-400 hover:text-amber-300">{{ setting('shop_facebook') }}</a></p>
                @endif
            </div>
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-6">
                <h2 class="text-lg font-semibold text-white">Send us a message</h2>
                <form method="POST" action="{{ route('contact') }}" class="mt-4 space-y-4">
                    @csrf
                    <input type="text" name="name" placeholder="Your name" class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none">
                    <input type="email" name="email" placeholder="Your email" class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none">
                    <textarea name="message" rows="5" placeholder="Your message" class="w-full rounded-lg bg-gray-800 border border-gray-700 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-amber-500 focus:outline-none"></textarea>
                    <button type="submit" class="rounded-lg bg-amber-500 px-6 py-2.5 font-semibold text-gray-950 hover:bg-amber-400 transition">Send Message</button>
                </form>
                @if (session('sent'))
                    <p class="mt-4 text-sm text-emerald-400">Thank you! Your message has been sent.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
