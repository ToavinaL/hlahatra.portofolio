<x-layouts.site>
    <section class="mx-auto grid max-w-6xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-[1.3fr_1fr] lg:items-center lg:gap-16 lg:px-8 lg:py-28">
        <div>
            <h1 class="font-display text-6xl font-bold leading-[0.95] sm:text-8xl">{{ config('app.name') }}</h1>

            <p class="mt-5 font-display text-3xl font-semibold text-accent sm:text-4xl">{{ __('Développeur Web Full Stack') }}</p>

            <p class="mt-6 max-w-prose text-lg leading-relaxed text-mist">
                {{ __('Je conçois et je maintiens des applications web : plateformes de gestion, e-commerce et projets communautaires.') }}
            </p>

            <div class="mt-10 flex flex-wrap gap-4">
                <x-ui.button :href="route('projects.index')">{{ __('Voir les projets') }}</x-ui.button>
                <x-ui.button :href="route('contact')" variant="ghost">{{ __('Me contacter') }}</x-ui.button>
            </div>

            <p class="mt-12 font-display text-xl font-semibold text-mist">BUILD. FIGHT. CREATE.</p>
        </div>

        {{-- Provisoire : sera alimenté par la base de données (technologies réelles des projets). --}}
        <aside class="cut bg-surface p-8 [--cut:1.25rem]">
            <h2 class="font-display text-2xl font-bold">{{ __('Technologies utilisées') }}</h2>

            <ul class="mt-6 flex flex-wrap gap-2">
                @foreach (['Laravel', 'Symfony', 'CodeIgniter 4', 'PHP 8', 'WordPress', 'Stripe', 'Mercure'] as $technology)
                    <li><x-ui.badge>{{ $technology }}</x-ui.badge></li>
                @endforeach
            </ul>
        </aside>
    </section>
</x-layouts.site>
