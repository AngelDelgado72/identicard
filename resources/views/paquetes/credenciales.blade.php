<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales - {{ $paquete->nombre }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .no-print {
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-print {
            background-color: #4F46E5;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-print:hover {
            background-color: #4338CA;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-info {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-info h1 {
            color: #1F2937;
            margin-bottom: 10px;
        }

        .header-info p {
            color: #6B7280;
            margin: 5px 0;
        }

        .credenciales-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Asegurar que las imágenes se carguen correctamente */
        img {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        .credencial {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            page-break-inside: avoid;
            border: 2px solid #E5E7EB;
        }

        .credencial-header {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: 15px 20px;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        .credencial-header h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .credencial-header .empresa {
            font-size: 12px;
            opacity: 0.9;
        }

        .credencial-body {
            padding: 20px;
        }

        .foto-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .foto {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #E5E7EB;
            background-color: #F3F4F6;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        .no-foto {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border: 4px solid #D1D5DB;
        }

        .no-foto svg {
            width: 60px;
            height: 60px;
            color: #9CA3AF;
        }

        .empleado-nombre {
            text-align: center;
            margin-bottom: 15px;
        }

        .empleado-nombre h3 {
            font-size: 20px;
            color: #1F2937;
            margin-bottom: 5px;
        }

        .empleado-info {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #4B5563;
            min-width: 140px;
            font-size: 13px;
        }

        .info-value {
            color: #1F2937;
            flex: 1;
            font-size: 13px;
        }

        .sucursales-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 5px;
        }

        .badge {
            background-color: #DBEAFE;
            color: #1E40AF;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-validado {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-pendiente {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .firma-container {
            margin-top: 15px;
            text-align: center;
            border-top: 1px solid #E5E7EB;
            padding-top: 15px;
        }

        .firma {
            max-width: 150px;
            max-height: 60px;
            margin: 0 auto;
            display: block;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        .firma-label {
            font-size: 11px;
            color: #6B7280;
            margin-top: 5px;
        }

        /* Estilos de impresión */
        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .header-info {
                display: none !important;
            }

            .credenciales-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .credencial {
                box-shadow: none;
                border: 2px solid #E5E7EB;
                page-break-inside: avoid;
                margin-bottom: 15px;
            }

            /* Asegurar que el gradiente se imprima */
            .credencial-header {
                background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Asegurar que las imágenes se impriman */
            img {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
                display: block !important;
            }

            .foto, .firma {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Asegurar que los badges se impriman con colores */
            .badge, .status-badge {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Asegurar que cada credencial se imprima correctamente */
            @page {
                size: A4;
                margin: 10mm;
            }
        }

        /* Para pantallas pequeñas */
        @media screen and (max-width: 768px) {
            .credenciales-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botón de impresión (solo visible en pantalla) -->
        <div class="no-print">
            <button onclick="window.print()" class="btn-print">
                🖨️ Imprimir Credenciales
            </button>
        </div>

        <!-- Información del paquete -->
        <div class="header-info no-print">
            <h1>{{ $paquete->nombre }}</h1>
            <p><strong>Descripción:</strong> {{ $paquete->descripcion ?: 'Sin descripción' }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $paquete->fecha_creacion->format('d/m/Y') }}</p>
            <p><strong>Estatus:</strong> <span style="color: #059669; font-weight: bold;">{{ $paquete->texto_estatus }}</span></p>
            <p><strong>Total de Empleados:</strong> {{ $paquete->empleados->count() }}</p>
        </div>

        <!-- Grid de credenciales -->
        <div class="credenciales-grid">
            @foreach($paquete->empleados as $empleado)
                <div class="credencial">
                    <!-- Header de la credencial -->
                    <div class="credencial-header">
                        <h2>CREDENCIAL DE EMPLEADO</h2>
                        <div class="empresa">{{ config('app.name', 'Identicard') }}</div>
                    </div>

                    <!-- Cuerpo de la credencial -->
                    <div class="credencial-body">
                        <!-- Foto -->
                        <div class="foto-container">
                            @if($empleado->Foto)
                                <img src="{{ asset($empleado->Foto) }}" 
                                     alt="Foto de {{ $empleado->Nombre }}" 
                                     class="foto"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="no-foto" style="display: none;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @else
                                <div class="no-foto">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Nombre del empleado -->
                        <div class="empleado-nombre">
                            <h3>{{ $empleado->Nombre }} {{ $empleado->Apellido }}</h3>
                            <span class="status-badge {{ $empleado->Validado ? 'status-validado' : 'status-pendiente' }}">
                                {{ $empleado->Validado ? 'Validado' : 'Pendiente' }}
                            </span>
                        </div>

                        <!-- Información del empleado -->
                        <div class="empleado-info">
                            <div class="info-row">
                                <span class="info-label">Puesto:</span>
                                <span class="info-value">{{ $empleado->Puesto ?: 'No especificado' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Departamento:</span>
                                <span class="info-value">{{ $empleado->Departamento ?: 'No especificado' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">RFC:</span>
                                <span class="info-value">{{ $empleado->RFC ?: 'No especificado' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">NSS:</span>
                                <span class="info-value">{{ $empleado->NumeroSeguroSocial ?: 'No especificado' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Correo:</span>
                                <span class="info-value">{{ $empleado->Correo ?: 'No especificado' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Tipo de Sangre:</span>
                                <span class="info-value">{{ $empleado->TipoSangre ?: 'No especificado' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Código RH:</span>
                                <span class="info-value">{{ $empleado->CodigoRH ?: 'No especificado' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Sucursales:</span>
                                <div class="info-value">
                                    @php
                                        $todasSucursales = collect();
                                        if($empleado->sucursal) {
                                            $todasSucursales->push($empleado->sucursal);
                                        }
                                        $todasSucursales = $todasSucursales->merge($empleado->sucursales)->unique('idSucursal');
                                    @endphp
                                    
                                    @if($todasSucursales->count() > 0)
                                        <div class="sucursales-badges">
                                            @foreach($todasSucursales as $sucursal)
                                                <span class="badge">{{ $sucursal->Nombre }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span style="color: #9CA3AF; font-style: italic;">Sin sucursales</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Firma -->
                        @if($empleado->Firma)
                            <div class="firma-container">
                                <img src="{{ asset($empleado->Firma) }}" 
                                     alt="Firma de {{ $empleado->Nombre }}" 
                                     class="firma">
                                <div class="firma-label">Firma del Empleado</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Auto-abrir el diálogo de impresión al cargar la página (opcional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // }
    </script>
</body>
</html>
