# Auditoría técnica – Estado actual del sistema (Funeraria San José)

**Fecha de revisión:** Febrero 2026  
**Alcance:** Lógica, arquitectura, paneles admin/cliente, funcionalidades faltantes y plan de desarrollo.

---

## 1. Diagnóstico del estado actual del sistema

### 1.1 Stack y estructura general

- **Framework:** Laravel (Jetstream + Fortify), Livewire en el panel admin.
- **Autenticación:** Fortify con 2FA (TOTP y por correo), roles `admin` / `cliente`.
- **Base de datos:** Migraciones para usuarios, roles, afiliados, beneficiarios, planes, servicios funerarios, pagos, reservas, inventario, vehículos, salas de velación, obituarios, solicitudes de afiliación, PQR, condolencias, logs, configuración.

El proyecto tiene una **base sólida**: separación por roles, rutas admin/cliente bien delimitadas, uso de servicios y repositorios en la mayoría de los módulos, políticas de autorización en Livewire y formularios con Form Requests donde aplica.

### 1.2 Lo que está bien implementado

| Área | Estado | Comentario |
|------|--------|------------|
| **Autenticación y roles** | ✅ | Login por rol, redirección a dashboard correcta, middleware `CheckRole` sin 403 innecesarios. |
| **Solicitudes de afiliación** | ✅ | Flujo completo: cliente solicita → admin aprueba/rechaza → se crea afiliado al aprobar. |
| **CRUD Admin (Livewire)** | ✅ | Afiliados, beneficiarios, planes, servicios, inventario, vehículos, salas, reservas, obituarios, usuarios con servicios/repositorios y políticas. |
| **Contabilidad (Finanzas)** | ✅ | Resumen por mes, tendencia 12 meses, reporte mensual/anual, selector de período, saneamiento de parámetros. |
| **Panel cliente – flujo base** | ✅ | Dashboard, solicitar afiliación, mi plan, beneficiarios (CRUD), servicios (solicitud), listado de pagos, perfil. |
| **Página pública** | ✅ | Inicio, servicios, planes, obituarios (listado + detalle), quiénes somos, contacto, sedes con enlace a Google Maps. |
| **2FA y correos** | ✅ | 2FA por correo, plantilla de correo unificada, restablecer contraseña con vista personalizada. |
| **Caché en sesión** | ✅ | Middleware para no cachear páginas autenticadas (evitar “atrás” con datos viejos). |

### 1.3 Inconsistencias y puntos débiles

- **Registro de pagos:** No existe en ninguna parte del código un `Pago::create()` ni flujo que registre pagos. La contabilidad lee pagos ya existentes (probablemente cargados a mano o por un proceso externo). El cliente ve “Realizar pago” pero es solo un placeholder (mensaje de “próximamente Wompi/Bancolombia”).
- **Formulario de contacto:** `action="#"` y sin ruta POST: no guarda ni envía correos. Es solo maquetación.
- **Módulos admin placeholder:** Pagos, Reportes y Configuración son vistas con mensaje “en desarrollo” sin lógica.
- **Contabilidad sin capa de servicio:** Contabilidad usa directamente `Pago` y `User` en el controlador. El resto del admin usa Service/Repository; conviene homogeneizar.
- **Cliente – Obituarios:** La ruta `cliente/obituarios/{id}` usa `$id` y vista genérica; no hay enlace real con el modelo `Obituario` ni filtro “mis servicios”.
- **Cliente – Sala virtual:** Solo texto informativo; no hay enlaces a transmisiones ni relación con servicios/velaciones.
- **Notificación post-afiliación:** Al aprobar una solicitud de afiliación no se envía correo ni notificación al usuario.
- **Modelos sin uso en flujos:** PQR, Condolencia, LogSistema, Configuracion tienen modelo y relaciones pero no hay módulos ni pantallas que los usen.
- **Roles hardcodeados:** `Roles::getId()` asume `admin=1`, `cliente=2`. Si se cambian IDs en BD, falla. Mejor resolver por nombre o usar constantes/seed.

---

## 2. Análisis de arquitectura

### 2.1 Organización del código

