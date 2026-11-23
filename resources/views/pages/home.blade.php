<x-layouts.site>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-10">
        <section class="relative grid min-h-[calc(100vh-5rem)] items-center gap-16 py-20 lg:grid-cols-[minmax(0,1.1fr)_minmax(22rem,0.9fr)] lg:gap-20 lg:py-28">
            <div class="fc-scanline pointer-events-none" aria-hidden="true"></div>
            <div class="relative z-10 max-w-3xl">
                <p class="fc-kicker fc-reveal">{{ __('Développeur Web Full Stack') }}</p>
                <h1 class="fc-reveal fc-delay-1 mt-7 max-w-4xl font-display text-[clamp(4.5rem,12vw,10.5rem)] font-bold leading-[0.78] tracking-[-0.07em]">{{ config('app.name') }}<span class="text-accent">.</span></h1>
                <p class="fc-reveal fc-delay-2 mt-10 max-w-xl text-lg leading-relaxed text-mist sm:text-xl">{{ __('Je conçois et je maintiens des applications web : plateformes de gestion, e-commerce et projets communautaires.') }}</p>
                <div class="fc-reveal fc-delay-3 mt-10 flex flex-wrap gap-3">
                    <x-ui.button :href="route('projects.index')">{{ __('Voir les projets') }} <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1">↗</span></x-ui.button>
                    <x-ui.button :href="route('contact')" variant="ghost">{{ __('Me contacter') }}</x-ui.button>
                </div>
                <div class="mt-16 flex items-center gap-5 text-mist/60"><span class="h-px w-12 bg-accent"></span><p class="font-mono text-xs tracking-[0.18em]">BUILD. FIGHT. CREATE.</p></div>
            </div>
            <aside class="fc-panel fc-float relative overflow-hidden p-6 sm:p-8 lg:mt-14" aria-label="{{ __('Technologies utilisées') }}">
                <div class="relative">
                    <div class="flex items-start justify-between gap-4"><div><p class="fc-kicker">{{ __('Stack active') }}</p><h2 class="mt-5 max-w-xs font-display text-4xl font-bold leading-none sm:text-5xl">{{ __('Des idées solides. Du code qui tient.') }}</h2></div><span class="font-mono text-xs text-accent">FC/01</span></div>
                    <div class="fc-rule my-8"></div>
                    <ul class="grid grid-cols-2 gap-2">
                        @foreach (['Laravel', 'Symfony', 'CodeIgniter 4', 'PHP 8', 'WordPress', 'Stripe', 'Mercure'] as $technology)
                            <li><x-ui.badge class="w-full justify-between">{{ $technology }} <span aria-hidden="true" class="text-accent">+</span></x-ui.badge></li>
                        @endforeach
                    </ul>
                    <p class="mt-8 max-w-sm font-mono text-xs leading-relaxed text-mist/60">{{ __('Un portfolio en construction continue, pensé pour montrer le travail derrière chaque interface.') }}</p>
                </div>
            </aside>
        </section>
        <section class="border-t border-white/10 py-20 sm:py-28" data-reveal>
            <div class="grid gap-12 lg:grid-cols-[0.75fr_1.25fr] lg:gap-24">
                <div><p class="fc-kicker">{{ __('Ce que je construis') }}</p><h2 class="mt-5 max-w-sm font-display text-5xl font-bold leading-[0.9] sm:text-6xl">{{ __('Des expériences qui passent le test du réel.') }}</h2></div>
                <div class="grid gap-4 sm:grid-cols-3">
                    @foreach ([['01', 'Plateformes', 'Des outils métier clairs, rapides et durables.'], ['02', 'E-commerce', 'Des parcours qui donnent envie d’aller au bout.'], ['03', 'Communautés', 'Des espaces qui rapprochent les personnes et les idées.']] as [$index, $title, $text])
                        <article class="fc-panel cut [--cut:0.8rem] p-5 transition-colors duration-300 hover:border-accent/60"><p class="font-mono text-xs text-accent">{{ $index }}</p><h3 class="mt-12 font-display text-2xl font-bold">{{ __($title) }}</h3><p class="mt-3 text-sm leading-relaxed text-mist">{{ __($text) }}</p></article>
                    @endforeach
                </div>
            </div>
        </section>
        @if ($experiences->isNotEmpty())
            <section id="experiences" class="border-t border-white/10 py-20 sm:py-28" data-reveal aria-labelledby="experiences-title">
                <div class="grid gap-12 lg:grid-cols-[0.75fr_1.25fr] lg:gap-24">
                    <div>
                        <p class="fc-kicker">{{ __('Parcours') }}</p>
                        <h2 id="experiences-title" class="mt-5 max-w-sm font-display text-5xl font-bold leading-[0.9] sm:text-6xl">{{ __('Expériences') }}</h2>
                        <p class="mt-6 max-w-sm leading-relaxed text-mist">{{ __('Des projets web construits pour répondre à des besoins concrets.') }}</p>
                    </div>
                    <ol class="relative space-y-8 before:absolute before:bottom-6 before:left-2 before:top-6 before:w-px before:bg-gradient-to-b before:from-accent before:via-white/20 before:to-transparent">
                        @foreach ($experiences as $experience)
                            <x-ui.experience-card :experience="$experience" />
                        @endforeach
                    </ol>
                </div>
            </section>
        @endif
        @if ($featuredProjects->isNotEmpty())
            <section id="projects" class="border-t border-white/10 py-20 sm:py-28" data-reveal aria-labelledby="projects-title">
                <div class="flex flex-col gap-8 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="fc-kicker">{{ __('Sélection') }}</p>
                        <h2 id="projects-title" class="mt-5 font-display text-5xl font-bold leading-[0.9] sm:text-6xl">{{ __('Les projets') }}</h2>
                    </div>
                    <a href="{{ route('projects.index') }}" class="font-display font-semibold text-mist underline decoration-accent underline-offset-4 transition-colors hover:text-accent focus-visible:text-accent">
                        {{ __('Voir tous les projets') }} <span aria-hidden="true">↗</span>
                    </a>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    @foreach ($featuredProjects as $project)
                        <x-ui.portfolio-project-card :project="$project" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-layouts.site>
