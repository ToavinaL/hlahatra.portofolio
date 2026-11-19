<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_administrator_with_a_hashed_password(): void
    {
        $this->artisan('portfolio:create-admin', ['email' => 'admin@example.com'])
            ->expectsQuestion('Nom', 'Toavina')
            ->expectsQuestion('Mot de passe (12 caractères minimum)', 'un-mot-de-passe-solide')
            ->assertSuccessful();

        $user = User::where('email', 'admin@example.com')->firstOrFail();

        $this->assertTrue($user->is_admin);
        $this->assertSame('Toavina', $user->name);
        $this->assertNotSame('un-mot-de-passe-solide', $user->password);
        $this->assertTrue(Hash::check('un-mot-de-passe-solide', $user->password));
    }

    public function test_it_asks_for_the_email_when_it_is_not_given(): void
    {
        $this->artisan('portfolio:create-admin')
            ->expectsQuestion('Adresse e-mail', 'admin@example.com')
            ->expectsQuestion('Nom', 'Toavina')
            ->expectsQuestion('Mot de passe (12 caractères minimum)', 'un-mot-de-passe-solide')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', ['email' => 'admin@example.com', 'is_admin' => true]);
    }

    public function test_it_refuses_a_password_that_is_too_short(): void
    {
        $this->artisan('portfolio:create-admin', ['email' => 'admin@example.com'])
            ->expectsQuestion('Nom', 'Toavina')
            ->expectsQuestion('Mot de passe (12 caractères minimum)', 'court')
            ->assertFailed();

        $this->assertDatabaseCount('users', 0);
    }

    public function test_it_refuses_an_invalid_email(): void
    {
        $this->artisan('portfolio:create-admin', ['email' => 'pas-un-email'])
            ->expectsQuestion('Nom', 'Toavina')
            ->expectsQuestion('Mot de passe (12 caractères minimum)', 'un-mot-de-passe-solide')
            ->assertFailed();

        $this->assertDatabaseCount('users', 0);
    }

    public function test_it_refuses_an_email_that_already_exists(): void
    {
        User::factory()->create(['email' => 'admin@example.com']);

        $this->artisan('portfolio:create-admin', ['email' => 'admin@example.com'])
            ->expectsQuestion('Nom', 'Toavina')
            ->expectsQuestion('Mot de passe (12 caractères minimum)', 'un-mot-de-passe-solide')
            ->assertFailed();

        $this->assertDatabaseCount('users', 1);
    }
}
