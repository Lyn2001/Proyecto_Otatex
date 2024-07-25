<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear o actualizar roles
        $adminRole = Role::updateOrCreate(
            ['rol_name' => 'admin'],
            ['rol_description' => 'Administrator Role']
        );

        $userRole = Role::updateOrCreate(
            ['rol_name' => 'user'],
            ['rol_description' => 'User Role']
        );

        // Crear o actualizar usuario de prueba con rol de administrador
        User::updateOrCreate(
            ['identification' => '1050193265'],
            [
                'firstname' => 'Veronica',
                'secondname' => 'Cecilia',
                'firstlastname' => 'Saransig',
                'secondlastname' => 'Albancando',
                'email' => 'cecilia2002n@gmail.com',
                'rol_id' => $adminRole->id,
                'phone1' => '0990382254',
                'phone2' => '0986735030',
                'address' => 'Calle Quiroga y Athualpa, Otavalo',
                'password' => bcrypt('Gaara192002'),
            ]
        );
    }
}
