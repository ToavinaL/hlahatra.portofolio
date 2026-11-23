@props(['experience'])

@php
    $period = match (true) {
        $experience->started_on && $experience->ended_on => $experience->started_on->format('m/Y').' — '.$experience->ended_on->format('m/Y'),
        $experience->started_on && $experience->is_current => $experience->started_on->format('m/Y').' — '.__('Aujourd’hui'),
        $experience->started_on => $experience->started_on->format('m/Y'),
        default => __('Période non précisée'),
    };
@endphp

<article class="fc-glow-card cut [--cut:0.9rem]">
    <div class="fc-glow-card__content flex h-full flex-col gap-8 bg-ink/95 p-5 sm:p-7">
        <header class="flex flex-col gap-5">
            <div>
                <p class="fc-kicker">{{ $experience->company }}</p>
                <h3 class="mt-4 font-display text-3xl font-bold leading-none sm:text-4xl">{{ $experience->role }}</h3>
            </div>
            <p class="font-mono text-xs tracking-[0.16em] text-accent">{{ $period }}</p>
        </header>
        <span aria-hidden="true" class="mt-auto block h-px w-1/2 bg-gradient-to-r from-accent to-transparent"></span>
    </div>
</article>
