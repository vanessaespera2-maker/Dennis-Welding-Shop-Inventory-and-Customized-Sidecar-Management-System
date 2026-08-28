<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->getHeading() }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $this->getSubtitle() }}</p>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        {{ $this->form }}
    </div>

    @php($summary = $this->getSummary())

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Completed Sales</p>
            <p class="text-2xl font-bold">{{ $summary['count'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</p>
            <p class="text-2xl font-bold text-success-600">₱{{ number_format($summary['revenue'], 2) }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Average Sale</p>
            <p class="text-2xl font-bold">₱{{ number_format($summary['average'], 2) }}</p>
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
                        <th class="px-4 py-3 text-right font-medium">Amount</th>
                        <th class="px-4 py-3 text-left font-medium">Completed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($this->getSales() as $sale)
                        <tr>
                            <td class="px-4 py-3 font-medium text-primary-600">{{ $sale['request_number'] }}</td>
                            <td class="px-4 py-3">{{ $sale['customer'] }}</td>
                            <td class="px-4 py-3">{{ $sale['sidecar'] }}</td>
                            <td class="px-4 py-3 text-right font-medium">₱{{ number_format($sale['amount'], 2) }}</td>
                            <td class="px-4 py-3">{{ $sale['completed_at']->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No completed sales in the selected period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
