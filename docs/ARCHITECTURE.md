# Arquitectura técnica – Sistema Integral de Gestión (SIG) Funeraria

## 1. Arquitectura lógica (3 capas)

```
┌─────────────────────────────────────────────────────────────────────────┐
│  CAPA DE PRESENTACIÓN                                                    │
│  • Rutas (web, admin, cliente, api)                                      │
│  • Controllers (HTTP API / acciones que no requieran reactividad)        │
│  • Livewire (listados con filtros, formularios complejos, estado UI)      │
│  • Blade / componentes de vista                                          │
│  • Form Requests (validación entrada)                                   │
│  • Policies (autorización vista/acción)                                  │
└─────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────┐
│  CAPA DE LÓGICA DE NEGOCIO                                               │
│  • Services (orquestación, reglas de negocio, transacciones)             │
│  • DTOs/Value Objects (opcional, para datos complejos entre capas)        │
│  • Events (dominio: PlanCreado, PagoAprobado, etc.)                      │
│  • Listeners (reacción: notificar, logs, reportes)                       │
│  • Jobs (tareas asíncronas: PDF, emails, WhatsApp, reportes)             │
└─────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────┐
│  CAPA DE PERSISTENCIA                                                    │
│  • Repositories (interfaces en Contracts, implementación Eloquent)       │
│  • Models (Eloquent, relaciones, scopes, casts)                          │
│  • Migraciones / DB                                                      │
└─────────────────────────────────────────────────────────────────────────┘
```

**Flujo estándar:**  
`Request → Controller/Livewire → Form Request (validar) → Policy (autorizar) → Service → Repository → Model → DB`  
Los **Services** no conocen HTTP ni Livewire; reciben datos simples y devuelven resultados o excepciones de dominio.

---

## 2. Módulos del sistema (lista completa)

| Módulo | Descripción | ADMIN | CLIENTE | API | Eventos/Jobs |
|--------|-------------|-------|---------|-----|--------------|
| **Usuarios** | CRUD usuarios, roles, perfil | ✓ | — | — | UserCreado, UserActualizado |
| **Afiliados** | Afiliación a planes, estado, asesor | ✓ | ver propio | — | AfiliadoCreado, AfiliadoActualizado |
| **Planes Exequiales** | CRUD planes, precios, servicios incluidos | ✓ | solo lectura (público) | lectura | PlanCreado, PlanActualizado |
| **Beneficiarios** | Por afiliado, datos y documentos | ✓ | CRUD propios | — | BeneficiarioCreado |
| **Servicios Funerarios** | Solicitud y coordinación de servicios | ✓ | solicitar/ver | — | ServicioSolicitado, ServicioProgramado |
| **Reservas** | Salas, fechas, vehículos | ✓ | solicitar/ver | — | ReservaCreada, RecordatorioReserva |
| **Pagos** | Pagos, cuotas, integración Wompi/Bancolombia/Nequi | ✓ | ver/pagar | webhooks | PagoRecibido, PagoFallido, PagoAprobado (Jobs) |
| **Inventario** | Productos, urnas, insumos | ✓ | — | — | StockBajo (Listener → notificación) |
| **Vehículos** | Flota, mantenimientos, conductores | ✓ | — | — | MantenimientoProgramado |
| **Salas de velación** | Salas, disponibilidad | ✓ | ver disponibilidad | — | — |
| **Obituarios** | Publicación, condolencias | ✓ | CRUD | lectura pública | ObituarioPublicado (→ notificación) |
| **PQR** | Peticiones, quejas, reclamos | ✓ | CRUD (propios) | — | PQRCreada, PQRRespondida |
| **Notificaciones** | Email, WhatsApp, in-app | ✓ | ✓ | — | Listeners + Jobs (SendEmail, SendWhatsApp) |
| **Reportes** | PDF, Excel, dashboards | ✓ | limitado (propios) | — | Jobs (GenerateReportPdf, ExportExcel) |
| **Configuración** | Parámetros negocio, integraciones | ✓ | — | — | ConfigActualizada |
| **Logs / Auditoría** | Log de acciones críticas | ✓ | — | — | LogSistema (Listener) |

---

## 3. Estructura Controller → Service → Repository

- **Controller / Livewire:** solo recibe request, valida (Form Request), autoriza (Policy), llama al **Service** y devuelve respuesta (redirect, JSON, vista).
- **Service:** aplica reglas de negocio, coordina repositorios, dispara eventos, encola jobs. No conoce HTTP ni Blade.
- **Repository:** implementa interfaz en `App\Contracts\Repositories`. Métodos: `find`, `findOrFail`, `getList`, `create`, `update`, `delete`, y específicos por módulo (ej. `getActivos`, `getByAfiliado`). El **Service** depende de la interfaz, no del Eloquent concreto.

**Inyección:** Service recibe `PlanExequialRepositoryInterface` en el constructor; en `AppServiceProvider` o `RepositoryServiceProvider` se hace el bind a `PlanExequialRepository`.

