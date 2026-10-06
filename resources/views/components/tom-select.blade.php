@props([
    'placeholder' => 'Pilih opsi...',
    'multiple' => false,
    'maxItems' => null,
    'id' => null,
])

@php
    $wireModel = $attributes->wire('model')->value();
    $id = $id ?? 'ts_' . md5(($wireModel ?: '') . Str::random(8));
@endphp

<div
    wire:ignore
    x-data="{
        selectInstance: null,
        init() {
            let el = this.$refs.selectEl;
            if (el.tomselect) {
                el.tomselect.destroy();
            }

            this.selectInstance = new TomSelect(el, {
                plugins: {{ $multiple ? "['dropdown_input', 'remove_button']" : "['dropdown_input']" }},
                placeholder: '{{ $placeholder }}',
                create: false,
                maxItems: {{ $multiple ? ($maxItems ?: 'null') : 1 }},
                allowEmptyOption: true,
                onChange: (val) => {
                    el.dispatchEvent(new Event('input', { bubbles: true }));
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });

            @if($wireModel)
            if (typeof this.$wire !== 'undefined') {
                this.$watch('$wire.{{ $wireModel }}', (newVal) => {
                    if (this.selectInstance && this.selectInstance.getValue() !== (newVal || '')) {
                        this.selectInstance.setValue(newVal || '', true);
                    }
                });
            }
            @endif

        },
        destroy() {
            if (this.selectInstance) {
                try {
                    this.selectInstance.destroy();
                } catch (e) {}
                this.selectInstance = null;
            }
        }
    }"
    class="w-full relative"
>
    <select
        x-ref="selectEl"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => 'w-full']) }}
        {{ $multiple ? 'multiple' : '' }}
    >
        <option value="">{{ $placeholder }}</option>
        {{ $slot }}
    </select>
</div>
