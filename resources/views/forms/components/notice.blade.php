<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div>
        <!-- Interact with the `state` property in Alpine.js -->
            <div class="flex-1"><!-- flex -->

<div class="border-t-4 rounded-b px-4 py-3 shadow-md
    @switch($message_type)
        @case('success')
            bg-green-100 border-green-400 text-green-800
        @break
        @case('error')
            bg-red-100 border-red-400 text-red-800
        @break
        @case('warning')
            bg-warning-500 text-white
        @break
        @case('info')
            bg-blue-100 border-blue-400 text-blue-800
        @break
        @default
            bg-gray-100 border-gray-400 text-gray-800
        @break
    @endswitch
" role="alert">
  <div class="flex">
    <div class="py-1 pr-6"><svg class="fill-current h-6 w-6 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
        @if($message_title)
            <p class="font-bold">{{$message_title}}</p>
        @endif
      <p class="text-sm">{{$message_message}}</p>
    </div>
  </div>
</div>
            </div><!--flex-->
    </div>
</x-forms::field-wrapper>