---

## 4. Uso de Events, Listeners y Jobs

### Events (dominio)

- `PlanExequialCreado`, `PlanExequialActualizado`
- `AfiliadoCreado`, `AfiliadoActualizado`
- `PagoRegistrado`, `PagoAprobado`, `PagoFallido`
- `ServicioFunerarioSolicitado`, `ServicioFunerarioProgramado`
- `ReservaCreada`, `ReservaConfirmada`
- `ObituarioPublicado`
- `PQRCreada`, `PQRRespondida`
- `UsuarioCreado`, `UsuarioActualizado`

### Listeners (reacción inmediata o encolar Job)

- `PlanExequialCreado` → log auditoría, opcional notificación interna.
- `PagoAprobado` → actualizar estado afiliado/beneficiario, enviar comprobante (Job).
- `PagoFallido` → notificar al usuario (Job).
- `ObituarioPublicado` → enviar notificación / WhatsApp (Job).
- `PQRCreada` → notificar a administración (Job).
- `StockBajo` (desde servicio de inventario) → notificación o alerta (Job).

### Jobs (siempre en Queue)

- `EnviarComprobantePago`, `EnviarNotificacionWhatsApp`, `EnviarEmailNotificacion`
- `GenerarReportePdf`, `ExportarReporteExcel`
- `ProcesarWebhookPago` (Wompi/Bancolombia)
- `SincronizarDatosExternos` (si aplica Analytics u otros)
- `RegistrarLogSistema` (si se decide auditoría asíncrona)

**Regla:** toda salida al exterior (email, WhatsApp, PDF, llamada HTTP a pasarela) debe ir en **Job** para no bloquear la respuesta al usuario y permitir reintentos.

---

## 5. Policies y Form Requests

### Policies

- `PlanExequialPolicy`: solo admin puede create/update/delete; cliente y guest solo view (si aplica).
- `AfiliadoPolicy`: admin todo; cliente solo ver/actualizar el suyo (por user_id/afiliado_id).
- `BeneficiarioPolicy`: admin todo; cliente solo los de su afiliado.
- `ServicioFunerarioPolicy`, `ReservaPolicy`, `PagoPolicy`: mismo criterio (admin vs dueño del recurso).
- `ObituarioPolicy`: admin CRUD; cliente solo creación/edición de los propios o según regla de negocio.
- `PQRPolicy`: admin responder; cliente crear y ver los suyos.
- `UserPolicy`: solo admin gestiona usuarios.

En Livewire/Controller: `$this->authorize('update', $plan);` usando la policy correspondiente.

### Form Requests

- Un Form Request por acción de escritura donde la validación sea relevante:  
  `StorePlanExequialRequest`, `UpdatePlanExequialRequest`, `StoreAfiliadoRequest`, `StorePagoRequest`, etc.
- En Livewire se puede reutilizar la misma regla llamando al Form Request desde el componente o extrayendo las reglas a un método estático / objeto de validación usado por ambos.

---

## 6. Flujo por rol

### ADMIN

1. Login → redirección a `/admin/dashboard`.
2. Dashboard: métricas (afiliados, pagos del mes, servicios pendientes, PQR sin responder).
3. Módulos: Usuarios, Afiliados, Planes, Beneficiarios (por afiliado), Servicios, Reservas, Pagos, Inventario, Vehículos, Salas, Obituarios, PQR, Reportes (PDF/Excel), Configuración.
4. Acciones críticas (ej. aprobar pago, publicar obituario) pasan por Service + Event/Job; reportes pesados vía Job.

### CLIENTE

1. Login → redirección a `/cliente/dashboard`.
2. Dashboard: mi plan, próximos pagos, mis beneficiarios, último estado de servicios/PQR.
3. Mi plan: ver plan actual, beneficiarios (CRUD propio), solicitar servicios, ver reservas, pagos (historial + pagar con Wompi/Bancolombia/Nequi).
4. Obituarios: ver listado público y, si aplica, solicitar publicación (flujo definido por negocio).
5. Sala virtual: acceso a contenido/streaming según reserva/servicio.
6. PQR: crear y ver sus PQR; no editar respuestas.

Flujo técnico en ambos: **Request → Middleware (auth + role) → Controller/Livewire → authorize(Policy) → Service → Repository → Event/Job si aplica.**

---

## 7. Dónde usar Livewire

- **Sí Livewire:** listados con búsqueda/filtros/paginación (planes, afiliados, pagos, PQR), formularios con estado complejo (crear/editar plan con servicios incluidos, multibeneficiarios), toggles y acciones rápidas (activar/desactivar plan), dashboards con filtros por fecha.
- **No Livewire (Controller + Blade):** páginas estáticas o de solo lectura simple, flujos que deben ser SEO-friendly (obituarios públicos), webhooks de pagos (API pura), descargas de archivos (PDF/Excel vía Controller).

