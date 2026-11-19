<?php

use App\Http\Middleware\SetLocale;
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
| paramètre {locale}, ce qui permet d'écrire route('about') sans le passer.
| Les pages « stub » seront remplacées une à une par les vraies pages.
|
*/
Route::prefix('{locale}')
    ->where(['locale' => implode('|', config('locales.supported'))])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::view('/', 'pages.home')->name('home');

        Route::view('/projects', 'pages.stub', ['title' => 'Projets'])->name('projects.index');
        Route::view('/about', 'pages.stub', ['title' => 'À propos'])->name('about');
        Route::view('/experience', 'pages.stub', ['title' => 'Expérience'])->name('experience');
        Route::view('/skills', 'pages.stub', ['title' => 'Compétences'])->name('skills');
        Route::view('/education', 'pages.stub', ['title' => 'Formation'])->name('education');
        Route::view('/resume', 'pages.stub', ['title' => 'CV'])->name('resume');
        Route::view('/contact', 'pages.stub', ['title' => 'Contact'])->name('contact');
    });
