<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Api\OrganizationalController;
use App\Http\Controllers\PaqueteController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de empresas con permisos
Route::middleware(['auth', 'verified', 'permission:empresas,ver'])->group(function () {
    Route::get('/empresas/crud', [DashboardController::class, 'empresasCrud'])->name('empresas.crud');
});

Route::middleware(['auth', 'verified', 'permission:empresas,crear'])->group(function () {
    Route::get('/empresas/create', function () {
        return view('empresas.create');
    })->name('empresas.create');
    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
});

Route::middleware(['auth', 'verified', 'permission:empresas,editar'])->group(function () {
    Route::get('/empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
    Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
});

Route::middleware(['auth', 'verified', 'permission:empresas,eliminar'])->group(function () {
    Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
});

// Rutas de sucursales con permisos
Route::middleware(['auth', 'verified', 'permission:sucursales,ver'])->group(function () {
    Route::get('/sucursales/crud/{empresa?}', [DashboardController::class, 'sucursalesCrud'])->name('sucursales.crud');
    Route::get('/sucursales/{sucursal}/empleados', [EmpleadoController::class, 'porSucursal'])->name('sucursales.empleados');
});

Route::middleware(['auth', 'verified', 'permission:sucursales,crear'])->group(function () {
    Route::get('/sucursales/create', [SucursalController::class, 'create'])->name('sucursales.create');
    Route::post('/sucursales', [SucursalController::class, 'store'])->name('sucursales.store');
});

Route::middleware(['auth', 'verified', 'permission:sucursales,editar'])->group(function () {
    Route::get('/sucursales/{sucursal}/edit', [SucursalController::class, 'edit'])->name('sucursales.edit');
    Route::put('/sucursales/{sucursal}', [SucursalController::class, 'update'])->name('sucursales.update');
});

Route::middleware(['auth', 'verified', 'permission:sucursales,eliminar'])->group(function () {
    Route::delete('/sucursales/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');
});

// Rutas de empleados con permisos
Route::middleware(['auth', 'verified', 'permission:empleados,ver'])->group(function () {
    Route::get('/empleados/crud', [DashboardController::class, 'empleadosCrud'])->name('empleados.crud');
});

Route::middleware(['auth', 'verified', 'permission:empleados,crear'])->group(function () {
    Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
});

Route::middleware(['auth', 'verified', 'permission:empleados,ver'])->group(function () {
    Route::get('/empleados/{empleado}', [EmpleadoController::class, 'show'])->name('empleados.show');
});

Route::middleware(['auth', 'verified', 'permission:empleados,editar'])->group(function () {
    Route::get('/empleados/{empleado}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::post('/empleados/{empleado}/validar', [EmpleadoController::class, 'validar'])->name('empleados.validar');
});

Route::middleware(['auth', 'verified', 'permission:empleados,eliminar'])->group(function () {
    Route::delete('/empleados/{empleado}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
});

// Rutas de administración con permisos
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    
    // Rutas de perfiles
    Route::middleware(['permission:perfiles,ver'])->group(function () {
        Route::get('perfiles', [PerfilController::class, 'index'])->name('perfiles.index');
    });
    
    Route::middleware(['permission:perfiles,crear'])->group(function () {
        Route::get('perfiles/create', [PerfilController::class, 'create'])->name('perfiles.create');
        Route::post('perfiles', [PerfilController::class, 'store'])->name('perfiles.store');
    });
    
    Route::middleware(['permission:perfiles,ver'])->group(function () {
        Route::get('perfiles/{perfil}', [PerfilController::class, 'show'])->name('perfiles.show');
    });
    
    Route::middleware(['permission:perfiles,editar'])->group(function () {
        Route::get('perfiles/{perfil}/edit', [PerfilController::class, 'edit'])->name('perfiles.edit');
        Route::put('perfiles/{perfil}', [PerfilController::class, 'update'])->name('perfiles.update');
        Route::patch('perfiles/{perfil}', [PerfilController::class, 'update']);
    });
    
    Route::middleware(['permission:perfiles,eliminar'])->group(function () {
        Route::delete('perfiles/{perfil}', [PerfilController::class, 'destroy'])->name('perfiles.destroy');
    });

    // Rutas de usuarios
    Route::middleware(['permission:usuarios,ver'])->group(function () {
        Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    });
    
    Route::middleware(['permission:usuarios,crear'])->group(function () {
        Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    });
    
    Route::middleware(['permission:usuarios,ver'])->group(function () {
        Route::get('usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
    });
    
    Route::middleware(['permission:usuarios,editar'])->group(function () {
        Route::get('usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::patch('usuarios/{usuario}', [UsuarioController::class, 'update']);
    });
    
    Route::middleware(['permission:usuarios,eliminar'])->group(function () {
        Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });
});

// Rutas de paquetes con permisos
Route::middleware(['auth', 'verified', 'permission:paquetes,ver'])->group(function () {
    Route::get('/paquetes', [PaqueteController::class, 'index'])->name('paquetes.index');
});

Route::middleware(['auth', 'verified', 'permission:paquetes,crear'])->group(function () {
    Route::get('/paquetes/create', [PaqueteController::class, 'create'])->name('paquetes.create');
    Route::post('/paquetes', [PaqueteController::class, 'store'])->name('paquetes.store');
    Route::post('/paquetes/{paquete}/empleados', [PaqueteController::class, 'agregarEmpleado'])->name('paquetes.agregar-empleado');
});

Route::middleware(['auth', 'verified', 'permission:paquetes,editar'])->group(function () {
    Route::get('/paquetes/{paquete}/edit', [PaqueteController::class, 'edit'])->name('paquetes.edit');
    Route::put('/paquetes/{paquete}', [PaqueteController::class, 'update'])->name('paquetes.update');
    Route::patch('/paquetes/{paquete}', [PaqueteController::class, 'update']);
    Route::delete('/paquetes/{paquete}/empleados/{idEmpleado}', [PaqueteController::class, 'removerEmpleado'])->name('paquetes.remover-empleado');
});

Route::middleware(['auth', 'verified', 'permission:paquetes,confirmar'])->group(function () {
    Route::patch('/paquetes/{paquete}/confirmar', [PaqueteController::class, 'confirmar'])->name('paquetes.confirmar');
});

Route::middleware(['auth', 'verified', 'permission:paquetes,autorizar'])->group(function () {
    Route::patch('/paquetes/{paquete}/autorizar', [PaqueteController::class, 'autorizar'])->name('paquetes.autorizar');
});

Route::middleware(['auth', 'verified', 'permission:paquetes,eliminar'])->group(function () {
    Route::delete('/paquetes/{paquete}', [PaqueteController::class, 'destroy'])->name('paquetes.destroy');
});

Route::middleware(['auth', 'verified', 'permission:paquetes,ver'])->group(function () {
    Route::get('/paquetes/{paquete}', [PaqueteController::class, 'show'])->name('paquetes.show');
});

// Rutas API para información organizacional
Route::middleware('auth')->group(function () {
    Route::get('/api/empresa/{id}', [\App\Http\Controllers\Api\OrganizationalController::class, 'getEmpresa'])->name('api.empresa');
    Route::get('/api/sucursal/{id}', [\App\Http\Controllers\Api\OrganizationalController::class, 'getSucursal'])->name('api.sucursal');
    Route::get('/api/empleado/{id}', [\App\Http\Controllers\Api\OrganizationalController::class, 'getEmpleado'])->name('api.empleado');
});

require __DIR__.'/auth.php';