API REST para móvil o terceros: controllers API que llamen a los mismos **Services**; sin Livewire.

---

## 8. Estructura de carpetas recomendada

```
app/
├── Constants/
├── Contracts/
│   └── Repositories/
│       ├── PlanExequialRepositoryInterface.php
│       ├── AfiliadoRepositoryInterface.php
│       └── ...
├── Http/
│   ├── Controllers/
│   │   ├── Api/           # Webhooks, API móvil
│   │   ├── Admin/         # Opcional: acciones admin no Livewire
│   │   └── Cliente/
│   ├── Middleware/
│   └── Requests/
│       ├── Admin/
│       │   ├── PlanExequial/
│       │   │   ├── StorePlanExequialRequest.php
│       │   │   └── UpdatePlanExequialRequest.php
│       │   └── ...
│       └── Cliente/
├── Livewire/
│   ├── Admin/
│   │   ├── Planes/
│   │   ├── Afiliados/
│   │   └── ...
│   └── Cliente/
├── Models/
├── Policies/
├── Providers/
├── Repositories/
│   ├── PlanExequialRepository.php
│   └── ...
├── Services/
│   ├── PlanExequialService.php
│   ├── AfiliadoService.php
│   ├── PagoService.php      # Integración pasarelas
│   └── ...
├── Events/
├── Listeners/
├── Jobs/
└── View/Components/

config/
routes/
database/migrations/
docs/
```

---

## 9. Roadmap por fases

| Fase | Alcance | Entregable |
|------|---------|------------|
| **F1 – Base** | Arquitectura 3 capas, primer módulo completo (Planes) con Service + Repository + Form Request + Policy | Código estable; patrón replicable |
| **F2 – Afiliación** | Afiliados + Beneficiarios (CRUD admin y cliente con políticas) | Flujo afiliación operativo |
| **F3 – Servicios y reservas** | Servicios funerarios, reservas (salas/vehículos), inventario y vehículos básico | Operación día a día |
| **F4 – Pagos** | Integración Wompi/Bancolombia/Nequi, webhooks, estados, comprobantes (Jobs) | Cobro y conciliación |
| **F5 – Comunicación** | Notificaciones (email + WhatsApp), PQR con notificación, obituarios con avisos | Trazabilidad y comunicación |
| **F6 – Reportes y métricas** | Reportes PDF/Excel, dashboard con métricas reales, logs/auditoría | Gestión y auditoría |
| **F7 – Producción** | Seguridad (CORS, rate limit, sanitización), optimización (cache, índices), Docker + CI/CD | Desplegable y mantenible |

---

## 10. Seguridad

- **Auth:** Fortify + Jetstream (ya en uso); 2FA para admin recomendado.
- **Autorización:** Policy en cada acción de modificación/borrado; no confiar solo en rutas.
- **Validación:** Form Requests; en API, sanitización de entrada y salida.
- **Rate limiting:** login, API, webhooks (por IP y por usuario si aplica).
- **SQL/HTML:** Eloquent y Blade escapan por defecto; evitar `raw` sin bindings; no usar `{!! !!}` con datos de usuario.
- **Sensible:** claves de pasarelas y WhatsApp en `.env`; nunca en código; uso de `config()`.
- **HTTPS y cookies:** `SESSION_SECURE_COOKIE=true` en producción; CORS restrictivo en API.
- **Auditoría:** eventos críticos (pagos, cambios de estado, eliminaciones) a `logs_sistema` o similar vía Listener/Job.

---

## 11. Escalabilidad

- **Queue:** Redis o database driver; todos los envíos (email, WhatsApp, PDF, webhooks) en Jobs.
- **Cache:** Redis para sesiones y cache; cachear listados estáticos (planes activos, configuración) con TTL.
- **DB:** índices en filtros frecuentes (fecha, estado, user_id, afiliado_id); revisar N+1 en listados (eager load).
- **Archivos:** almacenamiento en disco/S3 según volumen; no servir PDFs pesados desde PHP en línea.
- **Horizontal:** stateless app; sesión y cache en Redis; colas en worker(s) separados.
- **Monitoring:** logs estructurados, health check `/up`, métricas de cola y tiempo de respuesta (futuro).

---

## 12. Docker y CI/CD

- **Docker:** `Dockerfile` multi-stage (composer + npm build); `docker-compose` con app, MySQL, Redis, queue worker; `.env.docker` o variables de entorno para conexiones.
- **CI:** pipeline (GitHub Actions / GitLab CI) con: `composer install`, `npm ci && npm run build`, `php artisan test`, opcional `php artisan migrate --force` en entorno de staging.
- **CD:** deploy vía script o servicio (pull, `composer install --no-dev`, `php artisan migrate --force`, `php artisan config:cache`, `php artisan queue:restart`); cero-downtime con varios workers si se requiere.

---

*Documento vivo: actualizar al añadir módulos o cambiar decisiones de arquitectura.*
