<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-filament-support::button
            wire:click="saveForm"
            class="mt-4"
        >
            Save
        </x-filament-support::button>
    </form>

</x-filament::page>
