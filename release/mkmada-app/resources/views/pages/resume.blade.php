@php
    $isEnglish = app()->getLocale() === 'en';

    $profile = $isEnglish
        ? 'PHP-focused web developer with hands-on experience designing, building and maintaining web applications. Comfortable with Symfony, Laravel and CodeIgniter, with additional experience in WordPress, PrestaShop, API integrations, administration areas and interface improvements. Independent, curious and problem-solving oriented, with a strong interest in AI-assisted development methods.'
        : 'Développeur web orienté PHP, avec une expérience pratique dans la conception, le développement et la maintenance d’applications web. Maîtrise de Symfony, Laravel et CodeIgniter, avec une expérience sur WordPress, PrestaShop, les intégrations d’API, les back-offices et l’amélioration des interfaces. Autonome, curieux et orienté résolution de problèmes, je m’intéresse aux nouvelles méthodes de développement assistées par l’intelligence artificielle.';

    $experiences = $isEnglish ? [
        [
            'role' => 'Freelance Developer',
            'company' => 'Independent',
            'period' => 'Current',
            'projects' => [
                ['name' => 'Mortal Kombat Madagascar', 'technology' => 'Laravel', 'url' => 'https://mortalkombatmadagascar.gamer.free/', 'summary' => 'Designed and built an e-sports community platform with a public interface, administration area, player and tournament management, competitive ranking and start.gg API integration.'],
                ['name' => 'Cleanlyst', 'technology' => 'CodeIgniter 4', 'url' => 'https://cleanlyst.42web.io/', 'summary' => 'Developed and improved a web services platform with an administration area, contact request management and user interface improvements.'],
                ['name' => 'Edentalflow', 'technology' => 'PHP 8', 'url' => 'https://www.edentalflow.com', 'summary' => 'Redesigned and improved a platform dedicated to dental professionals.'],
                ['name' => 'Réseau Soa', 'technology' => 'WordPress', 'url' => 'https://reseauoa.mg', 'summary' => 'Created and deployed a showcase website for the Union of Agricultural Organisations.'],
            ],
        ],
        [
            'role' => 'Full Stack Web Developer',
            'company' => 'A2Mi',
            'period' => '10/2022 — 10/2023',
            'projects' => [
                ['name' => 'Network infrastructure management and sales platform', 'technology' => 'CodeIgniter 4', 'summary' => 'Designed the database and built a secure administration area for resources, users and CRUD operations.'],
                ['name' => 'Online auction platform', 'technology' => 'Symfony 5', 'summary' => 'Built an e-commerce platform with Stripe payments, order management, backend automation and real-time auctions with Mercure.'],
                ['name' => 'Sound equipment and event rental', 'technology' => 'Symfony 3', 'summary' => 'Developed secure authentication and an administration area for customers, orders and statuses.'],
                ['name' => 'Real estate investment platform in Corsica', 'technology' => 'Laravel', 'summary' => 'Maintained the platform and improved the frontend to optimize the interface and browsing experience.'],
                ['name' => 'Solar film sales website in Paris', 'technology' => 'PrestaShop 8.0', 'summary' => 'Improved the frontend and developed a custom calculator for the client’s needs.'],
                ['name' => 'Bank card showcase website', 'technology' => 'WordPress', 'summary' => 'Redesigned the frontend from the client mockups and visual requirements.'],
                ['name' => 'Lead sales platform', 'technology' => 'CodeIgniter 3 → 4', 'summary' => 'Migrated the application, maintained it and fixed operational issues.'],
            ],
        ],
    ] : [
        [
            'role' => 'Développeur Freelance',
            'company' => 'Indépendant',
            'period' => 'Aujourd’hui',
            'projects' => [
                ['name' => 'Mortal Kombat Madagascar', 'technology' => 'Laravel', 'url' => 'https://mortalkombatmadagascar.gamer.free/', 'summary' => 'Conception et développement d’une plateforme communautaire e-sport avec interface publique, back-office, gestion des joueurs et tournois, classement compétitif et intégration de l’API start.gg.'],
                ['name' => 'Cleanlyst', 'technology' => 'CodeIgniter 4', 'url' => 'https://cleanlyst.42web.io/', 'summary' => 'Développement et amélioration d’une plateforme web de services, avec back-office, gestion des demandes de contact et optimisation de l’interface utilisateur.'],
                ['name' => 'Edentalflow', 'technology' => 'PHP 8', 'url' => 'https://www.edentalflow.com', 'summary' => 'Refonte et amélioration d’une plateforme destinée aux professionnels du secteur dentaire.'],
                ['name' => 'Réseau Soa', 'technology' => 'WordPress', 'url' => 'https://reseauoa.mg', 'summary' => 'Création et déploiement d’un site vitrine pour le Syndicat des Organisations Agricoles.'],
            ],
        ],
        [
            'role' => 'Développeur Web Fullstack',
            'company' => 'A2Mi',
            'period' => '10/2022 — 10/2023',
            'projects' => [
                ['name' => 'Plateforme de gestion et de vente d’infrastructures réseau', 'technology' => 'CodeIgniter 4', 'summary' => 'Conception de la base de données et développement d’un back-office sécurisé pour les ressources, utilisateurs et opérations CRUD.'],
                ['name' => 'Plateforme de vente aux enchères en ligne', 'technology' => 'Symfony 5', 'summary' => 'Développement d’une plateforme e-commerce avec paiements Stripe, gestion des commandes, automatisation backend et enchères en temps réel avec Mercure.'],
                ['name' => 'Location de matériels sonos et événementiel', 'technology' => 'Symfony 3', 'summary' => 'Développement d’un système d’authentification sécurisé et d’un back-office pour les clients, commandes et statuts.'],
                ['name' => 'Plateforme d’investissement immobilier en Corse', 'technology' => 'Laravel', 'summary' => 'Maintenance de la plateforme et amélioration du frontend pour optimiser l’interface et l’expérience de navigation.'],
                ['name' => 'Site de vente de films solaires à Paris', 'technology' => 'PrestaShop 8.0', 'summary' => 'Amélioration du frontend et développement d’une calculatrice personnalisée.'],
                ['name' => 'Site vitrine de cartes bancaires', 'technology' => 'WordPress', 'summary' => 'Refonte du frontend conformément aux maquettes et exigences graphiques du client.'],
                ['name' => 'Plateforme de vente de leads', 'technology' => 'CodeIgniter 3 → 4', 'summary' => 'Migration de l’application, maintenance et correction des dysfonctionnements.'],
            ],
        ],
    ];

    $skills = $isEnglish ? [
        ['label' => 'Languages', 'items' => 'PHP, JavaScript, C, C++'],
        ['label' => 'PHP frameworks', 'items' => 'Laravel, Symfony, CodeIgniter'],
        ['label' => 'CMS / E-commerce', 'items' => 'WordPress, PrestaShop'],
        ['label' => 'Databases', 'items' => 'MySQL'],
        ['label' => 'Tools', 'items' => 'Git, Linux'],
    ] : [
        ['label' => 'Langages', 'items' => 'PHP, JavaScript, C, C++'],
        ['label' => 'Frameworks PHP', 'items' => 'Laravel, Symfony, CodeIgniter'],
        ['label' => 'CMS / E-commerce', 'items' => 'WordPress, PrestaShop'],
        ['label' => 'Bases de données', 'items' => 'MySQL'],
        ['label' => 'Outils', 'items' => 'Git, Linux'],
    ];

    $languages = $isEnglish ? ['French — C2', 'English — B1', 'Malagasy — C2'] : ['Français — C2', 'Anglais — B1', 'Malagasy — C2'];
    $interests = $isEnglish ? ['Video games', 'Music', 'Cinema', 'Football', 'Basketball'] : ['Jeux vidéo', 'Musique', 'Cinéma', 'Football', 'Basketball'];
