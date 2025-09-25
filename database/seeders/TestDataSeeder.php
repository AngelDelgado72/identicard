<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Permiso;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
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
            $perfilAdmin->permisos()->syncWithoutDetaching($todosLosPermisos->pluck('idPermiso'));
        }

        // Crear perfil de Editor con permisos limitados
        $perfilEditor = Perfil::firstOrCreate([
            'nombre' => 'Editor'
        ], [
            'descripcion' => 'Puede ver y editar empleados y empresas, pero no usuarios ni perfiles',
            'activo' => true
        ]);

        // Asignar permisos específicos al editor
        $permisosEditor = Permiso::whereIn('modulo', ['empresas', 'sucursales', 'empleados'])
            ->whereIn('accion', ['ver', 'crear', 'editar'])
            ->get();
        if ($permisosEditor->count() > 0) {
            $perfilEditor->permisos()->syncWithoutDetaching($permisosEditor->pluck('idPermiso'));
        }

        // Crear perfil de Solo Lectura
        $perfilLectura = Perfil::firstOrCreate([
            'nombre' => 'Solo Lectura'
        ], [
            'descripcion' => 'Solo puede ver información, sin permisos de edición',
            'activo' => true
        ]);

        // Asignar solo permisos de lectura
        $permisosLectura = Permiso::where('accion', 'ver')->get();
        if ($permisosLectura->count() > 0) {
            $perfilLectura->permisos()->syncWithoutDetaching($permisosLectura->pluck('idPermiso'));
        }

        // Crear usuario administrador de prueba
        $adminUser = User::firstOrCreate([
            'email' => 'admin@test.com'
        ], [
            'name' => 'Administrador Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilAdmin->idPerfil
        ]);

        // Crear usuario editor de prueba
        $editorUser = User::firstOrCreate([
            'email' => 'editor@test.com'
        ], [
            'name' => 'Editor Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilEditor->idPerfil
        ]);

        // Crear usuario de solo lectura
        $lecturaUser = User::firstOrCreate([
            'email' => 'lectura@test.com'
        ], [
            'name' => 'Lectura Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilLectura->idPerfil
        ]);

        echo "Perfiles y usuarios de prueba creados:\n";
        echo "Administrador: admin@test.com (password123) - Acceso completo\n";
        echo "Editor: editor@test.com (password123) - Edición limitada\n";
        echo "Solo Lectura: lectura@test.com (password123) - Solo ver\n";
    }
}