<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect(config('locales.supported'))
            ->flatMap(fn (string $locale) => [
                route('home', ['locale' => $locale]),
                route('projects.index', ['locale' => $locale]),
                route('resume', ['locale' => $locale]),
                route('contact', ['locale' => $locale]),
            ])
            ->merge(Project::published()->pluck('slug')->flatMap(fn (string $slug) => collect(config('locales.supported'))->map(fn (string $locale) => route('projects.show', ['locale' => $locale, 'project' => $slug]))));

        return response(view('sitemap', ['urls' => $urls])->render(), 200, ['Content-Type' => 'application/xml']);
    }
}
