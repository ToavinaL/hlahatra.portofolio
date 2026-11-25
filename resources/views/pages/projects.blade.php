<x-layouts.site :title="__('Projets')">
    <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-10">
        <header class="fc-section-reveal fc-motion-rise max-w-3xl" data-reveal>
            <p class="fc-kicker">{{ __('Portfolio') }}</p>
            <h1 class="mt-6 font-display text-6xl font-bold leading-[0.86] tracking-tight sm:text-8xl">{{ __('Les projets') }}</h1>
            <p class="mt-8 max-w-2xl text-lg leading-relaxed text-mist sm:text-xl">{{ __('Une sélection de plateformes, applications et sites construits pour des besoins concrets.') }}</p>
        </header>

        <form method="GET" class="mt-12 grid gap-4 border-y border-white/10 py-6 sm:grid-cols-3">
            <label class="grid gap-2 font-display font-semibold">{{ __('Catégorie') }}<select name="category" class="fc-form-input"><option value="">{{ __('Toutes') }}</option>@foreach ($categories as $category)<option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>@endforeach</select></label>
            <label class="grid gap-2 font-display font-semibold">{{ __('Technologie') }}<select name="technology" class="fc-form-input"><option value="">{{ __('Toutes') }}</option>@foreach ($technologies as $technology)<option value="{{ $technology->slug }}" @selected($selectedTechnology === $technology->slug)>{{ $technology->name }}</option>@endforeach</select></label>
            <button class="self-end bg-accent px-5 py-3 font-display font-bold text-ink" type="submit">{{ __('Filtrer') }}</button>
        </form>

        @if ($projects->isNotEmpty())
            <section class="fc-section-reveal fc-motion-scale mt-20 sm:mt-28" data-reveal aria-labelledby="all-projects-title">
                <div class="mb-8 flex items-end justify-between gap-6 border-b border-white/10 pb-5">
                    <h2 id="all-projects-title" class="font-display text-3xl font-bold sm:text-4xl">{{ __('Tous les projets') }}</h2>
                    <span class="font-mono text-xs text-accent">{{ str_pad((string) $projects->count(), 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($projects as $project)
                        <x-ui.portfolio-project-card :project="$project" class="fc-project-card" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-layouts.site>
