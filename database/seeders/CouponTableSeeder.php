<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponTableSeeder extends Seeder
{
    /**
     * Esegui il seed del database
     */
    public function run()
    {
        // Coupon sconto percentuale (10%)
        Coupon::create([
            'code' => 'SCONTO10',
            'type' => Coupon::TYPE_PERCENT,
            'value' => 10,
            'description' => 'Sconto del 10% su tutto l\'ordine',
            'valid_from' => now(),
            'valid_to' => now()->addMonths(3),
            'max_uses' => 100,
            'min_order' => 50
        ]);

        // Coupon sconto fisso (€15)
        Coupon::create([
            'code' => 'OFF15',
            'type' => Coupon::TYPE_FIXED,
            'value' => 15,
            'description' => 'Sconto di 15€ su ordini superiori a 100€',
            'valid_from' => now()->subDays(15),
            'valid_to' => now()->addMonths(2),
            'max_uses' => 200,
            'min_order' => 100
        ]);

        // Coupon senza limite usi
        Coupon::create([
            'code' => 'WELCOME',
            'type' => Coupon::TYPE_PERCENT,
            'value' => 5,
            'description' => 'Benvenuto! Sconto del 5% senza limiti',
            'valid_from' => now(),
            'valid_to' => now()->addYear(),
            'max_uses' => null, // Nessun limite
            'min_order' => null // Nessun minimo
        ]);

        // Coupon scaduto (per test)
        Coupon::create([
            'code' => 'EXPIRED',
            'type' => Coupon::TYPE_FIXED,
            'value' => 20,
            'description' => 'Coupon scaduto (sconto 20€)',
            'valid_from' => now()->subMonths(3),
            'valid_to' => now()->subMonth(),
            'max_uses' => 50,
            'min_order' => 80
        ]);

        // Coupon raggiunto limite usi
        Coupon::create([
            'code' => 'LIMITE50',
            'type' => Coupon::TYPE_PERCENT,
            'value' => 25,
            'description' => 'Sconto 25% (limite raggiunto)',
            'valid_from' => now()->subDays(10),
            'valid_to' => now()->addDays(30),
            'max_uses' => 50,
            'uses' => 50, // Tutti gli usi esauriti
            'min_order' => 120
        ]);

        // Genera 5 coupon casuali
        for ($i = 0; $i < 5; $i++) {
            Coupon::createNew([
                'type' => rand(0, 1) ? Coupon::TYPE_PERCENT : Coupon::TYPE_FIXED,
                'value' => Coupon::TYPE_PERCENT ? rand(5, 30) : rand(5, 50),
                'description' => 'Coupon promozionale',
                'valid_from' => now(),
                'valid_to' => now()->addMonths(rand(1, 6)),
                'max_uses' => rand(0, 1) ? rand(50, 200) : null,
                'min_order' => rand(0, 1) ? rand(30, 100) : null
            ]);
        }

        $this->command->info('Creati 10 coupon di test nel database!');
    }
}
