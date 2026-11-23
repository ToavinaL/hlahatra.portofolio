<?php

use App\Http\Controllers\ContactController;
use App\Http\Middleware\SetLocale;
use App\Models\Experience;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/'.config('locales.default'));

if (app()->isLocal()) {
    Route::view('/design-system', 'design-system');
}

Route::redirect('/{locale}/admin', '/admin')
    ->where(['locale' => implode('|', config('locales.supported'))]);

Route::redirect('/{locale}/admin/{path}', '/admin/{path}')
    ->where([
        'locale' => implode('|', config('locales.supported')),
        'path' => '.*',
    ]);

/*
|--------------------------------------------------------------------------
| Site public, localisé : /fr/... et /en/...
|--------------------------------------------------------------------------
|
| Le middleware SetLocale fixe la langue et la valeur par défaut du
| paramètre {locale}, ce qui permet d'écrire les routes sans le passer.
| Les pages « stub » seront remplacées une à une par les vraies pages.
|
*/
Route::prefix('{locale}')
    ->where(['locale' => implode('|', config('locales.supported'))])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', function () {
            return view('pages.home', [
                'experiences' => Experience::query()
                    ->with(['translations', 'technologies'])
                    ->latestFirst()
                    ->get(),
                'featuredProjects' => Project::query()
                    ->with(['translations', 'technologies', 'images', 'category.translations'])
                    ->published()
                    ->featured()
                    ->ordered()
                    ->get(),
            ]);
        })->name('home');

        Route::get('/projects', function () {
            return view('pages.projects', [
                'projects' => Project::query()
                    ->with(['translations', 'technologies', 'images', 'category.translations'])
                    ->published()
                    ->ordered()
                    ->get(),
            ]);
        })->name('projects.index');
        Route::view('/resume', 'pages.resume')->name('resume');
        Route::get('/contact', [ContactController::class, 'create'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('contact.store');
    });
