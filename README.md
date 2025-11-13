#  Guía de Instalación - Identicard

## 📥 Descargar e Instalar Requisitos Previos

Antes de comenzar, asegúrate de tener instalados los siguientes programas:

### 1. PHP 8.2 o superior
**Windows:**
- Descarga desde: [https://windows.php.net/download/](https://windows.php.net/download/)
- Recomendado: **VS16 x64 Thread Safe** (versión 8.2 o superior)
- Instrucciones: [https://www.php.net/manual/es/install.windows.php](https://www.php.net/manual/es/install.windows.php)

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-mbstring php8.2-xml php8.2-zip php8.2-sqlite3 php8.2-gd
```

**macOS (con Homebrew):**
```bash
brew install php@8.2
```

### 2. Composer (Gestor de Dependencias PHP)
- Descarga desde: [https://getcomposer.org/download/](https://getcomposer.org/download/)
- **Windows:** Descarga el instalador `.exe` y sigue el asistente
- **Linux/macOS:** Sigue las instrucciones en la página oficial

### 3. Node.js y npm (Gestor de Paquetes JavaScript)
- Descarga desde: [(https://nodejs.org/es/download)](https://nodejs.org/es/download)
- Recomendado: **LTS (Long Term Support)** - versión estable
- **Windows/macOS:** Descarga el instalador y ejecútalo
- **Linux:** Usa el gestor de paquetes de tu distribución

**Verificar instalación:**
```bash
php -v          # Debe mostrar versión >= 8.2
composer -V     # Debe mostrar versión de Composer
node -v         # Debe mostrar versión de Node.js
npm -v          # Debe mostrar versión de npm
```

---

##  Pasos para Instalar la Aplicación

### Opción 1: Descargar como ZIP (Recomendado para principiantes)

1. **Descarga el proyecto desde GitHub:**
   - Ve a: [https://github.com/AngelDelgado72/identicard](https://github.com/AngelDelgado72/identicard)
   - Haz clic en el botón verde **"<> Code"**
   - Selecciona **"Download ZIP"**
   - Guarda el archivo en tu computadora

2. **Extrae el archivo ZIP:**
   ```bash
   # Windows: Haz clic derecho > Extraer todo
   # O usa PowerShell en la carpeta donde descargaste:
   Expand-Archive -Path identicard-main.zip -DestinationPath C:\xampp\htdocs\
   
   # Renombra la carpeta (opcional):
   Rename-Item identicard-main identicard
   
   # Navega a la carpeta:
   cd C:\xampp\htdocs\identicard
   ```

3. **Continúa con el paso 2 (Instalar Dependencias)**

### Opción 2: Clonar con Git (Para desarrolladores)

1. **Instalar Git (si no lo tienes):**
   - Descarga desde: [https://git-scm.com/downloads](https://git-scm.com/downloads)

2. **Clonar el Repositorio:**
   ```bash
   git clone https://github.com/AngelDelgado72/identicard.git
   cd identicard
   ```

---

### 2. Instalar Dependencias de PHP
```bash
composer install
```

**Nota:** Este proceso puede tardar varios minutos la primera vez.

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

##  Comandos Útiles

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

##  Solución de Problemas Comunes

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

### Error: "composer: command not found"
- Reinicia la terminal después de instalar Composer
- Verifica que Composer esté en el PATH del sistema
- En Windows, cierra y abre PowerShell nuevamente

### Error: "npm: command not found"
- Reinicia la terminal después de instalar Node.js
- Verifica la instalación con: `node -v` y `npm -v`

### Error: "PHP is not recognized as an internal or external command"
- Agrega PHP al PATH de Windows:
  1. Busca "Variables de entorno" en Windows
  2. Edita la variable PATH
  3. Agrega la ruta donde instalaste PHP (ej: `C:\php`)
  4. Reinicia la terminal

---

##  Seguridad

- Cambia la contraseña del administrador después del primer login
- Configura APP_DEBUG=false en producción
- Usa HTTPS en producción

---

##  Enlaces Útiles y Recursos

### Descargas Oficiales
- **PHP:** [https://www.php.net/downloads](https://www.php.net/downloads)
  - Windows: [https://windows.php.net/download/](https://windows.php.net/download/)
- **Composer:** [https://getcomposer.org/download/](https://getcomposer.org/download/)
- **Node.js:** [https://nodejs.org/](https://nodejs.org/)
- **Git:** [https://git-scm.com/downloads](https://git-scm.com/downloads)

### Documentación
- **Laravel:** [https://laravel.com/docs](https://laravel.com/docs)
- **Tailwind CSS:** [https://tailwindcss.com/docs](https://tailwindcss.com/docs)
- **PHP:** [https://www.php.net/manual/es/](https://www.php.net/manual/es/)

### Herramientas Recomendadas
- **XAMPP (PHP + MySQL todo en uno):** [https://www.apachefriends.org/](https://www.apachefriends.org/)
- **Laragon (Alternativa a XAMPP):** [https://laragon.org/](https://laragon.org/)
- **Visual Studio Code:** [https://code.visualstudio.com/](https://code.visualstudio.com/)
- **PhpStorm:** [https://www.jetbrains.com/phpstorm/](https://www.jetbrains.com/phpstorm/)

### Extensiones PHP Requeridas
Si tienes problemas con extensiones faltantes, asegúrate de tener:
- PDO (php_pdo.dll)
- SQLite (php_pdo_sqlite.dll) o MySQL (php_pdo_mysql.dll)
- OpenSSL (php_openssl.dll)
- Mbstring (php_mbstring.dll)
- Tokenizer
- XML (php_xml.dll)
- Ctype
- JSON
- BCMath (php_bcmath.dll)
- Fileinfo (php_fileinfo.dll)
- GD (php_gd.dll) - para procesamiento de imágenes

**Habilitar extensiones en Windows:**
1. Abre el archivo `php.ini`
2. Busca las líneas con `;extension=nombre_extension`
3. Elimina el `;` al inicio para activarlas
4. Reinicia el servidor

---

##  Soporte y Contacto

Si encuentras algún problema durante la instalación:

1. **Verifica las versiones:**
   ```bash
   php -v          # Debe ser >= 8.2
   composer -V     # Cualquier versión reciente
   node -v         # Debe ser >= 16.x
   npm -v
   ```

2. **Revisa los logs de errores:**
   - Laravel: `storage/logs/laravel.log`
   - Servidor PHP: Error en la terminal donde ejecutas `php artisan serve`

3. **Comandos de depuración útiles:**
   ```bash
   # Ver información de PHP
   php -i
   
   # Ver extensiones cargadas
   php -m
   
   # Verificar configuración de Laravel
   php artisan about
   ```
