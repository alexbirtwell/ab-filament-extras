@props([
    'content' => null,
    'class' => 'text-sm text-gray-900 dark:text-gray-100',
    'icon' => null
])

<div class="{{ $getClass() }} my-2">

    @if($getIcon())
            <x-dynamic-component :component="$getIcon()" class="fill-primary h-4 w-4 mt-1 mr-2"></x-dynamic-component>
    @endif
    {!! $getContent() !!}
</div>
