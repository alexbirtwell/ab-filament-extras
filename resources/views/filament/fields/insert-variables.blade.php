@php
    $affixLabelClasses = [
        'whitespace-nowrap group-focus-within:text-primary-500',
        'text-gray-400' => ! $errors->has($getStatePath()),
        'text-danger-400' => $errors->has($getStatePath()),
    ];
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div
        {{ $attributes->merge($getExtraAttributes())->class(['filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group']) }}
        x-data="{
            variables: @js($variables),
            target: @js($target),
            insertVariable(variable) {
                if (tinymce.get(`tiny-editor-data.${this.target}`)) {
                    tinymce.get(`tiny-editor-data.${this.target}`).execCommand('mceInsertContent', false, variable);

                    return;
                }

                const target = document.getElementById(`data.${this.target}`)
                // will give the current position of the cursor
                const curPos = target.selectionStart;
                const content = target.value;
                // setting the updated value in the text area
                target.value = content.slice(0, curPos) + variable + content.slice(curPos);
            }
        }"
    >
        @if (($prefixAction = $getPrefixAction()) && (! $prefixAction->isHidden()))
            {{ $prefixAction }}
        @endif

        @if ($icon = $getPrefixIcon())
            <x-dynamic-component :component="$icon" class="w-5 h-5" />
        @endif

        @if ($label = $getPrefixLabel())
            <span @class($affixLabelClasses)>
                {{ $label }}
            </span>
        @endif

        <div class="flex flex-wrap gap-2">
            <template x-for="(label, variable) in variables">
                <x-filament::button
                    color="gray"
                    x-text="label"
                    x-on:click="insertVariable(variable)"
                />
            </template>
        </div>

        @if ($label = $getSuffixLabel())
            <span @class($affixLabelClasses)>
                {{ $label }}
            </span>
        @endif

        @if ($icon = $getSuffixIcon())
            <x-dynamic-component :component="$icon" class="w-5 h-5" />
        @endif

        @if (($suffixAction = $getSuffixAction()) && (! $suffixAction->isHidden()))
            {{ $suffixAction }}
        @endif
    </div>
</x-dynamic-component>
