<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

/**
 * Catégories de compétences du cahier des charges (section 3.4) et compétences
 * qui ressortent des projets listés (section 4).
 *
 * Aucun niveau n'est renseigné : à saisir dans l'administration.
 * Rejouable sans risque : ce qui existe déjà n'est jamais écrasé.
 */
class SkillsSeeder extends Seeder
{
    public function run(): void
    {
        $definitions = [
            'languages' => ['Langages', 'Languages', ['PHP']],
            'frameworks' => ['Frameworks', 'Frameworks', ['Laravel', 'CodeIgniter', 'Symfony']],
            'frontend' => ['Frontend', 'Frontend', []],
            'databases' => ['Bases de données', 'Databases', []],
            'cms-ecommerce' => ['CMS et e-commerce', 'CMS and e-commerce', ['WordPress']],
            'tools' => ['Outils', 'Tools', []],
        ];

        $order = 0;

        foreach ($definitions as $slug => [$fr, $en, $skills]) {
            $category = SkillCategory::firstOrCreate(['slug' => $slug], ['sort_order' => $order++]);

            $category->translations()->firstOrCreate(['locale' => 'fr'], ['name' => $fr]);
            $category->translations()->firstOrCreate(['locale' => 'en'], ['name' => $en]);

            foreach ($skills as $position => $name) {
                Skill::firstOrCreate(
                    ['skill_category_id' => $category->id, 'name' => $name],
                    ['sort_order' => $position],
                );
            }
        }
    }
}
