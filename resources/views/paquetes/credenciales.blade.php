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
        }

        .no-print {
            padding: 20px;
            text-align: center;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

        /* Vista previa en pantalla */
        .preview-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        /* Cada página de credencial */
        .credencial-page {
            page-break-after: always;
            page-break-inside: avoid;
            display: none; /* Ocultar en vista previa */
        }

        .credencial-container {
            position: relative;
            width: {{ $plantilla->ancho_mm }}mm;
            height: {{ $plantilla->alto_mm }}mm;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: visible;
        }

        .credencial-lado {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: {{ $plantilla->ancho_mm }}mm {{ $plantilla->alto_mm }}mm;
            background-position: 0 0;
            background-repeat: no-repeat;
        }

        .campo-dato {
            position: absolute;
            overflow: visible;
        }

        .campo-texto {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            word-wrap: break-word;
            white-space: normal;
            line-height: 1;
            overflow: visible;
        }

        .campo-imagen {
            overflow: hidden;
        }

        .campo-imagen img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        /* Estilos de impresión */
        @media print {
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            html, body {
                background-color: white;
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }

            .no-print {
                display: none !important;
            }

            .preview-container {
                display: none !important;
            }

            .credencial-page {
                display: block !important;
                page-break-after: always;
                page-break-before: auto;
                page-break-inside: avoid;
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
                position: relative;
                overflow: hidden;
            }

            .credencial-page:last-child {
                page-break-after: auto;
            }

            .credencial-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                width: {{ $plantilla->ancho_mm }}mm;
                height: {{ $plantilla->alto_mm }}mm;
                overflow: visible;
                position: absolute;
                top: 0;
                left: 0;
            }

            .credencial-lado {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color-adjust: exact;
                background-size: {{ $plantilla->ancho_mm }}mm {{ $plantilla->alto_mm }}mm;
                background-position: 0 0;
            }

            .campo-dato {
                overflow: visible;
            }

            .campo-texto {
                overflow: visible;
            }

            .campo-imagen {
                overflow: hidden;
            }

            /* Asegurar que las imágenes se impriman */
            .campo-imagen img {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color-adjust: exact;
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Botón de impresión (solo visible en pantalla) -->
    <div class="no-print">
        <button onclick="window.print()" class="btn-print">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; display: inline-block; margin-right: 8px; vertical-align: middle;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
            </svg>
            Imprimir Credenciales
        </button>
        <p style="margin-top: 10px; color: #6B7280;">
            <strong>Paquete:</strong> {{ $paquete->nombre }} | 
            <strong>Empleados:</strong> {{ $paquete->empleados->count() }} | 
            <strong>Plantilla:</strong> {{ $plantilla->nombre }}
        </p>
    </div>

    <!-- Vista previa en pantalla -->
    <div class="preview-container no-print">

        @foreach($paquete->empleados as $empleado)
            <div style="margin-bottom: 30px; text-align: center;">
                <h3 style="color: #4F46E5; margin-bottom: 10px;">{{ $empleado->Nombre }} {{ $empleado->Apellido }}</h3>
                
                <!-- Vista previa Frontal -->
                <div class="credencial-container">
                    <div class="credencial-lado" style="background-image: url('{{ asset('storage/' . $plantilla->imagen_frontal) }}');">
                        @if($plantilla->campos_frontal)
                            @foreach($plantilla->campos_frontal as $campo)
                                @php
                                    $config = $campo['config'] ?? [];
                                    $showLabel = $config['showLabel'] ?? false;
                                    $uppercase = $config['uppercase'] ?? false;
                                    $valor = '';
                                    
                                    switch($campo['id']) {
                                        case 'nombre':
                                            $valor = $empleado->Nombre . ' ' . $empleado->Apellido;
                                            break;
                                        case 'puesto':
                                            $valor = $empleado->Puesto ?? '';
                                            break;
                                        case 'departamento':
                                            $valor = $empleado->Departamento ?? '';
                                            break;
                                        case 'rfc':
                                            $valor = $empleado->RFC ?? '';
                                            break;
                                        case 'nss':
                                            $valor = $empleado->NumeroSeguroSocial ?? '';
                                            break;
                                        case 'correo':
                                            $valor = $empleado->Correo ?? '';
                                            break;
                                        case 'tipo_sangre':
                                            $valor = $empleado->TipoSangre ?? '';
                                            break;
                                        case 'codigo_rh':
                                            $valor = $empleado->CodigoRH ?? '';
                                            break;
                                        case 'sucursales':
                                            $sucursales = collect();
                                            if($empleado->sucursal) $sucursales->push($empleado->sucursal->Nombre);
                                            foreach($empleado->sucursales as $suc) {
                                                if(!$sucursales->contains($suc->Nombre)) {
                                                    $sucursales->push($suc->Nombre);
                                                }
                                            }
                                            $valor = $sucursales->implode(', ');
                                            break;
                                    }
                                    
                                    // Aplicar mayúsculas si está configurado
                                    if ($uppercase && $valor) {
                                        $valor = strtoupper($valor);
                                    }
                                    
                                    // Preparar texto con etiqueta si está configurado
                                    $textoFinal = $valor;
                                    if ($showLabel && $campo['tipo'] === 'texto') {
                                        $etiqueta = $campo['nombre'];
                                        $textoFinal = $etiqueta . "\n" . $valor;
                                    }
                                @endphp

                                @if($campo['tipo'] === 'texto')
                                    @if($showLabel)
                                        <div class="campo-dato campo-texto" 
                                             style="left: {{ $campo['x'] }}px; 
                                                    top: {{ $campo['y'] }}px;
                                                    width: {{ $config['width'] ?? 150 }}px;
                                                    min-height: {{ $config['height'] ?? 20 }}px;
                                                    font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                    font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                    text-align: {{ $config['align'] ?? 'left' }};">
                                            <div style="color: {{ $config['labelColor'] ?? '#666666' }}; font-weight: bold; font-size: {{ ($config['fontSize'] ?? 14) * 0.8 }}px;">{{ $campo['nombre'] }}</div>
                                            <div style="color: {{ $config['color'] ?? '#000000' }};">{{ $valor }}</div>
                                        </div>
                                    @else
                                        <div class="campo-dato campo-texto" 
                                             style="left: {{ $campo['x'] }}px; 
                                                    top: {{ $campo['y'] }}px;
                                                    width: {{ $config['width'] ?? 150 }}px;
                                                    min-height: {{ $config['height'] ?? 20 }}px;
                                                    font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                    color: {{ $config['color'] ?? '#000000' }};
                                                    font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                    text-align: {{ $config['align'] ?? 'left' }};">
                                            {{ $valor }}
                                        </div>
                                    @endif
                                @elseif($campo['tipo'] === 'imagen')
                                    @php
                                        $circular = $config['circular'] ?? false;
                                    @endphp
                                    <div class="campo-dato campo-imagen" 
                                         style="left: {{ $campo['x'] }}px; 
                                                top: {{ $campo['y'] }}px;
                                                width: {{ $config['width'] ?? 100 }}px;
                                                height: {{ $config['height'] ?? 100 }}px;
                                                {{ $circular ? 'border-radius: 50%; overflow: hidden;' : '' }}">
                                        @if($campo['id'] === 'foto' && $empleado->Foto)
                                            <img src="{{ asset($empleado->Foto) }}" alt="Foto">
                                        @elseif($campo['id'] === 'firma' && $empleado->Firma)
                                            <img src="{{ asset($empleado->Firma) }}" alt="Firma">
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <p style="color: #6B7280; font-size: 14px;">Frontal</p>

                @if($plantilla->imagen_trasera)
                    <!-- Vista previa Trasera -->
                    <div class="credencial-container" style="margin-top: 15px;">
                        <div class="credencial-lado" style="background-image: url('{{ asset('storage/' . $plantilla->imagen_trasera) }}');">
                            @if($plantilla->campos_trasera)
                                @foreach($plantilla->campos_trasera as $campo)
                                    @php
                                        $config = $campo['config'] ?? [];
                                        $showLabel = $config['showLabel'] ?? false;
                                        $uppercase = $config['uppercase'] ?? false;
                                        $valor = '';
                                        
                                        switch($campo['id']) {
                                            case 'nombre':
                                                $valor = $empleado->Nombre . ' ' . $empleado->Apellido;
                                                break;
                                            case 'puesto':
                                                $valor = $empleado->Puesto ?? '';
                                                break;
                                            case 'departamento':
                                                $valor = $empleado->Departamento ?? '';
                                                break;
                                            case 'rfc':
                                                $valor = $empleado->RFC ?? '';
                                                break;
                                            case 'nss':
                                                $valor = $empleado->NumeroSeguroSocial ?? '';
                                                break;
                                            case 'correo':
                                                $valor = $empleado->Correo ?? '';
                                                break;
                                            case 'tipo_sangre':
                                                $valor = $empleado->TipoSangre ?? '';
                                                break;
                                            case 'codigo_rh':
                                                $valor = $empleado->CodigoRH ?? '';
                                                break;
                                            case 'sucursales':
                                                $sucursales = collect();
                                                if($empleado->sucursal) $sucursales->push($empleado->sucursal->Nombre);
                                                foreach($empleado->sucursales as $suc) {
                                                    if(!$sucursales->contains($suc->Nombre)) {
                                                        $sucursales->push($suc->Nombre);
                                                    }
                                                }
                                                $valor = $sucursales->implode(', ');
                                                break;
                                        }
                                        
                                        // Aplicar mayúsculas si está configurado
                                        if ($uppercase && $valor) {
                                            $valor = strtoupper($valor);
                                        }
                                        
                                        // Preparar texto con etiqueta si está configurado
                                        $textoFinal = $valor;
                                        if ($showLabel && $campo['tipo'] === 'texto') {
                                            $etiqueta = $campo['nombre'];
                                            $textoFinal = $etiqueta . "\n" . $valor;
                                        }
                                    @endphp

                                    @if($campo['tipo'] === 'texto')
                                        @if($showLabel)
                                            <div class="campo-dato campo-texto" 
                                                 style="left: {{ $campo['x'] }}px; 
                                                        top: {{ $campo['y'] }}px;
                                                        width: {{ $config['width'] ?? 150 }}px;
                                                        min-height: {{ $config['height'] ?? 20 }}px;
                                                        font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                        font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                        text-align: {{ $config['align'] ?? 'left' }};">
                                                <div style="color: {{ $config['labelColor'] ?? '#666666' }}; font-weight: bold; font-size: {{ ($config['fontSize'] ?? 14) * 0.8 }}px;">{{ $campo['nombre'] }}</div>
                                                <div style="color: {{ $config['color'] ?? '#000000' }};">{{ $valor }}</div>
                                            </div>
                                        @else
                                            <div class="campo-dato campo-texto" 
                                                 style="left: {{ $campo['x'] }}px; 
                                                        top: {{ $campo['y'] }}px;
                                                        width: {{ $config['width'] ?? 150 }}px;
                                                        min-height: {{ $config['height'] ?? 20 }}px;
                                                        font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                        color: {{ $config['color'] ?? '#000000' }};
                                                        font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                        text-align: {{ $config['align'] ?? 'left' }};">
                                                {{ $valor }}
                                            </div>
                                        @endif
                                    @elseif($campo['tipo'] === 'imagen')
                                        @php
                                            $circular = $config['circular'] ?? false;
                                        @endphp
                                        <div class="campo-dato campo-imagen" 
                                             style="left: {{ $campo['x'] }}px; 
                                                    top: {{ $campo['y'] }}px;
                                                    width: {{ $config['width'] ?? 100 }}px;
                                                    height: {{ $config['height'] ?? 100 }}px;
                                                    {{ $circular ? 'border-radius: 50%; overflow: hidden;' : '' }}">
                                            @if($campo['id'] === 'foto' && $empleado->Foto)
                                                <img src="{{ asset($empleado->Foto) }}" alt="Foto">
                                            @elseif($campo['id'] === 'firma' && $empleado->Firma)
                                                <img src="{{ asset($empleado->Firma) }}" alt="Firma">
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <p style="color: #6B7280; font-size: 14px;">Trasera</p>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Credenciales para impresión (cada una en su propia página) -->
    @foreach($paquete->empleados as $empleado)
        <!-- FRONTAL - Página individual -->
        <!-- Empleado: {{ $empleado->Nombre }} {{ $empleado->Apellido }} - FRONTAL -->
        <div class="credencial-page">
            <div class="credencial-container">
                <div class="credencial-lado" style="background-image: url('{{ asset('storage/' . $plantilla->imagen_frontal) }}');">
                    @if($plantilla->campos_frontal)
                        @foreach($plantilla->campos_frontal as $campo)
                            @php
                                $config = $campo['config'] ?? [];
                                $showLabel = $config['showLabel'] ?? false;
                                $uppercase = $config['uppercase'] ?? false;
                                $valor = '';
                                
                                switch($campo['id']) {
                                    case 'nombre':
                                        $valor = $empleado->Nombre . ' ' . $empleado->Apellido;
                                        break;
                                    case 'puesto':
                                        $valor = $empleado->Puesto ?? '';
                                        break;
                                    case 'departamento':
                                        $valor = $empleado->Departamento ?? '';
                                        break;
                                    case 'rfc':
                                        $valor = $empleado->RFC ?? '';
                                        break;
                                    case 'nss':
                                        $valor = $empleado->NumeroSeguroSocial ?? '';
                                        break;
                                    case 'correo':
                                        $valor = $empleado->Correo ?? '';
                                        break;
                                    case 'tipo_sangre':
                                        $valor = $empleado->TipoSangre ?? '';
                                        break;
                                    case 'codigo_rh':
                                        $valor = $empleado->CodigoRH ?? '';
                                        break;
                                    case 'sucursales':
                                        $sucursales = collect();
                                        if($empleado->sucursal) $sucursales->push($empleado->sucursal->Nombre);
                                        foreach($empleado->sucursales as $suc) {
                                            if(!$sucursales->contains($suc->Nombre)) {
                                                $sucursales->push($suc->Nombre);
                                            }
                                        }
                                        $valor = $sucursales->implode(', ');
                                        break;
                                }
                                
                                // Aplicar mayúsculas si está configurado
                                if ($uppercase && $valor) {
                                    $valor = strtoupper($valor);
                                }
                                
                                // Preparar texto con etiqueta si está configurado
                                $textoFinal = $valor;
                                if ($showLabel && $campo['tipo'] === 'texto') {
                                    $etiqueta = $campo['nombre'];
                                    $textoFinal = $etiqueta . "\n" . $valor;
                                }
                            @endphp

                            @if($campo['tipo'] === 'texto')
                                @if($showLabel)
                                    <div class="campo-dato campo-texto" 
                                         style="left: {{ $campo['x'] }}px; 
                                                top: {{ $campo['y'] }}px;
                                                width: {{ $config['width'] ?? 150 }}px;
                                                min-height: {{ $config['height'] ?? 20 }}px;
                                                font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                text-align: {{ $config['align'] ?? 'left' }};">
                                        <div style="color: {{ $config['labelColor'] ?? '#666666' }}; font-weight: bold; font-size: {{ ($config['fontSize'] ?? 14) * 0.8 }}px;">{{ $campo['nombre'] }}</div>
                                        <div style="color: {{ $config['color'] ?? '#000000' }};">{{ $valor }}</div>
                                    </div>
                                @else
                                    <div class="campo-dato campo-texto" 
                                         style="left: {{ $campo['x'] }}px; 
                                                top: {{ $campo['y'] }}px;
                                                width: {{ $config['width'] ?? 150 }}px;
                                                min-height: {{ $config['height'] ?? 20 }}px;
                                                font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                color: {{ $config['color'] ?? '#000000' }};
                                                font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                text-align: {{ $config['align'] ?? 'left' }};">
                                        {{ $valor }}
                                    </div>
                                @endif
                            @elseif($campo['tipo'] === 'imagen')
                                @php
                                    $circular = $config['circular'] ?? false;
                                @endphp
                                <div class="campo-dato campo-imagen" 
                                     style="left: {{ $campo['x'] }}px; 
                                            top: {{ $campo['y'] }}px;
                                            width: {{ $config['width'] ?? 100 }}px;
                                            height: {{ $config['height'] ?? 100 }}px;
                                            {{ $circular ? 'border-radius: 50%; overflow: hidden;' : '' }}">
                                    @if($campo['id'] === 'foto' && $empleado->Foto)
                                        <img src="{{ asset($empleado->Foto) }}" alt="Foto">
                                    @elseif($campo['id'] === 'firma' && $empleado->Firma)
                                        <img src="{{ asset($empleado->Firma) }}" alt="Firma">
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- TRASERA - Página individual (si existe) -->
        <!-- Empleado: {{ $empleado->Nombre }} {{ $empleado->Apellido }} - TRASERA -->
        @if($plantilla->imagen_trasera)
            <div class="credencial-page">
                <div class="credencial-container">
                    <div class="credencial-lado" style="background-image: url('{{ asset('storage/' . $plantilla->imagen_trasera) }}');">
                        @if($plantilla->campos_trasera)
                            @foreach($plantilla->campos_trasera as $campo)
                                @php
                                    $config = $campo['config'] ?? [];
                                    $showLabel = $config['showLabel'] ?? false;
                                    $uppercase = $config['uppercase'] ?? false;
                                    $valor = '';
                                    
                                    switch($campo['id']) {
                                        case 'nombre':
                                            $valor = $empleado->Nombre . ' ' . $empleado->Apellido;
                                            break;
                                        case 'puesto':
                                            $valor = $empleado->Puesto ?? '';
                                            break;
                                        case 'departamento':
                                            $valor = $empleado->Departamento ?? '';
                                            break;
                                        case 'rfc':
                                            $valor = $empleado->RFC ?? '';
                                            break;
                                        case 'nss':
                                            $valor = $empleado->NumeroSeguroSocial ?? '';
                                            break;
                                        case 'correo':
                                            $valor = $empleado->Correo ?? '';
                                            break;
                                        case 'tipo_sangre':
                                            $valor = $empleado->TipoSangre ?? '';
                                            break;
                                        case 'codigo_rh':
                                            $valor = $empleado->CodigoRH ?? '';
                                            break;
                                        case 'sucursales':
                                            $sucursales = collect();
                                            if($empleado->sucursal) $sucursales->push($empleado->sucursal->Nombre);
                                            foreach($empleado->sucursales as $suc) {
                                                if(!$sucursales->contains($suc->Nombre)) {
                                                    $sucursales->push($suc->Nombre);
                                                }
                                            }
                                            $valor = $sucursales->implode(', ');
                                            break;
                                    }
                                    
                                    // Aplicar mayúsculas si está configurado
                                    if ($uppercase && $valor) {
                                        $valor = strtoupper($valor);
                                    }
                                    
                                    // Preparar texto con etiqueta si está configurado
                                    $textoFinal = $valor;
                                    if ($showLabel && $campo['tipo'] === 'texto') {
                                        $etiqueta = $campo['nombre'];
                                        $textoFinal = $etiqueta . "\n" . $valor;
                                    }
                                @endphp

                                @if($campo['tipo'] === 'texto')
                                    @if($showLabel)
                                        <div class="campo-dato campo-texto" 
                                             style="left: {{ $campo['x'] }}px; 
                                                    top: {{ $campo['y'] }}px;
                                                    width: {{ $config['width'] ?? 150 }}px;
                                                    min-height: {{ $config['height'] ?? 20 }}px;
                                                    font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                    font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                    text-align: {{ $config['align'] ?? 'left' }};">
                                            <div style="color: {{ $config['labelColor'] ?? '#666666' }}; font-weight: bold; font-size: {{ ($config['fontSize'] ?? 14) * 0.8 }}px;">{{ $campo['nombre'] }}</div>
                                            <div style="color: {{ $config['color'] ?? '#000000' }};">{{ $valor }}</div>
                                        </div>
                                    @else
                                        <div class="campo-dato campo-texto" 
                                             style="left: {{ $campo['x'] }}px; 
                                                    top: {{ $campo['y'] }}px;
                                                    width: {{ $config['width'] ?? 150 }}px;
                                                    min-height: {{ $config['height'] ?? 20 }}px;
                                                    font-size: {{ $config['fontSize'] ?? 14 }}px;
                                                    color: {{ $config['color'] ?? '#000000' }};
                                                    font-weight: {{ ($config['bold'] ?? false) ? 'bold' : 'normal' }};
                                                    text-align: {{ $config['align'] ?? 'left' }};">
                                            {{ $valor }}
                                        </div>
                                    @endif
                                @elseif($campo['tipo'] === 'imagen')
                                    @php
                                        $circular = $config['circular'] ?? false;
                                    @endphp
                                    <div class="campo-dato campo-imagen" 
                                         style="left: {{ $campo['x'] }}px; 
                                                top: {{ $campo['y'] }}px;
                                                width: {{ $config['width'] ?? 100 }}px;
                                                height: {{ $config['height'] ?? 100 }}px;
                                                {{ $circular ? 'border-radius: 50%; overflow: hidden;' : '' }}">
                                        @if($campo['id'] === 'foto' && $empleado->Foto)
                                            <img src="{{ asset($empleado->Foto) }}" alt="Foto">
                                        @elseif($campo['id'] === 'firma' && $empleado->Firma)
                                            <img src="{{ asset($empleado->Firma) }}" alt="Firma">
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</body>
</html>
