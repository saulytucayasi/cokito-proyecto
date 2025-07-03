# 🎓 COKITO+ Academia - Sistema de Gestión Académica

Sistema completo de gestión académica desarrollado con **Laravel 11** y **PHP 8.1+**, diseñado específicamente para instituciones educativas modernas. Incluye gestión completa de cursos, materiales, videos de YouTube, y un sistema de roles robusto.

## 🚀 Características Principales

### ✅ Autenticación Personalizada
- Sistema de login/logout personalizado (sin Breeze o Spatie)
- Control de roles basado en campo `rol` de tabla `usuario`
- Redirección automática según rol después del login
- Recuperación de contraseña por email
- Middleware personalizado `RoleMiddleware` para protección de rutas

### 👥 Sistema de Roles Avanzado
- **Admin**: Control total del sistema, gestión de usuarios, cursos, ciclos y reportes
- **Docente**: Gestión completa de cursos asignados, materiales educativos y videos
- **Secretaria**: Procesamiento de matrículas, gestión de pagos y administración de estudiantes  
- **Estudiante**: Acceso a cursos matriculados, descarga de materiales y visualización de videos

### 📊 Dashboards Especializados
- Dashboard personalizado para cada rol con métricas relevantes
- Widgets interactivos con estadísticas en tiempo real
- Accesos rápidos a funcionalidades principales
- Gráficos de progreso y métricas de rendimiento

### 📁 Sistema de Archivos Avanzado
- Subida de materiales educativos (PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, JPG, JPEG, PNG, GIF, MP4, AVI, MOV)
- Validación de archivos hasta 50MB con tipos específicos
- Organización por curso, tipo y orden de presentación
- Descarga segura con middleware de autenticación
- Interfaz drag & drop moderna para mejor UX
- Sistema de tipos: documento, presentación, imagen, video, audio, otro
- Control de visibilidad (público/privado)

### 🎥 Integración YouTube Completa
- Gestión de videos educativos organizados por curso
- Extracción automática de ID de YouTube con validación robusta
- Thumbnails automáticos desde YouTube API
- Player embebido responsivo con controles completos
- Organización por orden de presentación y estado (activo/inactivo)
- Vista previa en tiempo real al agregar URLs
- Gestión de duración y metadatos

### 🎨 Diseño Moderno y Responsive
- CSS personalizado con variables CSS para consistencia
- Paleta de colores moderna con tonos morados/azules
- Diseño responsive mobile-first con sidebar colapsible
- Componentes modernos con efectos glassmorphism
- Gradientes y animaciones suaves
- Contrast mejorado para mejor legibilidad
- Efectos hover y transiciones modernas

## 🛠️ Instalación Completa

### Prerrequisitos del Sistema
```bash
- PHP 8.1+ (con extensiones: openssl, pdo, mbstring, tokenizer, xml, gd, zip)
- Composer 2.0+
- MySQL 8.0+ o MariaDB 10.3+
- Node.js 18+ (LTS recomendado)
- npm 8+
- Git (para clonación)
```

### 🚀 Guía de Instalación Paso a Paso

#### 1. **Clonar el Repositorio**
```bash
git clone https://github.com/tu-usuario/academia-cokito.git
cd academia-cokito
```

#### 2. **Instalar Dependencias PHP**
```bash
composer install --optimize-autoloader
```

#### 3. **Configurar Archivo de Entorno**
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

#### 4. **Configurar Base de Datos**
Crear base de datos MySQL:
```bash
mysql -u root -p -e "CREATE DATABASE academia_cokito CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Editar archivo `.env`:
```env
APP_NAME="COKITO+ Academia"
APP_ENV=local
APP_KEY=base64:tu_clave_generada
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=academia_cokito
DB_USERNAME=root
DB_PASSWORD=tu_password

FILESYSTEM_DISK=public

# Configuración de correo (opcional para recuperación de contraseña)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="admin@cokito.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### 5. **Configurar Storage y Permisos**
```bash
# Crear enlace simbólico para archivos públicos
php artisan storage:link

# Configurar permisos (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 6. **Instalar y Compilar Assets Frontend**
```bash
# Instalar dependencias Node.js
npm install

# Compilar assets para desarrollo
npm run dev

# O compilar para producción
npm run build
```

#### 7. **Ejecutar Migraciones y Seeders**
```bash
# Ejecutar migraciones de base de datos
php artisan migrate

