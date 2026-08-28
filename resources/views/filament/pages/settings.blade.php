<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->getHeading() }}</h1>
    </div>

    <div class="rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-200 dark:border-gray-700">
        {{ $this->form }}
    </div>
</x-filament-panels::page>
