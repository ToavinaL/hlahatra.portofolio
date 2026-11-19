@props(['tone' => 'default'])

<span {{ $attributes->class([
    'cut [--cut:0.4rem] inline-flex items-center border border-white/10 px-2.5 py-1 font-mono text-sm transition-colors duration-300',
    'bg-surface/80 text-mist hover:border-accent/60 hover:text-bone' => $tone !== 'accent',
    'bg-accent text-ink' => $tone === 'accent',
]) }}>{{ $slot }}</span>
