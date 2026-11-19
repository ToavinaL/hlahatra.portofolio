@props(['tone' => 'default'])

<span {{ $attributes->class([
    'cut [--cut:0.4rem] inline-flex items-center px-2.5 py-1 font-mono text-sm',
    'bg-surface text-mist' => $tone !== 'accent',
    'bg-accent text-ink' => $tone === 'accent',
]) }}>{{ $slot }}</span>
