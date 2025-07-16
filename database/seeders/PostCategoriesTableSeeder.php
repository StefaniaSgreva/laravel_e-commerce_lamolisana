<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostCategory;
use Faker\Factory as Faker;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('it_IT');

        $categories = [
            [
                'nome' => 'Ricette Tradizionali',
                'descrizione' => 'Le migliori ricette della tradizione molisana con la nostra pasta'
            ],
            [
                'nome' => 'Tecniche di Cottura',
                'descrizione' => 'Tutti i segreti per una cottura perfetta della pasta'
            ],
            [
                'nome' => 'Eventi',
                'descrizione' => 'Le nostre partecipazioni a fiere ed eventi gastronomici'
            ],
            [
                'nome' => 'Novità Prodotti',
                'descrizione' => 'Scopri le nuove forme di pasta e le edizioni speciali'
            ],
            [
                'nome' => 'Storia della Pasta',
                'descrizione' => 'La tradizione centenaria de La Molisana'
            ]
        ];

        foreach ($categories as $category) {
            PostCategory::create([
                'nome' => $category['nome'],
                'descrizione' => $category['descrizione'],
                // Lo slug verrà generato automaticamente dal model
            ]);
        }

        // Se vuoi generare altre categorie casuali
        for ($i = 0; $i < 3; $i++) {
            PostCategory::create([
                'nome' => $faker->unique()->word,
                'descrizione' => $faker->sentence(10)
            ]);
        }
    }
}
