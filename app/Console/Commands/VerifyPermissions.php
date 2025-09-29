<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VerifyPermissions extends Command
{
    protected $signature = 'verify:permissions {email=admin@test.com}';
    protected $description = 'Verificar permisos de un usuario';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::with('perfil.permisos')->where('email', $email)->first();

        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado");
            return;
        }

        $this->info("=== VERIFICACIÓN DE PERMISOS ===");
        $this->info("Usuario: {$user->name}");
        $this->info("Email: {$user->email}");
        $this->info("ID Perfil: " . ($user->idPerfil ?? 'NULL'));
        
        if ($user->perfil) {
            $this->info("Perfil: {$user->perfil->nombre}");
            $this->info("Perfil Activo: " . ($user->perfil->activo ? 'SÍ' : 'NO'));
            $this->info("Total Permisos: {$user->perfil->permisos->count()}");
            
            $this->info("\n=== PERMISOS ESPECÍFICOS ===");
            $this->info("Puede ver empleados: " . ($user->tienePermiso('empleados', 'ver') ? 'SÍ' : 'NO'));
            $this->info("Puede crear empleados: " . ($user->tienePermiso('empleados', 'crear') ? 'SÍ' : 'NO'));
            $this->info("Puede editar empleados: " . ($user->tienePermiso('empleados', 'editar') ? 'SÍ' : 'NO'));
            $this->info("Puede eliminar empleados: " . ($user->tienePermiso('empleados', 'eliminar') ? 'SÍ' : 'NO'));
            
            $this->info("\n=== SUCURSALES ASIGNADAS ===");
            if ($user->sucursales->count() > 0) {
                foreach ($user->sucursales as $sucursal) {
                    $this->info("- {$sucursal->Nombre} (ID: {$sucursal->idSucursal})");
                }
            } else {
                $this->info("Sin sucursales específicas asignadas (acceso a todas)");
            }
            
        } else {
            $this->error("Usuario sin perfil asignado");
        }
    }
}