- **Rutas:** Bien separadas en `web.php`, `admin.php`, `cliente.php`. Admin y cliente bajo middleware `role:admin` y `role:cliente`.
- **Controladores:** Solo `ContabilidadController` y `DashboardController` en Admin; el resto de pantallas admin son closures en rutas que devuelven vistas y delegan lógica a Livewire.
- **Livewire:** Componentes en `App\Livewire\Admin\*` para listados y formularios; usan Services y Policies.
- **Servicios y repositorios:** Interfaces en `Contracts\Repositories`, implementaciones en `Repositories`, inyección en `AppServiceProvider`. Servicios (AfiliadoService, PlanExequialService, etc.) orquestan y validan; repositorios acceden a datos.
- **Políticas:** Definidas para Afiliado, Beneficiario, PlanExequial, ServicioFunerario, Inventario, SalaVelacion, Reserva, Obituario, Vehiculo. Livewire llama `$this->authorize()` en render y acciones.

**Conclusión:** La arquitectura es clara y escalable. La mezcla de “rutas con closures + Livewire” en admin es aceptable pero genera bastante lógica en `admin.php` (solicitudes de afiliación, dashboard cliente). A medio plazo conviene extraer a controladores dedicados.

### 2.2 Mejoras estructurales recomendadas

1. **Extraer lógica de rutas a controladores**  
   Solicitudes de afiliación (aprobar/rechazar) y dashboard cliente tienen validaciones y creación de afiliado en closures. Mover a `SolicitudAfiliacionController` y a un `Cliente\DashboardController` (o similar) para tests y reutilización.

2. **Contabilidad**  
   Introducir un `ContabilidadService` (o `PagoService`) que encapsule consultas de entradas, tendencias y datos para reportes. El controlador solo pide datos al servicio y devuelve vistas.

3. **Registro de pagos**  
   Cuando exista flujo de pagos (manual o pasarela), crear un `PagoService` con `registrarPago()` y usarlo desde admin y, si aplica, desde webhooks de la pasarela.

4. **Formulario de contacto**  
   Crear ruta POST, controlador o acción que valide, guarde (tabla `contacto` o similar) y/o envíe correo. No dejar `action="#"`.

---

## 3. Revisión de lógica y buenas prácticas

### 3.1 Lógica actual

- **AfiliadoService:** Valida usuario no afiliado y genera `numero_afiliacion`; lógica correcta.
- **Aprobación de solicitud:** Se comprueba estado `pendiente` y que el usuario no tenga ya afiliado; se crea afiliado vía servicio. Correcto. Falta notificación al usuario.
- **Contabilidad:** Saneamiento de `mes`/`anio` evita inyección de parámetros; consultas por rangos de fechas correctas.
- **Cliente – creación de beneficiario/servicio:** Validación `afiliado_id` con `in:$afiliado->id` y uso de servicios; correcto.

### 3.2 Posibles errores o mejoras

- **Cliente obituarios show:** Ruta `cliente/obituarios/{id}` con `$id` genérico: no hay comprobación de que el obituario corresponda al usuario o a un servicio del afiliado. Si se implementa detalle, usar route model binding y autorización (policy o comprobación por relación).
- **Rate limiting:** Definido en `AppServiceProvider` para login y two-factor; adecuado. Revisar si conviene límite para “enviar código por correo” y “restablecer contraseña”.
- **Políticas:** Cliente tiene `view`/`update` en Afiliado solo para su propio afiliado; las rutas cliente ya están protegidas por middleware, pero las políticas dan una capa extra si en el futuro se exponen APIs o más rutas.

### 3.3 Seguridad básica

- Rutas admin/cliente protegidas por `auth` y `role`.
- Contraseñas hasheadas, 2FA disponible.
- CSRF en formularios (Blade).
- No se observan consultas con raw SQL sin bindings; uso normal de Eloquent.
- **Recomendación:** Revisar que en producción no se expongan rutas de debug ni `APP_DEBUG=true`.

### 3.4 Escalabilidad

- Uso de paginación en listados Livewire.
- Contabilidad con consultas por rango de fechas e índices en `pagos` (migración).
- **Recomendación:** Si el volumen de pagos crece, valorar caché para resúmenes mensuales o jobs para reportes pesados.

---

## 4. Evaluación de los paneles

### 4.1 Panel de administrador

