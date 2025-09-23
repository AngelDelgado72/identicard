<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permiso;

class PermisosSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Empresas
            ['nombre' => 'Ver Empresas', 'descripcion' => 'Visualizar listado de empresas', 'modulo' => 'empresas', 'accion' => 'ver'],
            ['nombre' => 'Crear Empresas', 'descripcion' => 'Crear nuevas empresas', 'modulo' => 'empresas', 'accion' => 'crear'],
            ['nombre' => 'Editar Empresas', 'descripcion' => 'Modificar empresas existentes', 'modulo' => 'empresas', 'accion' => 'editar'],
            ['nombre' => 'Eliminar Empresas', 'descripcion' => 'Eliminar empresas', 'modulo' => 'empresas', 'accion' => 'eliminar'],

            // Sucursales
            ['nombre' => 'Ver Sucursales', 'descripcion' => 'Visualizar listado de sucursales', 'modulo' => 'sucursales', 'accion' => 'ver'],
            ['nombre' => 'Crear Sucursales', 'descripcion' => 'Crear nuevas sucursales', 'modulo' => 'sucursales', 'accion' => 'crear'],
            ['nombre' => 'Editar Sucursales', 'descripcion' => 'Modificar sucursales existentes', 'modulo' => 'sucursales', 'accion' => 'editar'],
            ['nombre' => 'Eliminar Sucursales', 'descripcion' => 'Eliminar sucursales', 'modulo' => 'sucursales', 'accion' => 'eliminar'],

            // Empleados
            ['nombre' => 'Ver Empleados', 'descripcion' => 'Visualizar listado de empleados', 'modulo' => 'empleados', 'accion' => 'ver'],
            ['nombre' => 'Crear Empleados', 'descripcion' => 'Crear nuevos empleados', 'modulo' => 'empleados', 'accion' => 'crear'],
            ['nombre' => 'Editar Empleados', 'descripcion' => 'Modificar empleados existentes', 'modulo' => 'empleados', 'accion' => 'editar'],
            ['nombre' => 'Eliminar Empleados', 'descripcion' => 'Eliminar empleados', 'modulo' => 'empleados', 'accion' => 'eliminar'],
            ['nombre' => 'Validar Empleados', 'descripcion' => 'Validar información de empleados', 'modulo' => 'empleados', 'accion' => 'validar'],

            // Usuarios
            ['nombre' => 'Ver Usuarios', 'descripcion' => 'Visualizar listado de usuarios', 'modulo' => 'usuarios', 'accion' => 'ver'],
            ['nombre' => 'Crear Usuarios', 'descripcion' => 'Crear nuevos usuarios', 'modulo' => 'usuarios', 'accion' => 'crear'],
            ['nombre' => 'Editar Usuarios', 'descripcion' => 'Modificar usuarios existentes', 'modulo' => 'usuarios', 'accion' => 'editar'],
            ['nombre' => 'Eliminar Usuarios', 'descripcion' => 'Eliminar usuarios', 'modulo' => 'usuarios', 'accion' => 'eliminar'],

            // Perfiles
            ['nombre' => 'Ver Perfiles', 'descripcion' => 'Visualizar listado de perfiles', 'modulo' => 'perfiles', 'accion' => 'ver'],
            ['nombre' => 'Crear Perfiles', 'descripcion' => 'Crear nuevos perfiles', 'modulo' => 'perfiles', 'accion' => 'crear'],
            ['nombre' => 'Editar Perfiles', 'descripcion' => 'Modificar perfiles existentes', 'modulo' => 'perfiles', 'accion' => 'editar'],
            ['nombre' => 'Eliminar Perfiles', 'descripcion' => 'Eliminar perfiles', 'modulo' => 'perfiles', 'accion' => 'eliminar'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::create($permiso);
        }
    }
}
