<x-layouts.site :title="__('Contact')">
    <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-10">
        <header class="fc-section-reveal fc-motion-rise max-w-3xl" data-reveal>
            <p class="fc-kicker">{{ __('Échangeons') }}</p>
            <h1 class="mt-6 font-display text-6xl font-bold leading-[0.82] tracking-tight sm:text-8xl">{{ __('Contact') }}<span class="text-accent">.</span></h1>
            <p class="mt-8 max-w-2xl text-lg leading-relaxed text-mist sm:text-xl">{{ __('Une idée, un projet ou une question ? Décris-moi ton besoin et je te répondrai dès que possible.') }}</p>
        </header>

        @if (session('status'))
            <div class="fc-section-reveal fc-motion-slide mt-12 border border-accent/60 bg-accent/10 p-5 text-bone" data-reveal role="status">
                <p class="font-display text-xl font-semibold">{{ session('status') }}</p>
                <p class="mt-1 text-sm text-mist">{{ __('Le message est enregistré dans mon espace de gestion.') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="fc-section-reveal mt-12 border border-red-400/60 bg-red-950/30 p-5 text-red-100" data-reveal role="alert">
                <p class="font-display text-xl font-semibold">{{ __('Vérifie les champs signalés.') }}</p>
                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-16 grid gap-12 lg:grid-cols-[0.7fr_1.3fr] lg:gap-24">
            <aside class="fc-section-reveal fc-motion-scale" data-reveal>
                <p class="fc-kicker">{{ __('Coordonnées') }}</p>
                <h2 class="mt-5 max-w-sm font-display text-4xl font-bold leading-none sm:text-5xl">{{ __('Parlons du prochain projet.') }}</h2>
                <div class="mt-10 grid gap-5 text-sm text-mist">
                    <a class="transition-colors hover:text-accent" href="mailto:hlahatrafampiononana@gmail.com">hlahatrafampiononana@gmail.com</a>
                    <a class="transition-colors hover:text-accent" href="tel:+261324058428">+261 32 40 584 28</a>
                    <span>Lot IPB 40, 102 Bemasoandro Itaosy</span>
                </div>
            </aside>

            <form class="fc-section-reveal fc-motion-slide fc-panel cut [--cut:1rem] grid gap-6 p-6 sm:p-8" data-reveal method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div class="hidden" aria-hidden="true">
                    <label for="website">{{ __('Site web') }}</label>
                    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="fc-form-label" for="name">{{ __('Nom') }}</label>
                        <input class="fc-form-input" id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required>
                        @error('name')<p class="fc-form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="fc-form-label" for="email">{{ __('E-mail') }}</label>
                        <input class="fc-form-input" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                        @error('email')<p class="fc-form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="fc-form-label" for="subject">{{ __('Sujet') }}</label>
                    <input class="fc-form-input" id="subject" name="subject" type="text" value="{{ old('subject') }}" required>
                    @error('subject')<p class="fc-form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="fc-form-label" for="message">{{ __('Message') }}</label>
                    <textarea class="fc-form-input min-h-44 resize-y" id="message" name="message" rows="7" required>{{ old('message') }}</textarea>
                    @error('message')<p class="fc-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-4 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="max-w-sm text-xs leading-relaxed text-mist/60">{{ __('Les messages sont enregistrés de manière sécurisée et consultables depuis l’administration.') }}</p>
                    <x-ui.button>{{ __('Envoyer le message') }}</x-ui.button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.site>
