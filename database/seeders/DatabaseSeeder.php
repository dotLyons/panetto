<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Location::create([
            'name' => 'Panetto Libertad',
            'slug' => 'panetto-libertad',
        ]);

        Location::create([
            'name' => 'Panetto Plaza',
            'slug' => 'panetto-plaza',
        ]);
        */

        // 1. Crear el Local ID 1 (Si no existe)
        // Usamos firstOrCreate para que no de error si ya lo creaste antes
        $location = Location::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Panetto Libertad',
                'slug' => 'panetto-libertad'
            ]
        );

        // 2. Crear Categorías para este local
        $categoryNames = [
            'Cafetería de Especialidad',
            'Panadería Artesanal',
            'Sandwiches & Tostados',
            'Bebidas Sin Alcohol',
            'Cervezas & Tragos'
        ];

        $categories = [];

        foreach ($categoryNames as $name) {
            $categories[] = Category::create([
                'name' => $name,
                'location_id' => 1 // Asignamos al local 1
            ]);
        }

        // 3. Crear 30 Productos Aleatorios
        // Lista de nombres base para generar variedad
        $prefixes = ['Super', 'Clásico', 'Especial', 'Doble', 'Vegano', 'Casero'];
        $types = ['Café', 'Latte', 'Té', 'Croissant', 'Alfajor', 'Tostado', 'Jugo', 'Licuado', 'Pinta', 'Vino'];

        for ($i = 0; $i < 30; $i++) {
            // Elegir una categoría al azar de las que creamos
            $randomCategory = $categories[array_rand($categories)];

            // Generar nombre ficticio
            $name = $prefixes[array_rand($prefixes)] . ' ' . $types[array_rand($types)];

            Product::create([
                'category_id' => $randomCategory->id,
                'name' => $name,
                'description' => 'Deliciosa opción elaborada con los mejores ingredientes de la casa. Ideal para compartir o disfrutar solo.',
                'price' => rand(1500, 12000), // Precios variados entre 1500 y 12000
                'is_available' => true,
                'image_path' => null, // Sin imagen por ahora
            ]);
        }
    }
}
