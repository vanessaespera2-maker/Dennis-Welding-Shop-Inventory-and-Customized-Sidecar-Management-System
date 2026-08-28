<x-customer-layout :title="'My Requests'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-950">My Requests</h1>
                <p class="mt-1 text-gray-500">Track the status of your customization requests.</p>
            </div>
            <a href="{{ route('customize') }}" class="inline-flex items-center rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">New Request</a>
        </div>

        <div class="mt-8 space-y-4">
            @forelse ($requests as $request)
                <a href="{{ route('requests.show', $request) }}" class="block rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:border-amber-300 hover:shadow-md transition">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="font-bold text-gray-950">{{ $request->request_number }}</p>
                            <p class="mt-1 text-sm text-gray-500">{{ $request->sidecar?->name ?? '—' }} · {{ $request->date_submitted->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-amber-600">₱{{ number_format($request->estimated_price, 2) }}</span>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ match ($request->status) {
                                'completed' => 'bg-emerald-50 text-emerald-700',
                                'pending' => 'bg-amber-50 text-amber-700',
                                'rejected' => 'bg-rose-50 text-rose-700',
                                default => 'bg-sky-50 text-sky-700',
                            } }}">{{ \App\Models\CustomizationRequest::STATUSES[$request->status] ?? $request->status }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-10 text-center">
                    <p class="text-gray-500">You haven't submitted any customization requests yet.</p>
                    <a href="{{ route('customize') }}" class="mt-4 inline-block rounded-lg bg-amber-500 px-6 py-2.5 font-semibold text-gray-950 hover:bg-amber-400 transition">Customize a Sidecar</a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $requests->links() }}</div>
    </div>
</x-customer-layout>
