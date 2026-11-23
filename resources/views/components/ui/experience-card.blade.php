@props(['experience'])

@php
    $period = match (true) {
        $experience->started_on && $experience->ended_on => $experience->started_on->format('m/Y').' — '.$experience->ended_on->format('m/Y'),
        $experience->started_on && $experience->is_current => $experience->started_on->format('m/Y').' — '.__('Aujourd’hui'),
        $experience->started_on => $experience->started_on->format('m/Y'),
        default => __('Période non précisée'),
    };
    $missions = preg_split('/\r\n|\r|\n/', $experience->translation()?->missions ?? '', -1, PREG_SPLIT_NO_EMPTY);
@endphp

<li class="relative pl-10 sm:pl-14">
    <span aria-hidden="true" class="absolute left-2 top-7 grid size-5 -translate-x-1/2 place-items-center border border-accent bg-ink">
        <span class="size-2 bg-accent"></span>
    </span>
    <article class="fc-panel cut [--cut:0.9rem] p-5 sm:p-7">
        <header class="flex flex-col gap-3 border-b border-white/10 pb-5 sm:flex-row sm:items-start sm:justify-between sm:gap-6">
            <div>
                <p class="fc-kicker">{{ $experience->company }}</p>
                <h3 class="mt-4 font-display text-3xl font-bold leading-none sm:text-4xl">{{ $experience->role }}</h3>
            </div>
            <p class="shrink-0 font-mono text-xs text-accent">{{ $period }}</p>
        </header>

        @if (count($missions))
            <ul class="mt-6 space-y-4 text-sm leading-relaxed text-mist sm:text-base">
                @foreach ($missions as $mission)
                    @php($parts = explode(' — ', $mission, 2))
                    <li class="relative pl-5 before:absolute before:left-0 before:top-[0.7em] before:h-px before:w-3 before:bg-accent">
                        @if (count($parts) === 2)
                            <strong class="font-semibold text-bone">{{ $parts[0] }}</strong><span> — {{ $parts[1] }}</span>
                        @else
                            {{ $mission }}
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($experience->technologies->isNotEmpty())
            <ul class="mt-7 flex flex-wrap gap-2" aria-label="{{ __('Technologies utilisées') }}">
                @foreach ($experience->technologies as $technology)
                    <li><x-ui.badge>{{ $technology->name }}</x-ui.badge></li>
                @endforeach
            </ul>
        @endif
    </article>
</li>
