<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $technologies = collect([
            'Laravel',
            'CodeIgniter 4',
            'PHP 8',
            'WordPress',
            'Symfony 5',
            'Symfony 3',
            'Stripe',
            'Mercure',
            'PrestaShop 8.0',
            'start.gg',
        ])->mapWithKeys(function (string $name, int $order): array {
            return [$name => Technology::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'sort_order' => $order],
            )];
        });

        $freelance = Experience::firstOrCreate(
            ['company' => 'Freelance', 'started_on' => null],
            ['ended_on' => null, 'is_current' => false],
        );
        $freelance->translations()->updateOrCreate(
            ['locale' => 'fr'],
            [
                'role' => 'Développeur Freelance',
                'missions' => implode("\n", [
                    'Mortal Kombat Madagascar — conception et développement d’une plateforme communautaire e-sport avec interface publique, back-office d’administration, gestion des joueurs et tournois, classement compétitif et intégration de l’API start.gg.',
                    'Cleanlyst — développement et amélioration d’une plateforme web de services, création d’un back-office d’administration, gestion des demandes de contact et optimisation de l’interface utilisateur.',
                    'Edentalflow — refonte et amélioration d’une plateforme destinée aux professionnels du secteur dentaire.',
                    'Réseau Soa — création et déploiement d’un site vitrine pour le Syndicat des Organisations Agricoles sous WordPress.',
                ]),
            ],
        );
        $freelance->translations()->updateOrCreate(
            ['locale' => 'en'],
            [
                'role' => 'Freelance Developer',
                'missions' => implode("\n", [
                    'Mortal Kombat Madagascar — design and development of an e-sports community platform with a public interface, administration area, player and tournament management, competitive ranking and start.gg API integration.',
                    'Cleanlyst — development and improvement of a web services platform, administration area, contact request management and user interface improvements.',
                    'Edentalflow — redesign and improvement of a platform for dental professionals.',
                    'Réseau Soa — creation and deployment of a showcase website for the Union of Agricultural Organisations using WordPress.',
                ]),
            ],
        );
        $freelance->technologies()->sync($technologies->only(['Laravel', 'CodeIgniter 4', 'PHP 8', 'WordPress'])->pluck('id'));

        $a2mi = Experience::firstOrCreate(
            ['company' => 'A2Mi', 'started_on' => '2022-10-01'],
            ['ended_on' => '2023-10-01', 'is_current' => false],
        );
        $a2mi->translations()->updateOrCreate(
            ['locale' => 'fr'],
            [
                'role' => 'Développeur Web Fullstack',
                'missions' => implode("\n", [
                    'Plateforme de gestion et de vente d’infrastructures réseau — conception de la base de données et développement d’un back-office sécurisé pour la gestion des ressources, des utilisateurs et des opérations CRUD (CodeIgniter 4).',
                    'Plateforme de vente aux enchères en ligne — développement d’une plateforme e-commerce intégrant les paiements Stripe, la gestion des commandes, l’automatisation backend et les enchères en temps réel avec Mercure (Symfony 5).',
                    'Location de matériels sonos et événementiel — développement d’un système d’authentification sécurisé et d’un back-office pour la gestion des clients, des commandes et de leurs statuts (Symfony 3).',
                    'Plateforme d’investissement immobilier en Corse — maintenance de la plateforme et amélioration du front-end pour optimiser l’interface utilisateur et l’expérience de navigation (Laravel).',
                    'Site de vente de films solaires à Paris — amélioration du front-end et développement d’une calculatrice personnalisée (PrestaShop 8.0).',
                    'Site vitrine de cartes bancaires — refonte du front-end conformément aux maquettes et aux exigences graphiques du client (WordPress).',
                    'Plateforme de vente de leads — migration de l’application de CodeIgniter 3 vers CodeIgniter 4, maintenance et correction des dysfonctionnements.',
                ]),
            ],
        );
        $a2mi->translations()->updateOrCreate(
            ['locale' => 'en'],
            [
                'role' => 'Full Stack Web Developer',
                'missions' => implode("\n", [
                    'Network infrastructure management and sales platform — database design and development of a secure administration area for managing resources, users and CRUD operations (CodeIgniter 4).',
                    'Online auction platform — development of an e-commerce platform with Stripe payments, order management, backend automation and real-time auctions with Mercure (Symfony 5).',
                    'Sound equipment and event rental — development of a secure authentication system and administration area for managing customers, orders and statuses (Symfony 3).',
                    'Real estate investment platform in Corsica — platform maintenance and front-end improvements to optimize the user interface and browsing experience (Laravel).',
                    'Solar film sales website in Paris — front-end improvements and development of a custom calculator (PrestaShop 8.0).',
                    'Bank card showcase website — front-end redesign based on the client mockups and visual requirements (WordPress).',
                    'Lead sales platform — migration from CodeIgniter 3 to CodeIgniter 4, maintenance and bug fixing.',
                ]),
            ],
        );
        $a2mi->technologies()->sync($technologies->only(['CodeIgniter 4', 'Symfony 5', 'Symfony 3', 'Laravel', 'PrestaShop 8.0', 'WordPress', 'Stripe', 'Mercure'])->pluck('id'));
    }
}
