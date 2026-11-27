<x-layouts.site :title="$project->title" :description="$project->translation()?->seo_description ?: $project->summary">
    @php($translation = $project->translation())
    <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-10">
        <a href="{{ route('projects.index') }}" class="font-display font-semibold text-mist underline decoration-accent underline-offset-4">{{ __('Retour aux projets') }}</a>
        <header class="mt-12 max-w-4xl">
            <p class="fc-kicker">{{ $project->category?->name }}</p>
            <h1 class="mt-6 font-display text-6xl font-bold leading-[0.86] tracking-tight sm:text-8xl">{{ $project->title }}</h1>
            <p class="mt-8 max-w-2xl text-xl leading-relaxed text-mist">{{ $project->summary }}</p>
        </header>
        @if ($project->cover_image || $project->images->isNotEmpty())
            <div class="mt-16 grid gap-4 sm:grid-cols-2">
                @if ($project->cover_image)<img src="{{ Storage::url($project->cover_image) }}" alt="{{ $translation?->cover_alt ?: $project->title }}" loading="lazy" class="aspect-video w-full object-cover sm:col-span-2">@endif
                @foreach ($project->images as $image)
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->altFor() }}" loading="lazy" class="aspect-video w-full object-cover">
                @endforeach
            </div>
        @endif
        <div class="mt-16 grid gap-12 lg:grid-cols-[1.2fr_0.8fr]">
            <article class="grid gap-10">
                @foreach ([['context', 'Contexte'], ['problem', 'Problématique'], ['solution', 'Solution'], ['contributions', 'Mes contributions'], ['features', 'Fonctionnalités']] as [$field, $label])
                    @if ($translation?->{$field})<section><h2 class="font-display text-3xl font-bold">{{ __($label) }}</h2><p class="mt-4 whitespace-pre-line leading-relaxed text-mist">{{ $translation->{$field} }}</p></section>@endif
                @endforeach
            </article>
            <aside class="fc-panel cut [--cut:1rem] h-fit p-6">
                <dl class="grid gap-5 text-sm">
                    @if ($project->involvement)<div><dt class="fc-kicker">{{ __('Participation') }}</dt><dd class="mt-2 text-mist">{{ $project->involvement->value }}</dd></div>@endif
                    @if ($project->started_on)<div><dt class="fc-kicker">{{ __('Période') }}</dt><dd class="mt-2 text-mist">{{ $project->started_on->format('m/Y') }}{{ $project->ended_on ? ' - '.$project->ended_on->format('m/Y') : '' }}</dd></div>@endif
                    <div><dt class="fc-kicker">{{ __('Technologies') }}</dt><dd class="mt-2 flex flex-wrap gap-2">@foreach ($project->technologies as $technology)<x-ui.badge>{{ $technology->name }}</x-ui.badge>@endforeach</dd></div>
                </dl>
                <div class="mt-8 flex flex-wrap gap-4">@if ($project->project_url)<a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="font-display font-semibold text-accent underline">{{ __('Voir le site') }}</a>@endif @if ($project->repository_url)<a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer" class="font-display font-semibold text-accent underline">{{ __('Voir le code') }}</a>@endif</div>
            </aside>
        </div>
    </div>
</x-layouts.site>
