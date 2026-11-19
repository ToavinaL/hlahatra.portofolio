@php
    $route = request()->route();
    $name = $route?->getName();
    $localized = $route && str_starts_with($route->uri(), '{locale}');

    // Seulement les paramètres présents dans l'URL (ex. le futur {slug}). Route::view y ajoute
    // ses propres valeurs (view, data, status), qui finiraient sinon dans la query string.
    $parameters = $route ? array_intersect_key($route->parameters(), array_flip($route->parameterNames())) : [];
@endphp

{{-- Garde la page courante : /en/about renvoie vers /fr/about. --}}
@if ($name && $localized)
    <nav aria-label="{{ __('Langue') }}">
        <ul class="flex gap-1">
            @foreach (config('locales.supported') as $code)
                @php $active = app()->getLocale() === $code; @endphp
                <li>
                    <a
                        href="{{ route($name, ['locale' => $code] + $parameters) }}"
                        hreflang="{{ $code }}"
                        lang="{{ $code }}"
                        aria-label="{{ config('locales.labels.'.$code) }}"
                        @if ($active) aria-current="true" @endif
                        class="px-2 py-1 font-mono text-sm {{ $active ? 'text-accent' : 'text-mist hover:text-bone' }}"
                    >{{ strtoupper($code) }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
