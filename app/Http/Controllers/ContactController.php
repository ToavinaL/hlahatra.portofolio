<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('pages.contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $contactMessage = Message::create([
            ...$request->safe()->only(['name', 'email', 'subject', 'message']),
            'locale' => app()->getLocale(),
        ]);

        $status = __('Votre message a bien été envoyé.');

        try {
            Mail::to(config('mail.to.address'))->send(new ContactMessageMail($contactMessage));
        } catch (Throwable $exception) {
            report($exception);
            $status = __('Votre message a été enregistré, mais l’envoi Gmail a échoué.');
        }

        return redirect()
            ->route('contact')
            ->with('status', $status);
    }
}
