#  Guía de Instalación - Identicard

## Requisitos Previos
- PHP 8.2 o superior
- Composer
- Node.js y npm
- Servidor web (Apache/Nginx) o usar servidor integrado de PHP
- Base de datos SQLite (incluida) o MySQL

---

##  Pasos para Clonar y Ejecutar en Otra PC

### 1. Clonar el Repositorio
```bash
git clone https://github.com/AngelDelgado72/identicard.git
cd identicard
```

### 2. Instalar Dependencias de PHP
```bash
composer install
```

### 3. Instalar Dependencias de JavaScript
```bash
npm install
```

### 4. Configurar el Archivo de Entorno
```bash
# En Windows PowerShell:
Copy-Item .env.example .env

# En Linux/Mac:
cp .env.example .env
```

### 5. Generar la Clave de Aplicación
```bash
php artisan key:generate
```

### 6. Configurar la Base de Datos
Edita el archivo `.env` y configura la conexión a la base de datos:

**Opción A: SQLite (por defecto)**
```env
DB_CONNECTION=sqlite
DB_DATABASE=C:\ruta\completa\al\proyecto\database\database.sqlite
```

**Opción B: MySQL**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=identicard
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### 7. Crear el Archivo de Base de Datos (solo si usas SQLite)
```bash
# En Windows PowerShell:
New-Item -ItemType File -Path database\database.sqlite -Force

# En Linux/Mac:
touch database/database.sqlite
```

### 8. Ejecutar las Migraciones y Seeders
```bash
php artisan migrate:fresh --seed
```

Esto creará:
- Todas las tablas de la base de datos
- Todos los permisos del sistema
- Usuario administrador:
  - **Email:** admin@identicard.com
  - **Password:** admin123

### 9. Crear el Enlace Simbólico de Storage
```bash
php artisan storage:link
```

### 10. Compilar los Assets de Frontend

**Para Desarrollo:**
```bash
npm run dev
```

**Para Producción:**
```bash
npm run build
```

### 11. Iniciar el Servidor de Desarrollo
```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

---

##  Credenciales de Acceso

### Usuario Administrador
- **Email:** admin@identicard.com
- **Password:** admin123
- **Permisos:** Acceso completo a todas las funcionalidades

---

##  Estructura de Carpetas Importantes

```
identicard/
├── app/                    # Código de la aplicación
├── database/
│   ├── migrations/         # Migraciones de base de datos
│   ├── seeders/           # Seeders (datos iniciales)
│   └── database.sqlite    # Base de datos SQLite (se crea en paso 7)
├── public/
│   └── storage/           # Enlace simbólico (se crea en paso 9)
├── resources/
│   ├── views/             # Plantillas Blade
│   ├── css/               # Estilos CSS
│   └── js/                # JavaScript
├── routes/                # Rutas de la aplicación
├── storage/
│   └── app/
│       └── public/        # Archivos públicos (fotos, firmas, plantillas)
├── .env                   # Configuración (NO se sube a Git)
├── .env.example           # Plantilla de configuración
└── composer.json          # Dependencias PHP
```

---

## 🛠️ Comandos Útiles

### Limpiar Caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Refrescar Base de Datos
```bash
php artisan migrate:fresh --seed
```

### Ver Rutas Disponibles
```bash
php artisan route:list
```

### Ejecutar Solo el Seeder de Usuarios
```bash
php artisan db:seed --class=UsuariosSeeder
```

---

## ⚠️ Solución de Problemas Comunes

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "The stream or file could not be opened"
```bash
# Windows
icacls storage /grant Everyone:F /T
icacls bootstrap/cache /grant Everyone:F /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error al crear enlace simbólico en Windows
Ejecuta PowerShell como Administrador y luego:
```bash
php artisan storage:link
```

---

## 🔒 Seguridad

- **NUNCA** subas el archivo `.env` a Git (ya está en `.gitignore`)
- Cambia la contraseña del administrador después del primer login
- Configura APP_DEBUG=false en producción
- Usa HTTPS en producción

---

##  Soporte

Si encuentras algún problema durante la instalación, verifica:
1. Versión de PHP: `php -v` (debe ser >= 8.2)
2. Versión de Composer: `composer --version`
3. Versión de Node: `node -v`
4. Extensiones de PHP requeridas:
   - PDO
   - SQLite o MySQL
   - OpenSSL
   - Mbstring
   - Tokenizer
   - XML
   - Ctype
   - JSON
   - BCMath
   - Fileinfo
   - GD (para procesamiento de imágenes)

---

**¡Listo para usar! **