@endphp

<x-layouts.site :title="__('CV')">
    <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-10">
        <header class="fc-section-reveal fc-motion-rise max-w-4xl" data-reveal>
            <p class="fc-kicker">{{ __('Curriculum vitae') }}</p>
            <h1 class="mt-6 max-w-4xl font-display text-6xl font-bold leading-[0.82] tracking-tight sm:text-8xl">{{ __('Lahatra Fampiononana') }}<span class="text-accent">.</span></h1>
            <p class="mt-6 font-display text-2xl font-semibold text-accent sm:text-3xl">{{ __('Développeur Web Full Stack') }}</p>
            <p class="mt-8 max-w-2xl text-lg leading-relaxed text-mist sm:text-xl">{{ $profile }}</p>
            @if (\App\Models\Setting::get('resume.path'))
                <a href="{{ route('resume.download') }}" class="mt-8 inline-flex bg-accent px-6 py-3 font-display text-lg font-bold text-ink">{{ __('Télécharger le CV PDF') }}</a>
            @endif
        </header>

        <section class="fc-section-reveal fc-motion-slide mt-20 grid gap-4 border-y border-white/10 py-8 sm:grid-cols-3 sm:gap-8" data-reveal aria-label="{{ __('Coordonnées') }}">
            <a class="fc-resume-contact" href="mailto:hlahatrafampiononana@gmail.com">hlahatrafampiononana@gmail.com</a>
            <a class="fc-resume-contact" href="tel:+261324058428">+261 32 40 584 28</a>
            <span class="fc-resume-contact">Lot IPB 40, 102 Bemasoandro Itaosy</span>
        </section>

        <section class="fc-section-reveal fc-motion-rise mt-24" data-reveal aria-labelledby="resume-experience-title">
            <div class="flex flex-col gap-5 border-b border-white/10 pb-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="fc-kicker">01</p>
                    <h2 id="resume-experience-title" class="mt-4 font-display text-5xl font-bold leading-none sm:text-6xl">{{ __('Expérience professionnelle') }}</h2>
                </div>
                <span class="font-mono text-xs text-accent">{{ count($experiences) }} {{ __('étapes') }}</span>
            </div>
            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                @foreach ($experiences as $experience)
                    <article class="fc-resume-panel fc-panel cut [--cut:1rem] p-6 sm:p-8">
                        <header class="flex flex-col gap-4 border-b border-white/10 pb-6">
                            <div>
                                <p class="fc-kicker">{{ $experience['company'] }}</p>
                                <h3 class="mt-4 font-display text-3xl font-bold leading-none sm:text-4xl">{{ $experience['role'] }}</h3>
                            </div>
                            <p class="font-mono text-xs tracking-[0.16em] text-accent">{{ $experience['period'] }}</p>
                        </header>
                        <div class="mt-6 grid gap-5">
                            @foreach ($experience['projects'] as $project)
                                <div class="border-l border-accent/60 pl-4">
                                    <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                                        <h4 class="font-semibold text-bone">{{ $project['name'] }}</h4>
                                        <span class="font-mono text-xs text-accent">{{ $project['technology'] }}</span>
                                    </div>
                                    <p class="mt-2 text-sm leading-relaxed text-mist">{{ $project['summary'] }}</p>
                                    @if (isset($project['url']))
                                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-block text-xs text-accent underline underline-offset-4">{{ __('Voir le projet') }}</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <div class="mt-24 grid gap-16 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="fc-section-reveal fc-motion-scale" data-reveal aria-labelledby="resume-skills-title">
                <p class="fc-kicker">02</p>
                <h2 id="resume-skills-title" class="mt-4 font-display text-5xl font-bold leading-none sm:text-6xl">{{ __('Compétences') }}</h2>
                <div class="mt-8 grid gap-3">
                    @foreach ($skills as $skill)
                        <div class="fc-resume-line flex flex-col gap-2 border-b border-white/10 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <strong class="font-display text-xl">{{ $skill['label'] }}</strong>
                            <span class="text-sm text-mist sm:text-right">{{ $skill['items'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="fc-section-reveal fc-motion-slide" data-reveal aria-labelledby="resume-education-title">
                <p class="fc-kicker">03</p>
                <h2 id="resume-education-title" class="mt-4 font-display text-5xl font-bold leading-none sm:text-6xl">{{ __('Formations') }}</h2>
                <div class="mt-8 grid gap-4">
                    <article class="fc-panel cut [--cut:0.8rem] p-5">
                        <p class="font-mono text-xs text-accent">2021</p>
                        <h3 class="mt-6 font-display text-2xl font-bold">{{ __('Licence en Informatique et Programmation') }}</h3>
                    </article>
                    <article class="fc-panel cut [--cut:0.8rem] p-5">
                        <p class="font-mono text-xs text-accent">2024 — 2025</p>
                        <h3 class="mt-6 font-display text-2xl font-bold">{{ __('Étudiant de 42 Antananarivo') }}</h3>
                    </article>
                </div>
            </section>
        </div>

        <div class="mt-16 grid gap-16 border-t border-white/10 pt-16 md:grid-cols-2">
            <section class="fc-section-reveal fc-motion-rise" data-reveal aria-labelledby="resume-languages-title">
                <p class="fc-kicker">04</p>
                <h2 id="resume-languages-title" class="mt-4 font-display text-4xl font-bold">{{ __('Langues') }}</h2>
                <ul class="mt-6 grid gap-3 text-mist">
                    @foreach ($languages as $language)
                        <li class="flex items-center gap-3"><span class="size-2 bg-accent"></span>{{ $language }}</li>
                    @endforeach
                </ul>
            </section>
            <section class="fc-section-reveal fc-motion-scale" data-reveal aria-labelledby="resume-interests-title">
                <p class="fc-kicker">05</p>
                <h2 id="resume-interests-title" class="mt-4 font-display text-4xl font-bold">{{ __('Centres d’intérêt') }}</h2>
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($interests as $interest)
                        <x-ui.badge>{{ $interest }}</x-ui.badge>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-layouts.site>
