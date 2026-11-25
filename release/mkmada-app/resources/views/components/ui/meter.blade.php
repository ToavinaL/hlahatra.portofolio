{{--
    Indicateur de niveau en segments. La valeur vient de l'administration :
    ce composant ne fixe jamais de niveau lui-même.
--}}
@props(['label', 'value', 'max' => 5])

@php
    $max = max(1, (int) $max);
    $value = min(max((int) $value, 0), $max);
@endphp

<div {{ $attributes->class('flex items-center justify-between gap-4') }}>
    <span class="font-display text-lg font-semibold">{{ $label }}</span>

    <div
        role="meter"
        aria-label="{{ $label }}"
        aria-valuemin="0"
        aria-valuemax="{{ $max }}"
        aria-valuenow="{{ $value }}"
        aria-valuetext="{{ $value }}/{{ $max }}"
        class="flex gap-1"
    >
        @for ($i = 1; $i <= $max; $i++)
            <span
                data-filled="{{ $i <= $value ? 'true' : 'false' }}"
                class="cut [--cut:0.35rem] h-3 w-6 {{ $i <= $value ? 'bg-accent' : 'bg-surface' }}"
            ></span>
        @endfor
    </div>
</div>