| Módulo | Estado | Observación |
|--------|--------|-------------|
| Dashboard | ✅ | Vista con resumen. |
| Perfil | ✅ | Foto, 2FA, contraseña. |
| Usuarios | ✅ | CRUD Livewire. |
| Solicitudes afiliación | ✅ | Listado pendientes/aprobadas/rechazadas, aprobar/rechazar. Falta notificación al aprobar. |
| Afiliados | ✅ | CRUD completo. |
| Beneficiarios | ✅ | CRUD completo. |
| Planes exequiales | ✅ | CRUD + show. |
| Servicios funerarios | ✅ | CRUD. |
| Pagos | ⚠️ Placeholder | Solo mensaje “en desarrollo”. No hay listado ni registro de pagos. |
| Inventario | ✅ | CRUD. |
| Vehículos | ✅ | CRUD. |
| Salas de velación | ✅ | CRUD. |
| Reservas | ✅ | Listado, filtros, eliminar. |
| Obituarios | ✅ | CRUD. |
| Reportes | ⚠️ Placeholder | Mensaje “en desarrollo”. |
| Contabilidad (Finanzas) | ✅ | Resumen, gráficos, reporte mensual/anual. |
| Configuración | ⚠️ Placeholder | Mensaje “en desarrollo”. |

**Funcionalidades faltantes en admin (prioritarias para una funeraria):**

- **Registro y gestión de pagos:** Alta de pagos manual (fecha, monto, afiliado, estado, referencia) y listado con filtros; aprobación/anulación. Sin esto, la contabilidad depende de datos externos.
- **Notificación al aprobar afiliación:** Email al usuario indicando que fue aprobado y que puede acceder a su plan.
- **Gestión de estados de servicios funerarios:** Flujo claro (solicitado → programado → en proceso → realizado) y, si aplica, asignación de coordinador/sala.
- **Configuración mínima:** Uso del modelo `Configuracion` para datos de negocio (nombre funeraria, teléfonos, email, WhatsApp) editables desde el panel.
- **PQR (Peticiones, Quejas, Reclamos):** Si el modelo existe, al menos listado y cambio de estado “respondido” con texto de respuesta.
- **Reportes:** Al menos un reporte útil (por ejemplo afiliados por plan, servicios por período) en PDF/Excel usando la misma línea visual que los reportes de contabilidad.

### 4.2 Panel de cliente

| Funcionalidad | Estado | Observación |
|---------------|--------|-------------|
| Dashboard | ✅ | Muestra afiliado, beneficiarios, próximo pago. |
| Solicitar afiliación | ✅ | Formulario y envío correctos. |
| Mi plan | ✅ | Muestra plan y estado de solicitud si aplica. |
| Beneficiarios | ✅ | Alta desde cliente con validación. |
| Servicios | ✅ | Solicitud de servicio (tipo, beneficiario, observaciones). |
| Pagos – listado | ✅ | Histórico de pagos del afiliado. |
| Pagos – realizar | ⚠️ Placeholder | Sin pasarela ni registro de pago. |
| Obituarios | ⚠️ | Redirige a obituarios públicos; no integrado con “mis servicios”. |
| Sala virtual | ⚠️ Placeholder | Solo mensaje; sin enlaces ni lógica. |
| Perfil | ✅ | Foto, datos, contraseña, 2FA. |

**Recomendaciones cliente:**

- Mantener “Realizar pago” como placeholder hasta tener pasarela; opcionalmente mostrar instrucciones de pago (transferencia, referencia) y que admin registre el pago manualmente.
- Cuando exista flujo de velación virtual, mostrar en “Sala virtual” el enlace cuando el cliente tenga un servicio con ese tipo asignado.

---

## 5. Funcionalidades faltantes (resumen)

- **Críticas para operación**
  - Registro de pagos en admin (alta manual + listado + filtros).
  - Formulario de contacto funcional (guardar y/o enviar correo).
  - Notificación al usuario cuando se aprueba su solicitud de afiliación.

- **Importantes para un sistema de gestión funeraria**
  - Módulo de configuración (uso de `Configuracion` o similar).
  - Flujo de estados de servicios funerarios y asignación de coordinador/sala.
  - Módulo PQR (listado, respuesta, estado).
  - Al menos un reporte descargable (afiliados, servicios o similar) con el mismo estilo que los reportes de contabilidad.

- **Opcionales / mejoras**
  - Condolencias en obituarios (el modelo existe; falta vista y aprobación).
  - Logs de sistema (uso de `LogSistema` para acciones sensibles).
  - Egresos en contabilidad (si el negocio lo requiere).
  - Integración con pasarela de pagos (Wompi/Bancolombia/Nequi) y registro automático de pago.

---

## 6. Mejoras técnicas recomendadas

