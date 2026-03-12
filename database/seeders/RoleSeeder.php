<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear los roles
        Role::firstOrCreate(['name' => 'gerente']);
        Role::firstOrCreate(['name' => 'encargado']);
        Role::firstOrCreate(['name' => 'jefe-cocina']);

        $this->command->info('Roles creados: gerente, encargado, jefe-cocina');
    }
}