# Cargar datos de prueba (usuarios, cursos, materiales)
php artisan db:seed
```

#### 8. **Iniciar Servidor de Desarrollo**
```bash
# Servidor Laravel (puerto 8000)
php artisan serve

# En otra terminal, si necesitas watch para desarrollo
npm run dev
```

### 🔧 Configuración Adicional

#### **Configurar Subida de Archivos**
En `php.ini`, verificar:
```ini
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
```

#### **Configurar Directorio de Uploads**
```bash
# Crear directorios necesarios
mkdir -p storage/app/public/materiales
mkdir -p storage/app/public/avatars
chmod -R 775 storage/app/public
```

### 🧪 Verificación de Instalación

#### **Comandos de Verificación**
```bash
# Verificar estado de la aplicación
php artisan about

# Verificar rutas
php artisan route:list

# Limpiar cache si es necesario
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### **Acceso al Sistema**
- URL: `http://localhost:8000`
- Panel de Admin: `http://localhost:8000/admin/dashboard`
- Login: `http://localhost:8000/login`

## 👨‍💻 Usuarios de Prueba

Después de ejecutar `php artisan db:seed`, tendrás estos usuarios disponibles:

| Rol | Email | Contraseña | Funcionalidades Principales |
|-----|-------|------------|------------------------------|
| **Admin** | admin@cokito.com | admin123 | Control total, gestión de usuarios, cursos, ciclos y reportes |
| **Docente** | docente@cokito.com | docente123 | Gestión de cursos asignados, materiales y videos |
| **Secretaria** | secretaria@cokito.com | secretaria123 | Procesamiento de matrículas y pagos |
| **Estudiante** | estudiante@cokito.com | estudiante123 | Acceso a cursos, materiales y videos |

### 📋 Datos Adicionales de Seeders
- **11 Cursos** pre-cargados (HTML, JavaScript, React, PHP, Python, etc.)
- **17 Materiales** educativos distribuidos por curso
- **5 Trabajadores** (docentes) asignados a diferentes cursos
- **3 Ciclos** académicos configurados
- **Estructura completa** de relaciones entre entidades

## 🎯 Funcionalidades Detalladas por Rol

### 👨‍💼 Administrador
- **Dashboard Completo**: Métricas de usuarios, estudiantes, cursos y matrículas
- **Gestión de Usuarios**: CRUD completo con validaciones
- **Gestión de Cursos**: Creación, edición, asignación de docentes
- **Gestión de Ciclos**: Organización temporal de cursos
- **Gestión de Estudiantes**: Registro, matriculación, seguimiento
- **Gestión de Trabajadores**: Docentes y personal administrativo
- **Reportes Avanzados**: Estadísticas y métricas del sistema

### 👨‍🏫 Docente  
- **Dashboard Personalizado**: Cursos asignados, estudiantes y materiales
- **Gestión de Materiales**: Subida, organización y control de visibilidad
- **Gestión de Videos**: Integración completa con YouTube
- **Gestión de Estudiantes**: Visualización de estudiantes matriculados
- **Sesiones y Evaluaciones**: Control de progreso académico
- **Interface Moderna**: Drag & drop, previsualizaciones en tiempo real

### 👩‍💼 Secretaria
- **Dashboard de Matrículas**: Pendientes, completadas y métricas
- **Gestión de Inscripciones**: Procesamiento completo de matrículas
- **Gestión de Estudiantes**: Registro, edición y seguimiento
- **Gestión de Pagos**: Control de pagos y métodos
- **Reportes de Recaudación**: Estadísticas financieras

### 🎓 Estudiante
- **Dashboard Personal**: Progreso individual y cursos activos
- **Mis Cursos**: Acceso a cursos matriculados con seguimiento
- **Materiales**: Descarga segura de archivos educativos
- **Videos**: Visualización de contenido multimedia
- **Progreso**: Seguimiento detallado de avance académico

## 🔐 Seguridad y Validaciones

### **Autenticación y Autorización**
- Passwords hasheados con `bcrypt`
- Middleware personalizado `RoleMiddleware` para protección de rutas
- Validación de sesiones y tokens CSRF
- Redirección automática según permisos de rol

### **Validación de Archivos**
- Tipos permitidos: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, JPG, JPEG, PNG, GIF, MP4, AVI, MOV
- Tamaño máximo: 50MB por archivo
- Validación de extensiones y MIME types
- Almacenamiento seguro en `storage/app/public/materiales`

### **Validación de URLs de YouTube**
- Extracción automática de ID de video
- Validación de formatos: `youtube.com/watch?v=` y `youtu.be/`
- Prevención de URLs maliciosas
- Verificación de existencia de videos

