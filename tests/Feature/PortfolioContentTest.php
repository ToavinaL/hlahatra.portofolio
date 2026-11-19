<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Technology;
use Database\Seeders\SkillsSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioContentTest extends TestCase
{
    use RefreshDatabase;

    // Expériences

    public function test_experience_is_translated_with_fallback_to_french(): void
    {
        $experience = Experience::factory()->create();
        $experience->translations()->create(['locale' => 'fr', 'role' => 'Développeur Full Stack']);
        $experience = $experience->fresh();

        app()->setLocale('fr');
        $this->assertSame('Développeur Full Stack', $experience->role);

        app()->setLocale('en');
        $this->assertSame('Développeur Full Stack', $experience->role);

        $experience->translations()->create(['locale' => 'en', 'role' => 'Full Stack Developer']);
        $this->assertSame('Full Stack Developer', $experience->fresh()->role);
    }

    public function test_experiences_are_listed_from_most_recent_to_oldest(): void
    {
        Experience::factory()->create(['company' => 'Ancienne', 'started_on' => '2019-01-01']);
        Experience::factory()->create(['company' => 'Récente', 'started_on' => '2024-01-01']);
        Experience::factory()->create(['company' => 'Intermédiaire', 'started_on' => '2021-06-01']);

        $this->assertSame(
            ['Récente', 'Intermédiaire', 'Ancienne'],
            Experience::latestFirst()->pluck('company')->all()
        );
    }

    public function test_experience_is_linked_to_technologies(): void
    {
        $experience = Experience::factory()->create();
        $technology = Technology::factory()->create();

        $experience->technologies()->attach($technology);

        $this->assertTrue($experience->fresh()->technologies->contains($technology));
    }

    public function test_deleting_an_experience_removes_its_translations_and_links(): void
    {
        $experience = Experience::factory()->create();
        $experience->translations()->create(['locale' => 'fr', 'role' => 'Rôle']);
        $experience->technologies()->attach(Technology::factory()->create());

        $experience->delete();

        $this->assertDatabaseCount('experience_translations', 0);
        $this->assertDatabaseCount('experience_technology', 0);
        $this->assertDatabaseCount('technologies', 1);
    }

    // Formations

    public function test_education_uses_the_table_planned_in_the_specification(): void
    {
        $this->assertSame('educations', (new Education)->getTable());
    }

    public function test_education_is_translated_with_fallback_to_french(): void
    {
        $education = Education::factory()->create();
        $education->translations()->create(['locale' => 'fr', 'title' => 'Licence en informatique']);
        $education = $education->fresh();

        app()->setLocale('en');
        $this->assertSame('Licence en informatique', $education->title);

        $education->translations()->create(['locale' => 'en', 'title' => "Bachelor's degree in computer science"]);
        $this->assertSame("Bachelor's degree in computer science", $education->fresh()->title);
    }

    public function test_deleting_an_education_removes_its_translations(): void
    {
        $education = Education::factory()->create();
        $education->translations()->create(['locale' => 'fr', 'title' => 'Titre']);

        $education->delete();

        $this->assertDatabaseCount('education_translations', 0);
    }

    // Compétences

    public function test_skill_category_has_a_translated_name_and_ordered_skills(): void
    {
        $category = SkillCategory::factory()->create();
        $category->translations()->create(['locale' => 'fr', 'name' => 'Frameworks']);
        $category->translations()->create(['locale' => 'en', 'name' => 'Frameworks (EN)']);
        Skill::factory()->create(['skill_category_id' => $category->id, 'name' => 'Second', 'sort_order' => 2]);
        Skill::factory()->create(['skill_category_id' => $category->id, 'name' => 'Premier', 'sort_order' => 1]);

        app()->setLocale('en');

        $this->assertSame('Frameworks (EN)', $category->fresh()->name);
        $this->assertSame(['Premier', 'Second'], $category->skills->pluck('name')->all());
    }

    public function test_skill_level_is_empty_until_it_is_filled_in(): void
    {
        $skill = Skill::factory()->create()->fresh();

        $this->assertNull($skill->level);

        $skill->update(['level' => 4]);

        $this->assertSame(4, $skill->fresh()->level);
    }

    public function test_a_skill_category_with_skills_cannot_be_deleted(): void
    {
        $skill = Skill::factory()->create();

        $this->expectException(QueryException::class);

        $skill->category->delete();
    }

    public function test_skills_seeder_creates_categories_without_inventing_levels(): void
    {
        $this->seed(SkillsSeeder::class);

        $this->assertSame(6, SkillCategory::count());
        $this->assertTrue(Skill::count() > 0);
        $this->assertSame(0, Skill::whereNotNull('level')->count());

        foreach (SkillCategory::with('translations')->get() as $category) {
            $this->assertTrue($category->hasTranslation('fr'));
            $this->assertTrue($category->hasTranslation('en'));
        }
    }

    public function test_skills_seeder_can_run_twice_without_duplicates(): void
    {
        $this->seed(SkillsSeeder::class);
        $skills = Skill::count();

        $this->seed(SkillsSeeder::class);

        $this->assertSame(6, SkillCategory::count());
        $this->assertSame($skills, Skill::count());
    }

    // Messages de contact

    public function test_a_new_message_is_unread_and_not_archived(): void
    {
        $message = Message::factory()->create()->fresh();

        $this->assertFalse($message->isRead());
        $this->assertFalse($message->isArchived());
        $this->assertCount(1, Message::unread()->get());
    }

    public function test_message_can_be_marked_as_read_and_unread(): void
    {
        $message = Message::factory()->create();

        $message->markAsRead();
        $this->assertTrue($message->fresh()->isRead());
        $this->assertCount(0, Message::unread()->get());

        $message->markAsUnread();
        $this->assertFalse($message->fresh()->isRead());
        $this->assertCount(1, Message::unread()->get());
    }

    public function test_marking_a_message_as_read_twice_keeps_the_first_date(): void
    {
        $message = Message::factory()->create();

        $this->travelTo(now()->subDay());
        $message->markAsRead();
        $firstReadAt = $message->fresh()->read_at;

        $this->travelBack();
        $message->fresh()->markAsRead();

        $this->assertTrue($firstReadAt->equalTo($message->fresh()->read_at));
    }

    public function test_archived_messages_leave_the_inbox_and_can_be_restored(): void
    {
        $message = Message::factory()->create();
        Message::factory()->create();

        $message->archive();

        $this->assertCount(1, Message::inbox()->get());
        $this->assertCount(1, Message::archived()->get());
        $this->assertCount(1, Message::unread()->get());

        $message->fresh()->unarchive();

        $this->assertCount(2, Message::inbox()->get());
        $this->assertCount(0, Message::archived()->get());
    }

    public function test_read_and_archive_dates_cannot_be_set_by_mass_assignment(): void
    {
        $message = Message::create([
            'name' => 'Visiteur',
            'email' => 'visiteur@example.com',
            'subject' => 'Bonjour',
            'message' => 'Un message.',
            'read_at' => now(),
            'archived_at' => now(),
        ])->fresh();

        $this->assertFalse($message->isRead());
        $this->assertFalse($message->isArchived());
    }

    // Paramètres

    public function test_setting_returns_the_default_when_missing(): void
    {
        $this->assertNull(Setting::get('contact.email'));
        $this->assertSame('x', Setting::get('contact.email', 'x'));
    }

    public function test_setting_can_be_stored_and_updated_without_duplicates(): void
    {
        Setting::set('contact.email', 'a@example.com');
        Setting::set('contact.email', 'b@example.com');

        $this->assertSame('b@example.com', Setting::get('contact.email'));
        $this->assertDatabaseCount('settings', 1);
    }

    public function test_localized_setting_follows_the_language_with_fallback(): void
    {
        Setting::set('seo.description', ['fr' => 'Description FR', 'en' => 'Description EN']);
        Setting::set('seo.title', ['fr' => 'Titre FR']);

        app()->setLocale('en');
        $this->assertSame('Description EN', Setting::localized('seo.description'));
        $this->assertSame('Titre FR', Setting::localized('seo.title'));

        app()->setLocale('fr');
        $this->assertSame('Description FR', Setting::localized('seo.description'));
    }

    public function test_localized_setting_returns_plain_values_unchanged(): void
    {
        Setting::set('site.name', 'Portfolio');

        $this->assertSame('Portfolio', Setting::localized('site.name'));
        $this->assertSame('défaut', Setting::localized('absent', default: 'défaut'));
    }
}
