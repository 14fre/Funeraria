# Estructura del Proyecto - Funeraria San José

## 📁 Estructura de Carpetas Creada

### Backend (PHP/Laravel)

```
app/
├── Constants/
│   └── Roles.php                    # Constantes para roles (admin, cliente)
├── Http/
│   ├── Middleware/
│   │   ├── CheckRole.php            # Middleware para verificar roles específicos
│   │   ├── RoleRedirect.php        # Middleware para redirigir según rol
│   │   └── RedirectIfAuthenticated.php  # Redirige usuarios autenticados
│   └── Kernel.php                   # Registro de middlewares
├── Models/
│   ├── User.php                     # Modelo con métodos helper para roles
│   └── Role.php                     # Modelo de roles
└── View/
    └── Components/
        ├── AdminLayout.php          # Componente layout para admin
        └── ClienteLayout.php        # Componente layout para cliente
```

### Frontend (Vistas)

```
resources/views/
├── admin/
│   ├── layouts/
│   │   └── app.blade.php            # Layout principal del panel admin
│   └── dashboard.blade.php          # Dashboard administrativo
└── cliente/
    ├── layouts/
    │   └── app.blade.php            # Layout principal del portal cliente
    └── dashboard.blade.php          # Dashboard del cliente
```

### Rutas

```
routes/
├── web.php                          # Rutas públicas y carga de rutas adicionales
├── admin.php                        # Todas las rutas del panel administrativo
└── cliente.php                      # Todas las rutas del portal del cliente
```

## 🔐 Sistema de Roles y Middleware

### Constantes de Roles

Se creó la clase `App\Constants\Roles` con:
- `Roles::ADMIN` = 'admin'
- `Roles::CLIENTE` = 'cliente'
- Métodos helper para obtener IDs, nombres y rutas de dashboard

### Middlewares Implementados

1. **`role:admin`** o **`role:cliente`**
   - Verifica que el usuario tenga el rol especificado
   - Uso: `->middleware('role:admin')`

2. **`role.redirect`**
   - Redirige usuarios autenticados a su dashboard según su rol
   - Se usa en rutas públicas (login, register) para evitar acceso duplicado

### Métodos Helper en User Model

```php
$user->hasRole('admin')           // Verifica si tiene un rol específico
$user->isAdmin()                  // Verifica si es administrador
$user->isCliente()                // Verifica si es cliente
$user->getDashboardRoute()        // Obtiene la ruta del dashboard según rol
```

## 🛣️ Sistema de Rutas

### Rutas Públicas
- `/` - Página de inicio

### Rutas de Autenticación
- `/dashboard` - Redirige automáticamente según el rol del usuario

### Rutas del Panel Administrativo (`/admin/*`)
Todas protegidas con `middleware(['auth', 'role:admin'])`

- `/admin/dashboard` - Dashboard principal
- `/admin/usuarios` - Gestión de usuarios
- `/admin/afiliados` - Gestión de afiliados
- `/admin/planes` - Gestión de planes exequiales
- `/admin/servicios` - Gestión de servicios
- `/admin/pagos` - Gestión de pagos
- `/admin/inventario` - Gestión de inventario
- `/admin/vehiculos` - Gestión de vehículos
- `/admin/salas` - Gestión de salas
- `/admin/reservas` - Gestión de reservas
- `/admin/obituarios` - Gestión de obituarios
- `/admin/reportes` - Reportes y estadísticas
- `/admin/configuracion` - Configuración del sistema

### Rutas del Portal del Cliente (`/cliente/*`)
Todas protegidas con `middleware(['auth', 'role:cliente'])`

- `/cliente/dashboard` - Dashboard personal
- `/cliente/plan` - Información del plan
- `/cliente/beneficiarios` - Gestión de beneficiarios
- `/cliente/servicios` - Solicitud y consulta de servicios
- `/cliente/pagos` - Realización de pagos
- `/cliente/obituarios` - Visualización de obituarios
- `/cliente/sala-virtual` - Acceso a sala virtual

## 🎨 Layouts y Componentes

### Layout Administrativo
- **Ubicación**: `resources/views/admin/layouts/app.blade.php`
- **Componente**: `<x-admin-layout>`
- **Características**:
  - Sidebar fijo con navegación completa
  - Colores: Gradiente gris oscuro con acentos dorados
  - Header con información del usuario
  - Diseño responsive

### Layout Cliente
- **Ubicación**: `resources/views/cliente/layouts/app.blade.php`
- **Componente**: `<x-cliente-layout>`
- **Características**:
  - Sidebar fijo con navegación simplificada
  - Colores: Gradiente rojo oscuro con acentos dorados
  - Header con información del usuario
  - Diseño responsive

## 🔄 Flujo de Autenticación

1. Usuario hace login → `FortifyServiceProvider` detecta el rol
2. Redirige automáticamente a:
   - `/admin/dashboard` si es admin
   - `/cliente/dashboard` si es cliente
3. Si intenta acceder a `/dashboard` genérico, redirige según rol
4. Si intenta acceder a login/register estando autenticado, redirige a su dashboard

## 📝 Próximos Pasos Recomendados

1. **Crear Controladores**
   - `app/Http/Controllers/Admin/` - Controladores del panel admin
   - `app/Http/Controllers/Cliente/` - Controladores del portal cliente

2. **Crear Modelos**
   - Modelos para todas las entidades (Afiliado, Plan, Servicio, etc.)

3. **Implementar Livewire Components**
   - Componentes para cada módulo (tablas, formularios, etc.)

4. **Crear Migraciones**
   - Migraciones para todas las tablas del sistema

5. **Implementar Validaciones**
   - Form Requests para validar datos

6. **Agregar Tests**
   - Tests unitarios y de integración

## 🚀 Cómo Usar

### Agregar una nueva ruta de admin:
```php
// En routes/admin.php
Route::prefix('mi-modulo')->name('mi-modulo.')->group(function () {
    Route::get('/', [MiModuloController::class, 'index'])->name('index');
});
```

### Agregar una nueva ruta de cliente:
```php
// En routes/cliente.php
Route::prefix('mi-modulo')->name('mi-modulo.')->group(function () {
    Route::get('/', [MiModuloController::class, 'index'])->name('index');
});
```

### Crear una nueva vista:
```php
// Vista admin
<x-admin-layout>
    <x-slot name="header">
        <h2>Título de la Página</h2>
    </x-slot>
    
    @section('page-title', 'Título de la Página')
    
    <!-- Contenido aquí -->
</x-admin-layout>

// Vista cliente
<x-cliente-layout>
    <x-slot name="header">
        <h2>Título de la Página</h2>
    </x-slot>
    
    @section('page-title', 'Título de la Página')
    
    <!-- Contenido aquí -->
</x-cliente-layout>
```

## ✅ Características Implementadas

- ✅ Sistema de roles escalable
- ✅ Middlewares para protección de rutas
- ✅ Redirección automática según rol
- ✅ Layouts separados para admin y cliente
- ✅ Dashboards básicos funcionales
- ✅ Estructura de rutas organizada y escalable
- ✅ Helpers en modelo User para roles
- ✅ Constantes para roles (fácil de extender)

---

**Nota**: Esta estructura está diseñada para ser escalable y fácil de mantener. Cada módulo puede desarrollarse de forma independiente siguiendo los patrones establecidos.

