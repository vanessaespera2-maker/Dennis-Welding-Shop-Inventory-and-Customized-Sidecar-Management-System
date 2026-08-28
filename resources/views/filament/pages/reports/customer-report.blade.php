<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->getHeading() }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $this->getSubtitle() }}</p>
    </div>

    @php($summary = $this->getSummary())

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Customers</p>
            <p class="text-2xl font-bold">{{ $summary['total'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Requests</p>
            <p class="text-2xl font-bold">{{ $summary['total_requests'] }}</p>
        </div>
        <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Customer Spend</p>
            <p class="text-2xl font-bold text-success-600">₱{{ number_format($summary['total_spend'], 2) }}</p>
        </div>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Customer</th>
                        <th class="px-4 py-3 text-left font-medium">Email</th>
                        <th class="px-4 py-3 text-left font-medium">Phone</th>
                        <th class="px-4 py-3 text-right font-medium">Requests</th>
                        <th class="px-4 py-3 text-right font-medium">Completed</th>
                        <th class="px-4 py-3 text-right font-medium">Total Spend</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($this->getCustomers() as $customer)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $customer['name'] }}</td>
                            <td class="px-4 py-3">{{ $customer['email'] }}</td>
                            <td class="px-4 py-3">{{ $customer['phone'] }}</td>
                            <td class="px-4 py-3 text-right">{{ $customer['requests'] }}</td>
                            <td class="px-4 py-3 text-right text-success-600">{{ $customer['completed'] }}</td>
                            <td class="px-4 py-3 text-right font-medium">₱{{ number_format($customer['spend'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No customers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
