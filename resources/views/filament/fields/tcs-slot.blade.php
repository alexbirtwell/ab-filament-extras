@props([
    'content' => null,
    'class' => 'text-sm text-gray-900 dark:text-gray-100',
    'icon' => null
])
    <style>
        .tcs h1,.tcs h2,.tcs h3,.tcs h4,.tcs h5,.tcs h6 {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        .tcs p {
            margin: 10px 0;
        }
        .tcs ul, .tcs ol {
            margin: 10px 0;
            padding-left: 20px;
        }
    </style>
<div class="{{ $getClass() }} tcs my-2 h-80 p-4 rounded overflow-scroll border-gray-100 border-2">
    {!! $getContent() !!}
</div>
<x-forms::field-wrapper.helper-text>{!! $getHelperText() !!}</x-forms::field-wrapper.helper-text>
