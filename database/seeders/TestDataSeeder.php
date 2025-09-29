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

        // Crear o actualizar usuario administrador de prueba
        $adminUser = User::updateOrCreate([
            'email' => 'admin@test.com'
        ], [
            'name' => 'Administrador Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilAdmin->idPerfil
        ]);

        // Crear o actualizar usuario editor de prueba
        $editorUser = User::updateOrCreate([
            'email' => 'editor@test.com'
        ], [
            'name' => 'Editor Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilEditor->idPerfil
        ]);

        // Crear o actualizar usuario de solo lectura
        $lecturaUser = User::updateOrCreate([
            'email' => 'lectura@test.com'
        ], [
            'name' => 'Lectura Test',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilLectura->idPerfil
        ]);

        // Crear o actualizar usuario de sucursal específica
        $sucursalUser = User::updateOrCreate([
            'email' => 'sucursal@test.com'
        ], [
            'name' => 'Gestor Sucursal',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'idPerfil' => $perfilEditor->idPerfil
        ]);

        // Asignar sucursales específicas a usuarios de prueba
        $sucursales = \App\Models\Sucursal::take(2)->get(); // Tomar las primeras 2 sucursales
        
        if ($sucursales->count() > 0) {
            // El usuario de sucursal solo puede ver las primeras 2 sucursales
            $sucursalUser->sucursales()->sync($sucursales->pluck('idSucursal'));
            
            // El usuario de lectura puede ver solo la primera sucursal
            $lecturaUser->sucursales()->sync([$sucursales->first()->idSucursal]);
        }

        echo "Perfiles y usuarios de prueba creados:\n";
        echo "Administrador: admin@test.com (password123) - Acceso completo a todas las sucursales\n";
        echo "Editor: editor@test.com (password123) - Edición limitada, todas las sucursales\n";
        echo "Solo Lectura: lectura@test.com (password123) - Solo ver, una sucursal específica\n";
        echo "Gestor Sucursal: sucursal@test.com (password123) - Edición de sucursales específicas\n";
    }
}