<x-filament::page>
    <h2>{{ $monthName }}</h2>
    <div wire:key="'{{rand()}}'">
        <livewire:timex-month/>
    </div>

</x-filament::page>
