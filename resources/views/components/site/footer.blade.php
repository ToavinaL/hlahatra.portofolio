<footer class="relative z-10 mt-28 border-t border-white/10">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-10 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-10">
        <div>
            <p class="fc-kicker">{{ __('Portfolio personnel') }}</p>
            <p class="mt-3 font-display text-2xl font-bold">BUILD. FIGHT. CREATE.</p>
        </div>
        <p class="font-mono text-xs text-mist/70">&copy; {{ now()->year }} {{ config('app.name') }}</p>
    </div>
</footer>
