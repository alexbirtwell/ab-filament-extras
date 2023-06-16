@if($getAlign() == 'right')
    <div class="text-right">
@endif
    <x-forms::button
        tag="{{ $getUrl() ? 'a' : 'button' }}"
        color="{{ $getColor() ?? 'primary' }}"
        href="{{ $getUrl() }}"
        target="{{ $shouldOpenUrlInNewTab() ? '_blank' : null }}"
        wire:click="{{ $getActionName() }}"
        {{ $attributes->merge($getExtraAttributes()) }}
    >
        {{ $getLabel() }}
    </x-forms::button>
@if($getAlign() == 'right')
    </div>
@endif
