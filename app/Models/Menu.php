<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'url', 'slug', 'parent', 'order', 'enabled', 'type', 'data_id'
    ];
    
    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }

    public function optionsMenu()
    {
        return $this->where('enabled', 1)
            ->orderby('parent')
            ->orderby('order')
            ->orderby('name')
            ->get()
            ->toArray();
    }

    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menuAll;
    }

    /**
     * Método para construir menús organizacionales dinámicamente
     */
    public static function buildOrganizationalMenus()
    {
        // Limpiar menús existentes
        self::where('type', 'organizational')->delete();
        
        $user = auth()->user();
        
        // Obtener empresas con relaciones
        $empresasQuery = \App\Models\Empresa::with(['sucursales.empleados']);
        
        if ($user->sucursales->count() > 0) {
            $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
            $empresasQuery->whereHas('sucursales', function($query) use ($sucursalesUsuario) {
                $query->whereIn('idSucursal', $sucursalesUsuario);
            });
        }
        
        $empresas = $empresasQuery->get();
        
        // Filtrar sucursales por usuario
        $empresas->each(function($empresa) use ($user) {
            if ($user->sucursales->count() > 0) {
                $sucursalesUsuario = $user->sucursales->pluck('idSucursal')->toArray();
                $empresa->sucursales = $empresa->sucursales->whereIn('idSucursal', $sucursalesUsuario);
            }
        });

        $order = 1;
        foreach ($empresas as $empresa) {
            // Crear menú empresa
            $empresaMenu = self::create([
                'name' => $empresa->Nombre,
                'url' => '#',
                'slug' => 'empresa-' . $empresa->idEmpresas,
                'parent' => 0,
                'order' => $order++,
                'enabled' => true,
                'type' => 'organizational',
                'data_id' => $empresa->idEmpresas
            ]);
            
            $sucursalOrder = 1;
            foreach ($empresa->sucursales as $sucursal) {
                // Crear menú sucursal
                $sucursalMenu = self::create([
                    'name' => $sucursal->Nombre,
                    'url' => '#',
                    'slug' => 'sucursal-' . $sucursal->idSucursal,
                    'parent' => $empresaMenu->id,
                    'order' => $sucursalOrder++,
                    'enabled' => true,
                    'type' => 'organizational',
                    'data_id' => $sucursal->idSucursal
                ]);
                
                $empleadoOrder = 1;
                foreach ($sucursal->empleados as $empleado) {
                    // Crear menú empleado
                    self::create([
                        'name' => trim($empleado->Nombre . ' ' . ($empleado->Apellido ?? '')),
                        'url' => '#',
                        'slug' => 'empleado-' . $empleado->idEmpleado,
                        'parent' => $sucursalMenu->id,
                        'order' => $empleadoOrder++,
                        'enabled' => true,
                        'type' => 'organizational',
                        'data_id' => $empleado->idEmpleado
                    ]);
                }
            }
        }
        
        return self::menus();
    }
}