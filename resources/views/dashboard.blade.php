<x-customer-layout :title="'Dashboard'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-950">Welcome, {{ auth()->user()->name }}</h1>
                <p class="mt-1 text-gray-500">Here's an overview of your customization activity.</p>
            </div>
            <a href="{{ route('customize') }}" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3 font-semibold text-gray-950 hover:bg-amber-400 transition">New Customization</a>
        </div>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Requests</p>
                <p class="mt-1 text-3xl font-extrabold text-gray-950">{{ $requestCount }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="mt-1 text-3xl font-extrabold text-amber-600">{{ $pendingCount }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Completed</p>
                <p class="mt-1 text-3xl font-extrabold text-emerald-600">{{ $completedCount }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Spent</p>
                <p class="mt-1 text-2xl font-extrabold text-gray-950">₱{{ number_format($totalSpent, 2) }}</p>
            </div>
        </div>

        <div class="mt-10">
            <div class="flex items-end justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-950">Recent Requests</h2>
                <a href="{{ route('requests.index') }}" class="text-sm font-semibold text-amber-600 hover:text-amber-500">View all →</a>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-4 py-3 font-medium">Request</th>
                            <th class="px-4 py-3 font-medium">Sidecar</th>
                            <th class="px-4 py-3 font-medium">Est. Price</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Submitted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($requests as $request)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3"><a href="{{ route('requests.show', $request) }}" class="font-semibold text-amber-600 hover:text-amber-500">{{ $request->request_number }}</a></td>
                                <td class="px-4 py-3 text-gray-700">{{ $request->sidecar?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-700">₱{{ number_format($request->estimated_price, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ match ($request->status) {
                                        'completed' => 'bg-emerald-50 text-emerald-700',
                                        'pending' => 'bg-amber-50 text-amber-700',
                                        'rejected' => 'bg-rose-50 text-rose-700',
                                        default => 'bg-sky-50 text-sky-700',
                                    } }}">{{ \App\Models\CustomizationRequest::STATUSES[$request->status] ?? $request->status }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $request->date_submitted->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No requests yet. <a href="{{ route('customize') }}" class="text-amber-600 font-semibold">Start customizing</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-customer-layout>
