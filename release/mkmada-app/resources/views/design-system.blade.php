{{-- Page de référence du design system. Visible uniquement en environnement local. --}}
<x-layouts.app title="Design system">
    <div class="mx-auto max-w-6xl space-y-24 px-4 py-16 sm:px-6 lg:px-8">

        <header>
            <p class="font-display text-6xl font-bold leading-[0.9] sm:text-8xl">
                BUILD.<br>FIGHT.<br>CREATE.
            </p>
            <p class="mt-8 max-w-prose text-lg leading-relaxed text-mist">
                Page de référence du design system. Les valeurs de niveau ci-dessous sont des exemples
                d'affichage, pas des informations sur mes compétences.
            </p>
        </header>

        <section aria-labelledby="couleurs" class="space-y-8">
            <x-ui.section-heading title="Couleurs" level="2" id="couleurs">
                Le rouge est la seule couleur d'accent.
            </x-ui.section-heading>

            <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach ([
                    ['Noir profond', '#111014', 'bg-ink'],
                    ['Noir secondaire', '#29262C', 'bg-surface'],
                    ['Rouge', '#FF304F', 'bg-accent'],
                    ['Blanc cassé', '#F4EDF2', 'bg-bone'],
                    ['Gris clair', '#D8D3D7', 'bg-mist'],
                ] as [$name, $hex, $class])
                    <li class="cut [--cut:1rem] bg-surface">
                        <div class="h-20 {{ $class }} outline outline-1 -outline-offset-1 outline-bone/20"></div>
                        <p class="px-4 pt-3 font-display text-lg font-semibold">{{ $name }}</p>
                        <p class="px-4 pb-4 font-mono text-sm text-mist">{{ $hex }}</p>
                    </li>
                @endforeach
            </ul>
        </section>

        <section aria-labelledby="typographie" class="space-y-8">
            <x-ui.section-heading title="Typographie" level="2" id="typographie" />

            <div class="space-y-6">
                <p class="font-display text-5xl font-bold">Rajdhani pour les titres</p>
                <p class="max-w-prose text-lg leading-relaxed">
                    Inter pour les textes courants : une longueur de ligne inférieure à 80 caractères
                    garde les paragraphes confortables à lire, sur mobile comme sur ordinateur.
                </p>
                <p class="font-mono text-sm text-mist">php artisan test --compact</p>
            </div>
        </section>

        <section aria-labelledby="boutons" class="space-y-8">
            <x-ui.section-heading title="Boutons et badges" level="2" id="boutons" />

            <div class="flex flex-wrap items-center gap-4">
                <x-ui.button href="#">Voir les projets</x-ui.button>
                <x-ui.button href="#" variant="ghost">Me contacter</x-ui.button>
                <x-ui.button>Envoyer le message</x-ui.button>
            </div>

            <div class="flex flex-wrap gap-2">
                <x-ui.badge>Laravel</x-ui.badge>
                <x-ui.badge>Livewire</x-ui.badge>
                <x-ui.badge>CodeIgniter 4</x-ui.badge>
                <x-ui.badge tone="accent">Symfony 5</x-ui.badge>
            </div>
        </section>

        <section aria-labelledby="competences" class="space-y-8">
            <x-ui.section-heading title="Indicateurs de niveau" level="2" id="competences" />

            <div class="max-w-md space-y-4">
                <x-ui.meter label="Exemple A" :value="4" />
                <x-ui.meter label="Exemple B" :value="3" />
                <x-ui.meter label="Exemple C" :value="2" />
            </div>
        </section>

        <section aria-labelledby="cartes" class="space-y-8">
            <x-ui.section-heading title="Cartes de projet" level="2" id="cartes">
                Survole une carte ou navigue au clavier pour voir le cadre de sélection.
            </x-ui.section-heading>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <x-ui.project-card
                    title="Mortal Kombat Madagascar"
                    summary="Plateforme communautaire e-sport : joueurs, tournois, classement et API start.gg."
                    href="#"
                    :technologies="['Laravel', 'Livewire']"
                />
                <x-ui.project-card
                    title="Cleanlyst"
                    summary="Plateforme de services avec administration et gestion des demandes."
                    href="#"
                    :technologies="['CodeIgniter 4']"
                />
                <x-ui.project-card
                    title="Edentalflow"
                    summary="Refonte d'une plateforme dédiée aux professionnels du secteur dentaire."
                    href="#"
                    :technologies="['PHP 8']"
                />
            </div>
        </section>

    </div>
</x-layouts.app>
