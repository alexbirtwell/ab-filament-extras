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
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}'), selected: false, selected_label: '' }">
        <!-- Interact with the `state` property in Alpine.js -->
        <div {{ $attributes->merge($getExtraAttributes())->class(['flex items-center space-x-1 rtl:space-x-reverse group filament-forms-text-input-component']) }}><!-- filament-forms-text-input-component -->
            <div class="flex-1"><!-- flex -->
                <div class="flex" x-show="this.selected">
                    <div x-text="this.selected_label" class="w-3/4"></div>
                    <div x-on:click="clearSelection()" wire:click="$set('{{$getStatePath()}}',0)" class="w-1/4 text-danger-600 ml-2 text-sm">(clear)</div>
                </div>
                <input type="hidden"
                       wire:model="{{$getStatePath()}}"
                       id="{{$getId()}}"
                />
                <input
                    {{ $attributes->class([
                        'block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70',
                        'dark:bg-gray-700 dark:text-white' => config('forms.dark_mode'),
                        'border-gray-300' => ! $errors->has($getStatePath()),
                        'dark:border-gray-600' => (! $errors->has($getStatePath())) && config('forms.dark_mode'),
                        'border-danger-600 ring-danger-600' => $errors->has($getStatePath()),
                    ]) }}
                    type="text"
                    dusk="filament.forms.{{ $getStatePath() }}"
                    id="{{ str_replace('data.', '',$getStatePath()) . "_text" }}"
                    x-show="!this.selected"
                    wire:model="{{$getStatePath() . "_text"}}"
                    />
                    <div x-show="!this.selected">
                        <div wire:loading>Searching...</div>
                        <div wire:loading.remove>
                            <!--
                                notice that $term is available as a public
                                variable, even though it's not part of the
                                data array
                            -->
                            @if (data_get($getLivewire(), $getStatePath()."_text") == "")
                                <div class="text-gray-500 text-sm">
                                    Enter a term to search.
                                </div>
                            @else
                                @if($results->isEmpty())
                                    <div class="text-gray-500 text-sm">
                                        No matching result was found.
                                    </div>
                                @else
                                    @foreach($results as $result)
                                        <div>
                                            <p class="text-gray-500 text-sm"
                                               x-on:click="selectOption('{{$result->getSearchLabelAttribute()}}')"
                                               wire:click="$set('{{$getStatePath()}}','{{$result->id}}')"
                                            >{{$result->getSearchLabelAttribute()}}</p>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div><!-- div wire:loading.remove -->
                    </div>
                </div><!--flex-->
            </div><!-- field -->
        <script>
            function selectOption(label) {
                this.selected = true;
                this.selected_label = label;
            }
            function clearSelection() {
                this.selected = false;
                this.selected_label = '';
            }
        </script>
    </div>
</x-forms::field-wrapper>
