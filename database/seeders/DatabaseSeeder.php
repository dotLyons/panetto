<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\RaffleEntry;
use App\Models\SurveyEntry;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Panetto Libertad', 'slug' => 'panetto-libertad'],
            ['name' => 'Panetto Plaza', 'slug' => 'panetto-plaza'],
            ['name' => 'Panetto Club', 'slug' => 'panetto-club'],
            ['name' => 'Panetto Coventry', 'slug' => 'panetto-coventry'],
        ];

        $categoriesData = [
            'Cafetería de Especialidad' => [
                'Café Americano',
                'Café Latte',
                'Cappuccino',
                'Mocha',
                'Flat White',
                'Cold Brew',
                'Chocolate Caliente',
            ],
            'Panadería Artesanal' => [
                'Croissant Simple',
                'Croissant de Queso',
                'Medialuna',
                'Facturas Varias',
                'Panqueque de Dulce de Leche',
                'Biscocho de Vainilla',
                'Budín de Limón',
            ],
            'Sandwiches & Tostados' => [
                'Tostado de Jamón y Queso',
                'Tostado de Queso y Tomate',
                'Sandwich de Miga Mixto',
                'Sandwich de Vegetales',
                'Sándwich de Pollo',
                'Baguette Jamón y Queso',
            ],
            'Bebidas Sin Alcohol' => [
                'Jugo de Naranja',
                'Jugo de Manzana',
                'Licuado de Banana',
                'Licuado de Frutilla',
                'Agua Mineral',
                'Soda de Limón',
                'Red Bull',
            ],
            'Cervezas & Tragos' => [
                'Pinta de Cerveza Rubia',
                'Pinta de Cerveza Negra',
                'Cerveza sin Alcohol',
                'Copa de Vino Tinto',
                'Copa de Vino Blanco',
                'Fernet con Coca',
                'Gin Tonic',
            ],
            'Promo' => [
                'Combo Desayuno Panetto',
                'Merienda Express',
                'Café + Factura',
            ],
        ];

        $productsData = [
            'Cafetería de Especialidad' => [
                ['name' => 'Café Americano', 'price' => 1200],
                ['name' => 'Café Latte', 'price' => 1500],
                ['name' => 'Cappuccino', 'price' => 1600],
                ['name' => 'Mocha', 'price' => 1800],
                ['name' => 'Flat White', 'price' => 1550],
                ['name' => 'Cold Brew', 'price' => 1700],
                ['name' => 'Chocolate Caliente', 'price' => 1400],
                ['name' => 'Café Doble', 'price' => 1800],
                ['name' => 'Latte Macchiato', 'price' => 1650],
                ['name' => 'Café Irlandés', 'price' => 2200],
            ],
            'Panadería Artesanal' => [
                ['name' => 'Croissant Simple', 'price' => 800],
                ['name' => 'Croissant de Queso', 'price' => 950],
                ['name' => 'Medialuna Salada', 'price' => 600],
                ['name' => 'Medialuna Dulce', 'price' => 550],
                ['name' => 'Factura de Crema', 'price' => 900],
                ['name' => 'Factura de DulcedeLeche', 'price' => 1000],
                ['name' => 'Panqueque de Dulce de Leche', 'price' => 1100],
                ['name' => 'Budín de Vainilla', 'price' => 850],
                ['name' => 'Muffin de Chocolate', 'price' => 750],
                ['name' => 'Cookies con Chispas', 'price' => 650],
            ],
            'Sandwiches & Tostados' => [
                ['name' => 'Tostado de Jamón y Queso', 'price' => 2500],
                ['name' => 'Tostado de Queso y Tomate', 'price' => 2200],
                ['name' => 'Sandwich de Miga Mixto', 'price' => 2100],
                ['name' => 'Sandwich de Vegetales', 'price' => 2000],
                ['name' => 'Sandwich de Pollo', 'price' => 2400],
                ['name' => 'Baguette Jamón y Queso', 'price' => 2800],
                ['name' => 'Hamburguesa Panetto', 'price' => 3200],
                ['name' => 'Hot Dog Premium', 'price' => 2100],
                ['name' => 'Ensalada César', 'price' => 2600],
                ['name' => 'Pancake con Maple', 'price' => 2300],
            ],
            'Bebidas Sin Alcohol' => [
                ['name' => 'Jugo de Naranja', 'price' => 1200],
                ['name' => 'Jugo de Manzana', 'price' => 1200],
                ['name' => 'Licuado de Banana', 'price' => 1500],
                ['name' => 'Licuado de Frutilla', 'price' => 1600],
                ['name' => 'Licuado Mixto', 'price' => 1700],
                ['name' => 'Agua Mineral', 'price' => 600],
                ['name' => 'Soda de Limón', 'price' => 800],
                ['name' => 'Red Bull', 'price' => 1800],
                ['name' => 'Batido de Vainilla', 'price' => 1400],
                ['name' => 'Smoothie Verde', 'price' => 1900],
            ],
            'Cervezas & Tragos' => [
                ['name' => 'Pinta de Cerveza Rubia', 'price' => 2500],
                ['name' => 'Pinta de Cerveza Negra', 'price' => 2700],
                ['name' => 'Cerveza sin Alcohol', 'price' => 1800],
                ['name' => 'Copa de Vino Tinto', 'price' => 2200],
                ['name' => 'Copa de Vino Blanco', 'price' => 2200],
                ['name' => 'Fernet con Coca', 'price' => 3000],
                ['name' => 'Gin Tonic', 'price' => 3500],
                ['name' => 'Whisky on the Rocks', 'price' => 4000],
                ['name' => 'Caipirinha', 'price' => 3200],
                ['name' => 'Copa de Champagne', 'price' => 3800],
            ],
            'Promo' => [
                ['name' => 'Combo Desayuno Panetto', 'price' => 4500, 'description' => 'Café + Croissant + Jugo'],
                ['name' => 'Merienda Express', 'price' => 3200, 'description' => 'Café + Factura'],
                ['name' => 'Café + Factura', 'price' => 2800, 'description' => 'Cualquier café + factura a elección'],
                ['name' => 'Combo Tarde', 'price' => 5000, 'description' => 'Cerveza + Tostado + Papas'],
                ['name' => 'Family Pack', 'price' => 8500, 'description' => '4 Cervezas + 2 Tostados + Nachos'],
            ],
        ];

        foreach ($locations as $locData) {
            $location = Location::firstOrCreate(
                ['slug' => $locData['slug']],
                ['name' => $locData['name']]
            );

            foreach ($categoriesData as $catName => $productNames) {
                $category = Category::firstOrCreate(
                    ['name' => $catName, 'location_id' => $location->id],
                    ['name' => $catName, 'location_id' => $location->id]
                );

                $products = $productsData[$catName] ?? [];
                foreach ($products as $prod) {
                    Product::firstOrCreate(
                        [
                            'name' => $prod['name'],
                            'category_id' => $category->id,
                        ],
                        [
                            'name' => $prod['name'],
                            'description' => $prod['description'] ?? 'Deliciosa opción elaborada con los mejores ingredientes de la casa.',
                            'price' => $prod['price'],
                            'category_id' => $category->id,
                            'is_available' => true,
                            'active' => true,
                            'image_path' => null,
                        ]
                    );
                }
            }
        }

        $this->command->info('Sucursales, categorías y productos creados exitosamente!');

        $this->createRaffleEntries();
        $this->createSurveyEntries();
    }

    private function createRaffleEntries()
    {
        $names = [
            ['Juan', 'Pérez'],
            ['María', 'González'],
            ['Carlos', 'Rodríguez'],
            ['Ana', 'López'],
            ['Pedro', 'Martínez'],
            ['Laura', 'Fernández'],
            ['Diego', 'García'],
            ['Sofia', 'Sánchez'],
            ['Martín', 'Torres'],
            ['Isabella', 'Ramírez'],
            ['Gabriel', 'Jiménez'],
            ['Valentina', 'Morales'],
            ['Nicolás', 'Herrera'],
            ['Emma', 'Vargas'],
            ['Lucas', 'Medina'],
            ['Mía', 'Castro'],
            ['Sebastián', 'Ortega'],
            ['Lucía', 'Núñez'],
            ['Alejandro', 'Reyes'],
            ['Catalina', 'Flores'],
        ];

        $ratings = [3, 4, 4, 4, 5, 5, 5, 5, 5, 5];
        $hours = ['08:30', '09:15', '10:00', '11:30', '12:45', '13:20', '14:00', '15:30', '18:00', '19:15', '20:30', '21:00'];

        foreach ($names as $i => $name) {
            RaffleEntry::create([
                'dni' => 30000000 + $i,
                'name' => $name[0],
                'last_name' => $name[1],
                'phone' => '385' . rand(4000000, 4999999),
                'table_number' => $i + 1, // Números únicos: 1, 2, 3, ...
                'visit_time' => $hours[array_rand($hours)],
                'rating' => $ratings[array_rand($ratings)],
            ]);
        }

        $this->command->info('Participantes del sorteo creados!');
    }

    private function createSurveyEntries()
    {
        $surveys = [
            ['name' => 'Juan', 'last_name' => 'Pérez', 'brings_kids' => 'Sí, frecuentemente', 'kids_ages' => ['3–5 años', '6–9 años'], 'useful_play_area' => 'Muy útil', 'visit_more_often' => 'Sí, mucho más seguido'],
            ['name' => 'María', 'last_name' => 'González', 'brings_kids' => 'A veces', 'kids_ages' => ['6–9 años'], 'useful_play_area' => 'Algo útil', 'visit_more_often' => 'Un poco más seguido'],
            ['name' => 'Carlos', 'last_name' => 'Rodríguez', 'brings_kids' => 'No', 'kids_ages' => [], 'useful_play_area' => 'Me da igual', 'visit_more_often' => 'Igual que ahora'],
            ['name' => 'Ana', 'last_name' => 'López', 'brings_kids' => 'Sí, frecuentemente', 'kids_ages' => ['0–2 años', '3–5 años'], 'useful_play_area' => 'Muy útil', 'visit_more_often' => 'Sí, mucho más seguido'],
            ['name' => 'Pedro', 'last_name' => 'Martínez', 'brings_kids' => 'No', 'kids_ages' => [], 'useful_play_area' => 'No me interesa', 'visit_more_often' => 'Vendría menos'],
            ['name' => 'Laura', 'last_name' => 'Fernández', 'brings_kids' => 'A veces', 'kids_ages' => ['10+'], 'useful_play_area' => 'Algo útil', 'visit_more_often' => 'Igual que ahora'],
            ['name' => 'Diego', 'last_name' => 'García', 'brings_kids' => 'Sí, frecuentemente', 'kids_ages' => ['3–5 años', '6–9 años', '10+'], 'useful_play_area' => 'Muy útil', 'visit_more_often' => 'Sí, mucho más seguido'],
            ['name' => 'Sofia', 'last_name' => 'Sánchez', 'brings_kids' => 'No', 'kids_ages' => [], 'useful_play_area' => 'Me da igual', 'visit_more_often' => 'Igual que ahora'],
            ['name' => 'Martín', 'last_name' => 'Torres', 'brings_kids' => 'A veces', 'kids_ages' => ['6–9 años'], 'useful_play_area' => 'Algo útil', 'visit_more_often' => 'Un poco más seguido'],
            ['name' => 'Isabella', 'last_name' => 'Ramírez', 'brings_kids' => 'No', 'kids_ages' => [], 'useful_play_area' => 'No me interesa', 'visit_more_often' => 'Igual que ahora'],
        ];

        $hours = ['08:30', '09:15', '10:00', '11:30', '12:45', '13:20', '14:00', '15:30', '18:00', '19:15'];

        foreach ($surveys as $i => $survey) {
            SurveyEntry::create([
                'dni' => 35000000 + $i,
                'name' => $survey['name'],
                'last_name' => $survey['last_name'],
                'phone' => '385' . rand(4000000, 4999999),
                'email' => strtolower($survey['name']) . '.' . strtolower($survey['last_name']) . '@gmail.com',
                'visit_time' => $hours[array_rand($hours)],
                'brings_kids' => $survey['brings_kids'],
                'kids_ages' => $survey['kids_ages'],
                'useful_play_area' => $survey['useful_play_area'],
                'visit_more_often' => $survey['visit_more_often'],
            ]);
        }

        $this->command->info('Encuestas de ejemplo creadas!');

        $this->createUsers();
    }

    private function createUsers()
    {
        $users = [
            ['name' => 'Encargado Libertad', 'email' => 'libertad@panetto.com', 'location' => 'panetto-libertad'],
            ['name' => 'Encargado Plaza', 'email' => 'plaza@panetto.com', 'location' => 'panetto-plaza'],
            ['name' => 'Encargado Club', 'email' => 'club@panetto.com', 'location' => 'panetto-club'],
            ['name' => 'Encargado Coventry', 'email' => 'coventry@panetto.com', 'location' => 'panetto-coventry'],
        ];

        foreach ($users as $userData) {
            $location = \App\Models\Location::where('slug', $userData['location'])->first();
            
            \App\Models\User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => bcrypt('password'),
                    'location_id' => $location?->id,
                ]
            );
        }

        $this->command->info('Usuarios creados: libertad@panetto.com, plaza@panetto.com, club@panetto.com, coventry@panetto.com (password: password)');
    }
}
