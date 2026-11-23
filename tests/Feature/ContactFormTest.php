<?php

namespace Tests\Feature;

use App\Mail\ContactMessageMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Mail::fake();
    }

    public function test_contact_page_displays_the_form(): void
    {
        $this->get('/en/contact')
            ->assertOk()
            ->assertSee('name="name"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="subject"', false)
            ->assertSee('name="message"', false)
            ->assertSee('name="_token"', false);
    }

    public function test_valid_contact_message_is_stored_for_the_current_locale(): void
    {
        $payload = [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'subject' => 'Portfolio project',
            'message' => 'I would like to discuss a new web project.',
        ];

        $response = $this->post('/en/contact', $payload);

        $response->assertRedirect('/en/contact')->assertSessionHas('status');
        $this->assertDatabaseHas('messages', [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'subject' => 'Portfolio project',
            'locale' => 'en',
        ]);
        Mail::assertSent(ContactMessageMail::class);
    }

    public function test_invalid_contact_message_is_rejected_without_storage(): void
    {
        $response = $this->from('/fr/contact')->post('/fr/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => 'short',
        ]);

        $response->assertRedirect('/fr/contact')->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertDatabaseCount('messages', 0);
    }

    public function test_honeypot_contact_field_is_rejected(): void
    {
        $response = $this->from('/fr/contact')->post('/fr/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'subject' => 'Spam',
            'message' => 'This is an automated message.',
            'website' => 'https://spam.example.com',
        ]);

        $response->assertRedirect('/fr/contact')->assertSessionHasErrors('website');
        $this->assertDatabaseCount('messages', 0);
    }
}
