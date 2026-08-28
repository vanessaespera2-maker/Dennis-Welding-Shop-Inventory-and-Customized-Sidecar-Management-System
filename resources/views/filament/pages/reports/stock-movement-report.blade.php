<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->getHeading() }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $this->getSubtitle() }}</p>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        {{ $this->form }}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Stock In (qty)</p>
            <p class="text-2xl font-bold text-success-600 dark:text-success-400">{{ number_format($this->getSummary()['stock_in'], 0) }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Stock Out (qty)</p>
            <p class="text-2xl font-bold text-danger-600 dark:text-danger-400">{{ number_format($this->getSummary()['stock_out'], 0) }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Adjustments</p>
            <p class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $this->getSummary()['adjustments'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Transactions</p>
            <p class="text-2xl font-bold">{{ $this->getSummary()['total'] }}</p>
        </div>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Date</th>
                        <th class="px-4 py-3 text-left font-medium">Item</th>
                        <th class="px-4 py-3 text-center font-medium">Type</th>
                        <th class="px-4 py-3 text-right font-medium">Qty</th>
                        <th class="px-4 py-3 text-right font-medium">Before</th>
                        <th class="px-4 py-3 text-right font-medium">After</th>
                        <th class="px-4 py-3 text-left font-medium">Reason</th>
                        <th class="px-4 py-3 text-left font-medium">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($this->getTransactions() as $txn)
                        <tr>
                            <td class="px-4 py-3">{{ $txn->date->format('M d, Y') }}</td>
                            <td class="px-4 py-3 font-medium">{{ $txn->inventoryItem?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($txn->type === 'stock_in')
                                    <span class="inline-flex items-center rounded-full bg-success-50 dark:bg-success-500/10 px-2 py-1 text-xs font-medium text-success-700 dark:text-success-400">IN</span>
                                @elseif ($txn->type === 'stock_out')
                                    <span class="inline-flex items-center rounded-full bg-danger-50 dark:bg-danger-500/10 px-2 py-1 text-xs font-medium text-danger-700 dark:text-danger-400">OUT</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-warning-50 dark:bg-warning-500/10 px-2 py-1 text-xs font-medium text-warning-700 dark:text-warning-400">ADJ</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">{{ number_format($txn->quantity, 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($txn->previous_stock, 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($txn->new_stock, 2) }}</td>
                            <td class="px-4 py-3">{{ $txn->reason }}</td>
                            <td class="px-4 py-3">{{ $txn->user?->name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">No transactions in the selected period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
