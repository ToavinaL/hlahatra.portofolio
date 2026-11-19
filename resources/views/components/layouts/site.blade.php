{{-- Layout des pages publiques : layout de base + en-tête et pied de page. --}}
@props(['title' => null])

<x-layouts.app :title="$title">
    <x-slot:header>
        <x-site.header />
    </x-slot:header>

    {{ $slot }}

    <x-slot:footer>
        <x-site.footer />
    </x-slot:footer>
</x-layouts.app>
