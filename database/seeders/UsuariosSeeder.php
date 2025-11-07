<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Permiso;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Crear perfil de Administrador con todos los permisos
        $perfilAdmin = Perfil::firstOrCreate([
            'nombre' => 'Administrador'
        ], [
            'descripcion' => 'Acceso completo a todas las funcionalidades del sistema',
            'activo' => true
        ]);

        // Asignar todos los permisos al perfil de administrador
        $todosLosPermisos = Permiso::all();
        if ($todosLosPermisos->count() > 0) {
            $perfilAdmin->permisos()->sync($todosLosPermisos->pluck('idPermiso'));
        }

        // Crear usuario administrador
        $adminUser = User::updateOrCreate([
            'email' => 'admin@identicard.com'
        ], [
            'name' => 'Administrador',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilAdmin->idPerfil
        ]);

        echo "✓ Usuario administrador creado exitosamente:\n";
        echo "  Email: admin@identicard.com\n";
        echo "  Password: admin123\n";
        echo "  Perfil: Administrador (todos los permisos asignados)\n";
    }
}
