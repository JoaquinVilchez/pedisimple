# 🚀 Deploy de Pedí Simple

## Opción 1: Railway (Recomendado)

### 1. Preparar el proyecto

```bash
# Asegúrate de que todos los cambios estén commitados
git add .
git commit -m "Preparar para deploy"
git push origin main
```

### 2. Crear cuenta en Railway

-   Ve a [railway.app](https://railway.app)
-   Crea una cuenta con GitHub
-   Haz clic en "New Project"

### 3. Conectar repositorio

-   Selecciona "Deploy from GitHub repo"
-   Conecta tu repositorio de GitHub
-   Selecciona la rama `main`

### 4. Configurar base de datos

-   Haz clic en "New Service" → "Database"
-   Selecciona "MySQL"
-   Railway te dará las credenciales automáticamente

### 5. Configurar variables de entorno

En tu servicio web, agrega estas variables:

```
APP_NAME="Pedí Simple"
APP_ENV=production
APP_KEY=base64:TU_APP_KEY_AQUI
APP_DEBUG=false
APP_URL=https://tu-app.railway.app

DB_CONNECTION=mysql
DB_HOST=tu-host-mysql.railway.app
DB_PORT=3306
DB_DATABASE=tu_database
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

CACHE_DRIVER=file
SESSION_DRIVER=file
FILESYSTEM_DISK=local
```

### 6. Generar APP_KEY

```bash
# En tu máquina local
php artisan key:generate
# Copia la clave generada a la variable APP_KEY en Railway
```

### 7. Ejecutar migraciones

En Railway, ve a tu servicio web y ejecuta:

```bash
php artisan migrate --force
php artisan storage:link
```

---

## Opción 2: Render

### 1. Preparar el proyecto

```bash
# Asegúrate de que todos los cambios estén commitados
git add .
git commit -m "Preparar para deploy"
git push origin main
```

### 2. Crear cuenta en Render

-   Ve a [render.com](https://render.com)
-   Crea una cuenta con GitHub
-   Haz clic en "New +" → "Web Service"

### 3. Conectar repositorio

-   Conecta tu repositorio de GitHub
-   Selecciona la rama `main`

### 4. Configurar el servicio

-   **Name**: pedisimple
-   **Environment**: PHP
-   **Build Command**: `composer install --no-dev --optimize-autoloader`
-   **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

### 5. Configurar base de datos

-   Haz clic en "New +" → "PostgreSQL" o "MySQL"
-   Render te dará las credenciales automáticamente

### 6. Configurar variables de entorno

Agrega las mismas variables que en Railway

---

## 🔧 Comandos post-deploy

Después del deploy, ejecuta estos comandos:

```bash
# Migrar base de datos
php artisan migrate --force

# Crear enlace simbólico para storage
php artisan storage:link

# Limpiar cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📱 Configurar WhatsApp (opcional)

Si quieres que funcione WhatsApp:

1. Crea una cuenta en [Meta for Developers](https://developers.facebook.com/)
2. Configura WhatsApp Business API
3. Agrega las credenciales en las variables de entorno

## 🎯 URLs importantes

-   **Demo Comerciante**: pedisimple@gmail.com / 12345678
-   **Demo Usuario**: juanperez@gmail.com / 12345678

## 🚨 Notas importantes

-   **Storage**: Los archivos subidos se perderán en cada deploy. Considera usar S3 o similar para producción
-   **Base de datos**: Los datos se mantienen entre deploys
-   **SSL**: Se configura automáticamente en ambas plataformas
-   **Deploy automático**: Cada push a `main` activará un nuevo deploy
