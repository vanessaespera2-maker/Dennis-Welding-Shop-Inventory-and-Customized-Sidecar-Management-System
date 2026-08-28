<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->getHeading() }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $this->getSubtitle() }}</p>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        {{ $this->form }}
    </div>

    @php($breakdown = $this->getStatusBreakdown())

    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-4">
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
            <p class="text-2xl font-bold">{{ $breakdown['total'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
            <p class="text-2xl font-bold text-warning-600">{{ $breakdown['pending'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">In Production</p>
            <p class="text-2xl font-bold text-primary-600">{{ $breakdown['in_production'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Completed</p>
            <p class="text-2xl font-bold text-success-600">{{ $breakdown['completed'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Cancelled</p>
            <p class="text-2xl font-bold text-gray-500">{{ $breakdown['cancelled'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Revenue</p>
            <p class="text-2xl font-bold text-success-600">₱{{ number_format($breakdown['revenue'], 2) }}</p>
        </div>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Request #</th>
                        <th class="px-4 py-3 text-left font-medium">Customer</th>
                        <th class="px-4 py-3 text-left font-medium">Sidecar</th>
                        <th class="px-4 py-3 text-left font-medium">Material</th>
                        <th class="px-4 py-3 text-left font-medium">Color</th>
                        <th class="px-4 py-3 text-right font-medium">Estimated</th>
                        <th class="px-4 py-3 text-right font-medium">Final</th>
                        <th class="px-4 py-3 text-center font-medium">Status</th>
                        <th class="px-4 py-3 text-left font-medium">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($this->getRequests() as $request)
                        <tr>
                            <td class="px-4 py-3 font-medium text-primary-600">{{ $request->request_number }}</td>
                            <td class="px-4 py-3">{{ $request->customer?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $request->sidecar?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $request->material?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $request->color?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">₱{{ number_format($request->estimated_price, 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ $request->final_price ? '₱' . number_format($request->final_price, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium">{{ \App\Models\CustomizationRequest::STATUSES[$request->status] ?? $request->status }}</span>
                            </td>
                            <td class="px-4 py-3">{{ $request->date_submitted->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-8 text-center text-gray-500">No customization requests in the selected period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