1. **Unificar capa de datos en Contabilidad:** Crear `ContabilidadService` o `PagoService` para consultas de entradas y reportes; controlador solo orquesta y devuelve vistas.
2. **Extraer lógica de rutas a controladores:** Solicitudes de afiliación y dashboard cliente en controladores para facilitar tests y mantenimiento.
3. **Formulario de contacto:** Ruta POST, validación, guardado en BD y/o envío de correo; vista de éxito/error.
4. **Notificación al aprobar afiliación:** Evento o llamada directa a notificación por correo al actualizar solicitud a “aprobada”.
5. **Cliente obituarios:** Si se mantiene ruta de detalle, usar `Obituario` con route model binding y policy o comprobación de visibilidad.
6. **Roles:** Evitar depender de IDs fijos; usar nombres de rol o seeds documentados y constantes.
7. **Tests:** Añadir tests unitarios para AfiliadoService, aprobación de solicitud y, cuando exista, PagoService/ContabilidadService.

---

## 7. Plan de desarrollo priorizado

### Fase 1 – Estabilizar y cerrar flujos básicos (corto plazo)

1. **Formulario de contacto funcional**  
   Ruta POST, validación, guardar en tabla `contactos` o similar y enviar correo a la funeraria. Bajo esfuerzo, alto impacto.

2. **Registro de pagos en admin**  
   Pantalla para alta manual de pago (afiliado, monto, fecha, método, estado, referencia) y listado con filtros; opcionalmente “aprobar” desde listado. Permite que contabilidad refleje la realidad sin depender de datos externos.

3. **Notificación al aprobar afiliación**  
   Al marcar solicitud como aprobada, enviar correo al usuario (plantilla existente) indicando que puede acceder a su plan.

### Fase 2 – Módulos administrativos (medio plazo)

4. **Configuración básica**  
   Vista admin que liste/edite claves del modelo `Configuracion` (nombre, teléfonos, email, WhatsApp). Usar estos valores en footer, contacto y enlaces.

5. **Pagos – listado y filtros en admin**  
   Si en Fase 1 solo se hizo “alta”, completar con listado paginado, filtros por afiliado, estado, rango de fechas y opción de anular/editar estado.

6. **PQR**  
   Listado de PQR con estado; formulario de respuesta y marcar como “respondido”. Opcional: que el cliente envíe PQR desde su panel.

### Fase 3 – Reportes y servicios (medio plazo)

7. **Reportes descargables**  
   Al menos un reporte (afiliados por plan o servicios por período) en PDF/Excel, reutilizando el estilo de los reportes de contabilidad.

8. **Flujo de estados de servicios funerarios**  
   Definir estados y transiciones; pantalla para asignar coordinador, sala, fecha/hora; que el cliente vea estado de su solicitud.

### Fase 4 – Refactor y mejoras (cuando haya tiempo)

9. **Contabilidad con servicio**  
   Extraer lógica del `ContabilidadController` a `ContabilidadService` o `PagoService`.

10. **Controladores para solicitudes y dashboard cliente**  
    Mover lógica de `admin.php` y `cliente.php` a controladores.

11. **Sala virtual y obituarios cliente**  
    Enlazar sala virtual a servicios con velación virtual; en obituarios cliente, opcionalmente filtrar por “mis servicios” o mantener solo enlace a sitio público.

12. **Pasarela de pagos (opcional)**  
    Integración con Wompi/Bancolombia/Nequi; webhook que cree/actualice `Pago` y notifique al cliente.

---

## 8. Resumen ejecutivo

| Aspecto | Valoración | Comentario |
|---------|------------|------------|
| Arquitectura | Buena | Servicios, repositorios, políticas; Contabilidad y contacto desalineados. |
| Lógica actual | Correcta | Flujos de afiliación y cliente coherentes; falta registro de pagos y contacto. |
| Panel admin | Muy completo en CRUD | Faltan pagos reales, reportes, configuración y PQR. |
| Panel cliente | Funcional en lo básico | Pagos “realizar” y sala virtual son placeholders. |
| Seguridad | Adecuada | Roles, 2FA, middleware; revisar configuración en producción. |
| Próximos pasos | Claros | Contacto → Pagos admin → Notificación afiliación → Configuración → PQR → Reportes. |

El sistema está en buen estado para seguir creciendo. Priorizando **contacto**, **registro de pagos** y **notificación de afiliación** se cierran los huecos más importantes antes de seguir con reportes, PQR y pasarela de pagos.
