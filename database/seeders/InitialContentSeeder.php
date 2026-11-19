<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Contenu initial tiré du cahier des charges (section 4).
 *
 * - Tous les projets sont créés en brouillon : les droits de publication et le statut réel
 *   (terminé ou en cours) restent à vérifier avant de publier.
 * - Aucune contribution, date, lien ni nature de participation n'est inventé : à compléter dans l'administration.
 * - Rejouable sans risque : ce qui existe déjà n'est jamais écrasé.
 */
class InitialContentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = $this->seedCategories();
        $technologies = $this->seedTechnologies();

        foreach ($this->projects() as $order => $data) {
            $project = Project::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id' => $categories[$data['category']]->id,
                    'status' => ProjectStatus::Draft,
                    'sort_order' => $order,
                ],
            );

            foreach (['fr', 'en'] as $locale) {
                $project->translations()->firstOrCreate(
                    ['locale' => $locale],
                    ['title' => $data[$locale]['title'], 'summary' => $data[$locale]['summary']],
                );
            }

            if ($project->wasRecentlyCreated) {
                $project->technologies()->sync(
                    collect($data['technologies'])->map(fn (string $name) => $technologies[$name]->id)
                );
            }
        }
    }

    /** @return array<string, Category> */
    private function seedCategories(): array
    {
        $definitions = [
            'web-applications' => ['Applications web', 'Web applications'],
            'e-commerce' => ['E-commerce', 'E-commerce'],
            'management-platforms' => ['Plateformes de gestion', 'Management platforms'],
            'community-projects' => ['Projets communautaires', 'Community projects'],
            'showcase-websites' => ['Sites vitrines', 'Showcase websites'],
            'maintenance' => ['Maintenance', 'Maintenance'],
        ];

        $categories = [];
        $order = 0;

        foreach ($definitions as $slug => [$fr, $en]) {
            $category = Category::firstOrCreate(['slug' => $slug], ['sort_order' => $order++]);

            $category->translations()->firstOrCreate(['locale' => 'fr'], ['name' => $fr]);
            $category->translations()->firstOrCreate(['locale' => 'en'], ['name' => $en]);

            $categories[$slug] = $category;
        }

        return $categories;
    }

    /** @return array<string, Technology> */
    private function seedTechnologies(): array
    {
        $technologies = [];

        foreach (['Laravel', 'CodeIgniter 4', 'PHP 8', 'WordPress', 'Symfony 5', 'Symfony 3', 'Stripe', 'Mercure', 'start.gg'] as $order => $name) {
            $technologies[$name] = Technology::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'sort_order' => $order],
            );
        }

        return $technologies;
    }

    private function projects(): array
    {
        return [
            [
                'slug' => 'mortal-kombat-madagascar',
                'category' => 'community-projects',
                'technologies' => ['Laravel', 'start.gg'],
                'fr' => ['title' => 'Mortal Kombat Madagascar', 'summary' => 'Plateforme communautaire e-sport : joueurs, tournois, classement et API start.gg.'],
                'en' => ['title' => 'Mortal Kombat Madagascar', 'summary' => 'E-sports community platform: players, tournaments, rankings and the start.gg API.'],
            ],
            [
                'slug' => 'cleanlyst',
                'category' => 'management-platforms',
                'technologies' => ['CodeIgniter 4'],
                'fr' => ['title' => 'Cleanlyst', 'summary' => 'Plateforme de services avec administration et gestion des demandes.'],
                'en' => ['title' => 'Cleanlyst', 'summary' => 'Services platform with an administration area and request management.'],
            ],
            [
                'slug' => 'edentalflow',
                'category' => 'web-applications',
                'technologies' => ['PHP 8'],
                'fr' => ['title' => 'Edentalflow', 'summary' => "Refonte d'une plateforme dédiée aux professionnels du secteur dentaire."],
                'en' => ['title' => 'Edentalflow', 'summary' => 'Redesign of a platform dedicated to dental professionals.'],
            ],
            [
                'slug' => 'reseau-soa',
                'category' => 'showcase-websites',
                'technologies' => ['WordPress'],
                'fr' => ['title' => 'Réseau Soa', 'summary' => "Site vitrine pour un syndicat d'organisations agricoles."],
                'en' => ['title' => 'Réseau Soa', 'summary' => 'Showcase website for a union of agricultural organisations.'],
            ],
            [
                'slug' => 'vente-infrastructures-reseau',
                'category' => 'management-platforms',
                'technologies' => ['CodeIgniter 4'],
                'fr' => ['title' => "Vente d'infrastructures réseau", 'summary' => 'Gestion des ressources, utilisateurs et opérations.'],
                'en' => ['title' => 'Network infrastructure sales', 'summary' => 'Management of resources, users and operations.'],
            ],
            [
                'slug' => 'plateforme-encheres',
                'category' => 'e-commerce',
                'technologies' => ['Symfony 5', 'Stripe', 'Mercure'],
                'fr' => ['title' => "Plateforme d'enchères", 'summary' => 'E-commerce, Stripe et enchères en temps réel avec Mercure.'],
                'en' => ['title' => 'Auction platform', 'summary' => 'E-commerce, Stripe and real-time auctions with Mercure.'],
            ],
            [
                'slug' => 'location-materiel-evenementiel',
                'category' => 'web-applications',
                'technologies' => ['Symfony 3'],
                'fr' => ['title' => 'Location de matériel événementiel', 'summary' => 'Authentification et gestion des clients et commandes.'],
                'en' => ['title' => 'Event equipment rental', 'summary' => 'Authentication and management of customers and orders.'],
            ],
            [
                'slug' => 'investissement-immobilier-corse',
                'category' => 'maintenance',
                'technologies' => ['Laravel'],
                'fr' => ['title' => 'Investissement immobilier en Corse', 'summary' => 'Maintenance et amélioration du frontend.'],
                'en' => ['title' => 'Real estate investment in Corsica', 'summary' => 'Maintenance and improvement of the frontend.'],
            ],
        ];
    }
}
