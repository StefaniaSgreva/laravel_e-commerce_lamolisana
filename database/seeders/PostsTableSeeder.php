<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostCategory;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('it_IT');

        // Assicurati che esistano categorie
        if (PostCategory::count() == 0) {
            $this->call(PostCategoriesTableSeeder::class);
        }

        $formatiPasta = [
            'bucatini',
            'calamarata',
            'caserecce',
            'chitarra',
            'conchiglie',
            'farfalle',
            'fusilli',
            'gnocchetti',
            'linguine',
            'maccheroni',
            'orecchiette',
            'paccheri',
            'pappardelle',
            'penne',
            'pici',
            'rigatoni',
            'spaghetto-quadrato',
            'strozzapreti',
            'tagliatelle',
            'trofie'
        ];

        for ($i = 0; $i < 20; $i++) {
            $formato = $faker->randomElement($formatiPasta);
            $titolo = $this->generaTitolo($faker, $formato);
            $dataPubblicazione = $faker->dateTimeThisYear()->format('Y-m-d H:i:s');

            Post::create([
                'titolo' => $titolo,
                'contenuto' => $this->generaContenutoRicetta($faker, $formato),
                'estratto' => $this->generaEstratto($faker, $formato),
                'immagine_copertina' => $formato . '.webp',
                'immagine_social' => 'social-share.webp',
                'meta_title' => $titolo . ' | Pasta La Molisana',
                'meta_description' => 'Scopri la ricetta con ' . $formato . ' de La Molisana: ' . $faker->sentence(8),
                'pubblicato' => true,
                'in_evidenza' => $i < 3,
                'data_pubblicazione' => $faker->dateTimeBetween('-1 year', 'now'),
                'data_scadenza' => $i < 3 ? date('Y-m-d H:i:s', strtotime($dataPubblicazione . ' +1 month')) : null,
                'categoria_id' => PostCategory::inRandomOrder()->first()->id,
                'visualizzazioni' => $faker->numberBetween(100, 5000),
                'tempo_lettura' => $faker->numberBetween(3, 8),
            ]);
        }
    }

    private function generaTitolo($faker, $formato): string
    {
        $temi = [
            "Ricetta tradizionale con {$formato}",
            "Come cucinare i {$formato} perfetti",
            "{$formato} de La Molisana: la ricetta segreta",
            "La migliore ricetta con {$formato}",
            "{$formato} in salsa tipica molisana"
        ];

        return $faker->randomElement($temi);
    }

    private function generaEstratto($faker, $formato): string
    {
        return "Scopri come preparare un piatto perfetto con i {$formato} de La Molisana. " .
            $faker->sentence(10);
    }

    private function generaContenutoRicetta($faker, $formato): string
    {
        $ingredienti = [
            'pomodoro',
            'basilico',
            'aglio',
            'olio d\'oliva',
            'peperoncino',
            'pecorino',
            'parmigiano',
            'guanciale',
            'uova',
            'panna',
            'funghi',
            'salsiccia',
            'broccoli',
            'acciughe',
            'capperi'
        ];

        $contenuto = '<h2>Ricetta con ' . ucfirst($formato) . ' La Molisana</h2>';
        $contenuto .= '<p>' . $faker->paragraph(6) . '</p>';

        $contenuto .= '<h3>Ingredienti:</h3><ul>';
        for ($i = 0; $i < $faker->numberBetween(4, 8); $i++) {
            $qta = $faker->randomElement(['300g', '2 cucchiai', '1 spicchio', 'q.b.', '50g']);
            $contenuto .= '<li>' . $qta . ' di ' . $faker->randomElement($ingredienti) . '</li>';
        }
        $contenuto .= '<li>1 confezione di ' . $formato . ' La Molisana</li></ul>';

        $contenuto .= '<h3>Preparazione:</h3><ol>';
        $passi = [
            "Portare a bollore l'acqua",
            "Scolare la pasta al dente",
            "Saltare in padella",
            "Aggiungere il condimento",
            "Servire ben caldo"
        ];

        foreach ($passi as $passo) {
            $contenuto .= '<li>' . $passo . '. ' . $faker->sentence(10) . '</li>';
        }
        $contenuto .= '</ol>';

        $contenuto .= '<h3>Consiglio dello Chef:</h3>';
        $contenuto .= '<p>' . $faker->paragraph(3) . '</p>';

        return $contenuto;
    }
}
