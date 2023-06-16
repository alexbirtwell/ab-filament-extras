<x-filament::widget>
    <x-filament::card>
        @dump(auth()->user(),auth()->user()->sites)
        @if(! auth()->user()->sites)
            <h2>create site</h2>
        @endif
    </x-filament::card>
</x-filament::widget>
