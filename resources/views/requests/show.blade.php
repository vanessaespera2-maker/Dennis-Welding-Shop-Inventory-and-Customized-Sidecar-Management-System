<x-customer-layout :title="$request->request_number">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('requests.index') }}" class="text-sm text-gray-500 hover:text-amber-600 transition">← Back to my requests</a>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-950">{{ $request->request_number }}</h1>
                <p class="mt-1 text-sm text-gray-500">Submitted {{ $request->date_submitted->format('M d, Y h:i A') }}</p>
            </div>
            <span class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-medium {{ match ($request->status) {
                'completed' => 'bg-emerald-50 text-emerald-700',
                'pending' => 'bg-amber-50 text-amber-700',
                'rejected' => 'bg-rose-50 text-rose-700',
                default => 'bg-sky-50 text-sky-700',
            } }}">{{ \App\Models\CustomizationRequest::STATUSES[$request->status] ?? $request->status }}</span>
        </div>

        <div class="mt-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-5 text-sm font-semibold uppercase tracking-wider text-gray-500">Order Progress</h2>
            @include('components.status-stepper', ['request' => $request])
        </div>

        @if ($request->status_notes)
            <div class="mt-6 rounded-lg bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-800">
                <strong class="text-amber-900">Update:</strong> {{ $request->status_notes }}
            </div>
        @endif

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-950">Your Build</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between"><dt class="text-gray-500">Sidecar</dt><dd class="font-medium text-gray-950">{{ $request->sidecar?->name ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Material</dt><dd class="font-medium text-gray-950">{{ $request->material?->name ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Color</dt><dd class="font-medium text-gray-950">{{ $request->color?->name ?? '—' }}</dd></div>
                    @if ($request->preferred_dimensions)
                        <div class="flex justify-between"><dt class="text-gray-500">Dimensions</dt><dd class="font-medium text-gray-950">{{ $request->preferred_dimensions }}</dd></div>
                    @endif
                </dl>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-950">Pricing</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between"><dt class="text-gray-500">Estimated Price</dt><dd class="font-bold text-amber-600">₱{{ number_format($request->estimated_price, 2) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Final Price</dt><dd class="font-bold text-gray-950">{{ $request->final_price ? '₱' . number_format($request->final_price, 2) : '—' }}</dd></div>
                </dl>
                <div class="mt-6 border-t border-gray-100 pt-4">
                    <h3 class="text-sm font-semibold text-gray-700">Selected Accessories</h3>
                    @forelse ($request->accessories as $accessory)
                        <p class="mt-2 text-sm text-gray-600">• {{ $accessory->name }} <span class="text-amber-600 font-medium">₱{{ number_format($accessory->pivot->price, 2) }}</span></p>
                    @empty
                        <p class="mt-2 text-sm text-gray-400">None selected.</p>
                    @endforelse
                </div>
            </div>
        </div>

        @if ($request->special_instructions || $request->design_notes || $request->design_image)
            <div class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-950">Your Notes</h2>
                @if ($request->special_instructions)
                    <p class="mt-3 text-sm text-gray-700"><strong class="text-gray-900">Special Instructions:</strong> {{ $request->special_instructions }}</p>
                @endif
                @if ($request->design_notes)
                    <p class="mt-2 text-sm text-gray-700"><strong class="text-gray-900">Design Notes:</strong> {{ $request->design_notes }}</p>
                @endif
                @if ($request->design_image)
                    <img src="{{ \Storage::url($request->design_image) }}" alt="Design reference" class="mt-4 max-w-sm rounded-lg border border-gray-200">
                @endif
            </div>
        @endif

        @if ($request->requestItems->isNotEmpty())
            <div class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-950">Materials Used in Production</h2>
                <table class="mt-4 w-full text-sm">
                    <thead class="text-gray-500 text-left border-b border-gray-100">
                        <tr><th class="py-2 font-medium">Item</th><th class="py-2 font-medium text-right">Qty</th><th class="py-2 font-medium text-right">Unit Cost</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @foreach ($request->requestItems as $item)
                            <tr>
                                <td class="py-2">{{ $item->inventoryItem?->name ?? '—' }}</td>
                                <td class="py-2 text-right">{{ number_format($item->quantity, 2) }}</td>
                                <td class="py-2 text-right">₱{{ number_format($item->unit_cost, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-customer-layout>
