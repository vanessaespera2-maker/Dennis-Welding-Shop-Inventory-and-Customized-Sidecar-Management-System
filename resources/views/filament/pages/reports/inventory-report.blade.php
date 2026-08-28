<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->getHeading() }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $this->getSubtitle() }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Inventory Items</p>
            <p class="text-2xl font-bold">{{ $this->getTotals()['total_items'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Stock Value</p>
            <p class="text-2xl font-bold">₱{{ number_format($this->getTotals()['total_value'], 2) }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Low Stock Items</p>
            <p class="text-2xl font-bold text-danger-600 dark:text-danger-400">{{ $this->getTotals()['low_stock'] }}</p>
        </div>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Item</th>
                        <th class="px-4 py-3 text-left font-medium">Category</th>
                        <th class="px-4 py-3 text-right font-medium">Stock</th>
                        <th class="px-4 py-3 text-right font-medium">Reorder Level</th>
                        <th class="px-4 py-3 text-right font-medium">Unit Cost</th>
                        <th class="px-4 py-3 text-right font-medium">Stock Value</th>
                        <th class="px-4 py-3 text-center font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($this->getItems() as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['sku'] }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $item['category'] }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($item['current_stock'], 0) }} {{ $item['unit'] }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($item['reorder_level'], 0) }}</td>
                            <td class="px-4 py-3 text-right">₱{{ number_format($item['unit_cost'], 2) }}</td>
                            <td class="px-4 py-3 text-right font-medium">₱{{ number_format($item['stock_value'], 2) }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($item['status'] === 'Low Stock')
                                    <span class="inline-flex items-center rounded-full bg-danger-50 dark:bg-danger-500/10 px-2 py-1 text-xs font-medium text-danger-700 dark:text-danger-400">{{ $item['status'] }}</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-success-50 dark:bg-success-500/10 px-2 py-1 text-xs font-medium text-success-700 dark:text-success-400">{{ $item['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No inventory items found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