## 📱 Diseño Responsive y Moderno

### **Mobile-First Approach**
- Sidebar colapsible automático en móviles
- Grids adaptativos con `minmax()` y `auto-fit`
- Componentes escalables y touch-friendly
- Navegación optimizada para dispositivos móviles

### **Sistema de Diseño Consistente**
- Variables CSS personalizadas para colores y espaciado
- Paleta moderna: morados, azules y acentos
- Efectos glassmorphism y gradientes suaves
- Animaciones y transiciones fluidas
- Contraste optimizado para accesibilidad

## 🛠️ Arquitectura Técnica

### **Backend (Laravel 11)**
- **Models**: Usuario, Trabajador, Estudiante, Curso, Material, Video, Matricula
- **Controllers**: Organizados por roles (Admin, Docente, Secretaria, Estudiante)
- **Middleware**: RoleMiddleware personalizado para autorización
- **Migrations**: Estructura completa de base de datos con relaciones
- **Seeders**: Datos de prueba comprehensive

### **Frontend**
- **CSS Puro**: Sin frameworks, variables CSS personalizadas
- **JavaScript Vanilla**: Funcionalidades drag & drop, previsualizaciones
- **Blade Templates**: Plantillas organizadas por roles y funcionalidades
- **Responsive Design**: Mobile-first con breakpoints optimizados

### **Base de Datos**
- **MySQL 8.0+**: Optimizada para relaciones complejas
- **Indices**: Optimización de consultas frecuentes
- **Foreign Keys**: Integridad referencial completa
- **Soft Deletes**: Preservación de datos históricos

## 🚨 Solución de Problemas Comunes

### **Error: Permission Denied**
```bash
# Linux/Mac
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Windows (ejecutar como administrador)
icacls storage /grant Everyone:F /t
icacls bootstrap/cache /grant Everyone:F /t
```

### **Error: Storage Link**
```bash
# Si el enlace falla
rm public/storage
php artisan storage:link
```

### **Error: Composer Dependencies**
```bash
# Limpiar y reinstalar
rm -rf vendor composer.lock
composer install
```

### **Error: NPM/Node**
```bash
# Limpiar cache de npm
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

### **Error: Base de Datos**
```bash
# Refrescar migraciones
php artisan migrate:fresh --seed
```

## 📝 Notas de Desarrollo

### **Comandos Útiles**
```bash
# Limpiar cache completo
php artisan optimize:clear

# Generar cache para producción
php artisan optimize

# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Debugging de rutas
php artisan route:list --path=admin

# Verificar configuración
php artisan config:show database
```

### **Estructura de Directorios Importantes**
```
academia-cokito/
├── app/Http/Controllers/
│   ├── Admin/           # Controladores de administrador
│   ├── Docente/         # Controladores de docente
│   ├── Secretaria/      # Controladores de secretaria
│   └── Estudiante/      # Controladores de estudiante
├── resources/views/
│   ├── admin/           # Vistas de administrador
│   ├── docente/         # Vistas de docente
│   ├── secretaria/      # Vistas de secretaria
│   ├── estudiante/      # Vistas de estudiante
│   └── layouts/         # Plantillas base
├── storage/app/public/
│   ├── materiales/      # Archivos educativos
│   └── avatars/         # Fotos de perfil
└── database/
    ├── migrations/      # Esquema de base de datos
    └── seeders/         # Datos de prueba
```

## 🤝 Contribución

### **Guías de Desarrollo**
1. Fork el repositorio
2. Crear rama de feature: `git checkout -b feature/nueva-funcionalidad`
3. Commit cambios: `git commit -m 'Añadir nueva funcionalidad'`
4. Push a la rama: `git push origin feature/nueva-funcionalidad`
5. Crear Pull Request

### **Estándares de Código**
- **PSR-4** para autoloading
- **PSR-12** para estilo de código
- **Convención Laravel** para nombres de métodos y variables
- **Comentarios en español** para documentación

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👨‍💻 Créditos

- **Framework**: Laravel 11
- **Diseño**: Sistema personalizado con CSS moderno
- **Iconos**: Emojis nativos para mejor compatibilidad
- **Desarrollo**: Sistema integral para gestión académica

---

**COKITO+ Academia** - Transformando la educación con tecnología moderna 🎓✨

*Versión 1.0.0 - Sistema completo de gestión académica con roles avanzados, integración multimedia y diseño responsive.*
