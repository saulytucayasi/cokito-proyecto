# 🎓 COKITO+ Academia - Sistema de Gestión Académica

Sistema completo de gestión académica desarrollado con Laravel, diseñado específicamente para instituciones educativas modernas.

## 🚀 Características Principales

### ✅ Autenticación Personalizada
- Sistema de login/logout sin Breeze o Spatie
- Control de roles basado en campo `rol` de tabla `usuario`
- Redirección automática según rol después del login
- Recuperación de contraseña por email

### 👥 Sistema de Roles
- **Admin**: Control total del sistema, gestión de usuarios, cursos y reportes
- **Docente**: Gestión de cursos, estudiantes, materiales y videos
- **Secretaria**: Procesamiento de matrículas, gestión de pagos y estudiantes  
- **Estudiante**: Acceso a cursos, materiales, videos y seguimiento de progreso

### 📊 Dashboards Especializados
- Dashboard personalizado para cada rol con métricas relevantes
- Widgets interactivos con estadísticas en tiempo real
- Accesos rápidos a funcionalidades principales

### 📁 Sistema de Archivos
- Subida de materiales (PDF, DOC, DOCX, JPG, PNG, MP4, AVI)
- Validación de archivos hasta 10MB
- Organización por curso y orden
- Descarga segura con middleware de autenticación
- Interfaz drag & drop para mejor UX

### 🎥 Integración YouTube
- Gestión de videos educativos por curso
- Extracción automática de ID de YouTube
- Thumbnails automáticos
- Videos embebidos responsivos
- Organización por orden y estado

### 🎨 Diseño Moderno
- CSS personalizado inspirado en prototipos COKITO+
- Variables CSS para consistencia visual
- Diseño responsive mobile-first
- Componentes modernos con glassmorphism
- Gradientes y efectos visuales avanzados

## 🛠️ Instalación

### Prerrequisitos
```bash
- PHP 8.1+
- Composer
- MySQL 8.0+
- Node.js 16+
- npm
```

### Pasos de Instalación

1. **Instalar dependencias PHP**
```bash
composer install
```

2. **Instalar dependencias Node.js**
```bash
npm install
npm run build
```

3. **Configurar base de datos**
```bash
# Crear base de datos MySQL
mysql -u root -p -e "CREATE DATABASE academia_cokito;"
```

4. **Configurar .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=academia_cokito
DB_USERNAME=root
DB_PASSWORD=tu_password
```

5. **Ejecutar migraciones y seeders**
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

6. **Iniciar servidor**
```bash
php artisan serve
```

## 👨‍💻 Usuarios de Prueba

| Rol | Email | Contraseña | Descripción |
|-----|-------|------------|-------------|
| Admin | admin@cokito.com | admin123 | Control total del sistema |
| Docente | docente@cokito.com | docente123 | Gestión de cursos y materiales |
| Secretaria | secretaria@cokito.com | secretaria123 | Procesamiento de matrículas |
| Estudiante | estudiante@cokito.com | estudiante123 | Acceso a cursos y materiales |

## 🎯 Funcionalidades por Rol

### 👨‍💼 Administrador
- Dashboard con métricas generales
- CRUD completo de usuarios, cursos, ciclos
- Gestión de estudiantes y matrículas
- Reportes avanzados del sistema

### 👨‍🏫 Docente  
- Dashboard con cursos asignados
- Gestión de materiales educativos
- Administración de videos YouTube
- Calificación de estudiantes

### 👩‍💼 Secretaria
- Dashboard con matrículas pendientes
- Procesamiento de nuevas inscripciones
- Gestión de pagos y métodos
- Reportes de recaudación

### 🎓 Estudiante
- Dashboard personal con progreso
- Acceso a cursos matriculados
- Descarga de materiales
- Visualización de videos

## 🔒 Seguridad
- Passwords hasheados con bcrypt
- Middleware de roles personalizado
- Validación de archivos subidos
- Protección CSRF en formularios

## 📱 Responsive Design
- Mobile-first approach
- Sidebar colapsible
- Componentes escalables
- Grids adaptables

---

**COKITO+ Academia** - Transformando la educación con tecnología moderna 🎓✨
