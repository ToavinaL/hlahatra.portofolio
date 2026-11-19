<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_the_login_page_is_available(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_there_is_no_public_registration(): void
    {
        $this->get('/admin/register')->assertNotFound();
    }

    public function test_new_accounts_are_not_administrators(): void
    {
        $this->assertFalse(User::factory()->create()->fresh()->is_admin);
    }

    public function test_a_user_who_is_not_an_administrator_cannot_open_the_admin(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_an_administrator_can_open_the_admin(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertOk();
    }

    public function test_admin_pages_are_not_indexable(): void
    {
        $this->get('/admin/login')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
