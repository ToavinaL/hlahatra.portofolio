@php
    // Nom de route => libellé (clé de traduction). Le lien est actif sur toute la section
    // (« projects* » couvre aussi la future fiche projet).
    $items = [
        'home' => 'Accueil',
        'projects.index' => 'Projets',
        'about' => 'À propos',
        'experience' => 'Expérience',
        'skills' => 'Compétences',
        'education' => 'Formation',
        'resume' => 'CV',
        'contact' => 'Contact',
    ];

    $linkClasses = 'font-display text-lg font-semibold text-mist transition-colors duration-150 hover:text-bone aria-[current=page]:text-accent motion-reduce:transition-none';
@endphp

<header class="border-b border-surface">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="font-display text-2xl font-bold">{{ config('app.name') }}</a>

        <nav aria-label="{{ __('Navigation principale') }}" class="hidden lg:block">
            <ul class="flex items-center gap-6">
                @foreach ($items as $name => $label)
                    <li>
                        <a href="{{ route($name) }}" @if (request()->routeIs(\Illuminate\Support\Str::before($name, '.').'*')) aria-current="page" @endif class="{{ $linkClasses }}">{{ __($label) }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <x-site.language-switcher />
    </div>

    {{-- Menu mobile : <details> natif, sans JavaScript. --}}
    <details class="border-t border-surface lg:hidden">
        <summary class="cursor-pointer px-4 py-3 font-display text-lg font-semibold sm:px-6">{{ __('Menu') }}</summary>

        <nav aria-label="{{ __('Navigation principale') }}" class="px-4 pb-4 sm:px-6">
            <ul class="space-y-1">
                @foreach ($items as $name => $label)
                    <li>
                        <a href="{{ route($name) }}" @if (request()->routeIs(\Illuminate\Support\Str::before($name, '.').'*')) aria-current="page" @endif class="block py-2 {{ $linkClasses }}">{{ __($label) }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </details>
</header>
