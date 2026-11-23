@props(['project'])

@php
    $translation = $project->translation();
    $imagePath = $project->cover_image ?: $project->images->first()?->path;
    $image = $imagePath ? \Illuminate\Support\Facades\Storage::url($imagePath) : null;
    $imageAlt = $translation?->cover_alt ?: $project->title;
@endphp

<article {{ $attributes->class('fc-project-card group relative flex flex-col bg-surface cut [--cut:1.25rem] transition-[transform,box-shadow] duration-500 ease-out hover:-translate-y-2 hover:shadow-[0_1.5rem_3rem_rgb(0_0_0/0.28)] motion-reduce:transition-none motion-reduce:hover:translate-y-0') }}>
    <div class="relative aspect-[16/10] overflow-hidden bg-ink">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $imageAlt }}" loading="lazy" decoding="async" class="size-full object-cover transition-transform duration-700 group-hover:scale-105 motion-reduce:transition-none">
        @else
            <div class="fc-project-placeholder grid size-full place-items-center" role="img" aria-label="{{ __('Image de projet indisponible') }}">
                <div class="relative z-10 grid gap-3 text-center">
                    <span class="font-mono text-xs tracking-[0.2em] text-accent">FC/{{ str_pad((string) ($project->sort_order + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="font-display text-xl font-bold text-bone/80">{{ __('Aperçu bientôt disponible') }}</span>
                </div>
            </div>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-4 p-6">
        <div>
            <p class="fc-kicker">{{ $project->category?->name }}</p>
            <h3 class="mt-4 font-display text-3xl font-bold leading-none">{{ $project->title }}</h3>
        </div>

        <p class="leading-relaxed text-mist">{{ $project->summary }}</p>

        @if ($project->technologies->isNotEmpty())
            <ul class="flex flex-wrap gap-2" aria-label="{{ __('Technologies utilisées') }}">
                @foreach ($project->technologies as $technology)
                    <li><x-ui.badge>{{ $technology->name }}</x-ui.badge></li>
                @endforeach
            </ul>
        @endif

        @if ($project->repository_url || $project->project_url)
            <div class="mt-auto flex flex-wrap gap-3 pt-2">
                @if ($project->repository_url)
                    <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer" class="font-display font-semibold text-mist underline decoration-accent underline-offset-4 transition-colors hover:text-accent focus-visible:text-accent">
                        {{ __('Voir le code') }}
                    </a>
                @endif
                @if ($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="font-display font-semibold text-mist underline decoration-accent underline-offset-4 transition-colors hover:text-accent focus-visible:text-accent">
                        {{ __('Voir le site') }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</article>
