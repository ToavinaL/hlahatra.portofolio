{{--
    Tuile de projet façon sélection de personnage : coins coupés, et un cadre
    rouge qui s'affiche au survol et au focus clavier. Toute la carte est
    cliquable via le lien du titre.
--}}
@props(['title', 'summary', 'href', 'image' => null, 'alt' => '', 'technologies' => []])

<article {{ $attributes->class('group relative flex flex-col bg-surface cut [--cut:1.25rem]') }}>
    <div class="aspect-[16/10] overflow-hidden bg-ink">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $alt }}" loading="lazy" decoding="async" class="size-full object-cover">
        @else
            <div aria-hidden="true" class="size-full bg-[repeating-linear-gradient(135deg,transparent_0_10px,rgb(255_48_79/0.1)_10px_11px)]"></div>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-3 p-6">
        <h3 class="font-display text-2xl font-bold leading-tight">
            <a href="{{ $href }}" class="outline-none transition-colors duration-150 after:absolute after:inset-0 group-hover:text-accent focus-visible:underline focus-visible:underline-offset-4 motion-reduce:transition-none">{{ $title }}</a>
        </h3>

        <p class="leading-relaxed text-mist">{{ $summary }}</p>

        @if (count($technologies))
            <ul class="mt-auto flex flex-wrap gap-2 pt-2">
                @foreach ($technologies as $technology)
                    <li><x-ui.badge>{{ $technology }}</x-ui.badge></li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Cadre de sélection : inset-3 reste hors de la zone coupée par clip-path --}}
    <span aria-hidden="true" class="pointer-events-none absolute inset-3 border-2 border-accent opacity-0 transition-opacity duration-150 group-hover:opacity-100 group-has-[a:focus-visible]:opacity-100 motion-reduce:transition-none"></span>
</article>
