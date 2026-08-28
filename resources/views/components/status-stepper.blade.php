@php
    $status = $request->status ?? ($status ?? 'pending');

    $phases = [
        ['key' => 'pending', 'label' => 'Pending', 'color' => 'amber', 'icon' => 'clock', 'date_key' => 'date_submitted'],
        ['key' => 'reviewing', 'label' => 'Reviewing', 'color' => 'sky', 'icon' => 'magnifier', 'date_key' => null],
        ['key' => 'approved', 'label' => 'Approved', 'color' => 'emerald', 'icon' => 'check-badge', 'date_key' => 'approved_at'],
        ['key' => 'in_production', 'label' => 'In Production', 'color' => 'orange', 'icon' => 'wrench', 'date_key' => 'in_production_at'],
        ['key' => 'ready_for_pickup', 'label' => 'Ready for Pickup', 'color' => 'violet', 'icon' => 'truck', 'date_key' => null],
        ['key' => 'completed', 'label' => 'Completed', 'color' => 'teal', 'icon' => 'check-circle', 'date_key' => 'completed_at'],
    ];

    $icons = [
        'clock' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
        'magnifier' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z',
        'check-badge' => 'M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z',
        'wrench' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z',
        'truck' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
        'check-circle' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'check' => 'M4.5 12.75l6 6 9-13.5',
        'x-circle' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];

    $solid = [
        'amber' => 'bg-amber-500', 'sky' => 'bg-sky-500', 'emerald' => 'bg-emerald-500',
        'orange' => 'bg-orange-500', 'violet' => 'bg-violet-500', 'teal' => 'bg-teal-500',
    ];
    $text = [
        'amber' => 'text-amber-600 dark:text-amber-400', 'sky' => 'text-sky-600 dark:text-sky-400',
        'emerald' => 'text-emerald-600 dark:text-emerald-400', 'orange' => 'text-orange-600 dark:text-orange-400',
        'violet' => 'text-violet-600 dark:text-violet-400', 'teal' => 'text-teal-600 dark:text-teal-400',
    ];
    $ring = [
        'amber' => 'ring-amber-500/70', 'sky' => 'ring-sky-500/70', 'emerald' => 'ring-emerald-500/70',
        'orange' => 'ring-orange-500/70', 'violet' => 'ring-violet-500/70', 'teal' => 'ring-teal-500/70',
    ];
    $pulse = [
        'amber' => 'bg-amber-500/40', 'sky' => 'bg-sky-500/40', 'emerald' => 'bg-emerald-500/40',
        'orange' => 'bg-orange-500/40', 'violet' => 'bg-violet-500/40', 'teal' => 'bg-teal-500/40',
    ];

    $keys = array_column($phases, 'key');
    $isTerminal = in_array($status, ['cancelled', 'rejected']);
    $currentIndex = $isTerminal ? null : array_search($status, $keys);
    $currentIndex = $currentIndex === false ? null : $currentIndex;
    $terminalLabel = $status === 'cancelled' ? 'Cancelled' : 'Rejected';
@endphp

<div class="w-full overflow-x-auto">
    <div class="flex items-start min-w-[560px]">
        @foreach ($phases as $i => $phase)
            @php
                $done = ! $isTerminal && $currentIndex !== null && $i < $currentIndex;
                $active = ! $isTerminal && $currentIndex === $i;
                $upcoming = ! $isTerminal && ! $done && ! $active;
                $icon = $done ? 'check' : $phase['icon'];
                $date = $phase['date_key'] && $request && $request->{$phase['date_key']}
                    ? $request->{$phase['date_key']}->format('M d, Y')
                    : null;
            @endphp

            <div class="flex flex-col items-center flex-1 min-w-0 px-1">
                <div class="relative">
                    @if ($active)
                        <span class="absolute -inset-1.5 rounded-full animate-ping {{ $pulse[$phase['color']] }}"></span>
                    @endif
                    <div class="relative w-11 h-11 rounded-full flex items-center justify-center transition
                        {{ $done ? $solid[$phase['color']] . ' shadow-lg shadow-black/40' : ($active ? 'bg-white dark:bg-gray-800 ring-2 ' . $ring[$phase['color']] . ' shadow-lg shadow-black/40' : 'bg-white dark:bg-gray-800 ring-1 ring-gray-300 dark:ring-gray-600') }}">
                        <svg class="w-5 h-5 {{ $done ? 'text-white' : ($active ? $text[$phase['color']] : 'text-gray-400 dark:text-gray-500') }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$icon] }}" />
                        </svg>
                    </div>
                </div>
                <span class="mt-2 text-xs font-bold text-center {{ $active ? $text[$phase['color']] : 'text-gray-500 dark:text-gray-400' }}">{{ $phase['label'] }}</span>
                @if ($date)
                    <span class="mt-0.5 text-[10px] text-gray-400 dark:text-gray-500">{{ $date }}</span>
                @endif
            </div>

            @if (! $loop->last)
                <div class="flex-1 h-1 rounded-full mt-5 -mx-1 {{ $done ? $solid[$phase['color']] : 'bg-gray-200 dark:bg-gray-700' }}"></div>
            @endif
        @endforeach

        @if ($isTerminal)
            <div class="flex flex-col items-center flex-1 min-w-0 px-1">
                <div class="relative">
                    <span class="absolute -inset-1.5 rounded-full animate-ping bg-rose-500/40"></span>
                    <div class="relative w-11 h-11 rounded-full bg-white dark:bg-gray-800 ring-2 ring-rose-500/70 shadow-lg shadow-black/40 flex items-center justify-center">
                        <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $status === 'cancelled' ? $icons['x-circle'] : $icons['x-circle'] }}" />
                        </svg>
                    </div>
                </div>
                <span class="mt-2 text-xs font-bold text-center text-rose-600 dark:text-rose-400">{{ $terminalLabel }}</span>
                @if ($request && $request->status === 'rejected' && $request->rejected_at)
                    <span class="mt-0.5 text-[10px] text-gray-400 dark:text-gray-500">{{ $request->rejected_at->format('M d, Y') }}</span>
                @endif
            </div>
        @endif
    </div>
</div>
