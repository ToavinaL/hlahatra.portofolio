@php
    // Nom de route => libellé (clé de traduction). Le lien est actif sur toute la section
    // (« projects* » couvre aussi la future fiche projet).
    $items = [
        'home' => 'Accueil',
        'projects.index' => 'Projets',
        'resume' => 'CV',
        'contact' => 'Contact',
    ];

    $linkClasses = 'font-display text-lg font-semibold text-mist transition-colors duration-150 hover:text-bone aria-[current=page]:text-accent motion-reduce:transition-none';
@endphp

<header class="sticky top-0 z-40 border-b border-white/10 bg-ink/80 backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-10">
        <a href="{{ route('home') }}" class="group flex items-center gap-3 font-display text-2xl font-bold tracking-tight" aria-label="{{ config('app.name') }} — {{ __('Accueil') }}">
            <span class="grid size-8 place-items-center bg-accent text-sm text-ink transition-transform duration-300 group-hover:rotate-12">FC</span>
            <span>{{ config('app.name') }}</span>
        </a>

        <nav aria-label="{{ __('Navigation principale') }}" class="hidden lg:block">
            <ul class="flex items-center gap-1 rounded-full border border-white/10 bg-surface/40 p-1">
                @foreach ($items as $name => $label)
                    <li>
                        <a href="{{ route($name) }}" @if (request()->routeIs(\Illuminate\Support\Str::before($name, '.').'*')) aria-current="page" @endif class="rounded-full px-3 py-2 {{ $linkClasses }}">{{ __($label) }}</a>
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
