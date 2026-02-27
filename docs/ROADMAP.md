# Roadmap técnico – SIG Funeraria

Referencia: [ARCHITECTURE.md](./ARCHITECTURE.md) (arquitectura completa, seguridad, escalabilidad, Docker/CI-CD).

## Estado actual

| Fase | Estado | Notas |
|------|--------|--------|
| **F1 – Base** | ✅ Hecho | Planes: Service + Repository + Policy + Form Requests. Livewire usa `PlanExequialService`. |
| **F2 – Afiliación** | ✅ Hecho | Afiliados + Beneficiarios: CRUD completo. Nº afiliación auto (AF-YYYYMM-0001). Beneficiarios con tope por plan. |
| **F3 – Servicios** | ✅ Hecho | Servicios funerarios: Repository, Service, Policy, Livewire Index/Create/Edit (por afiliado, beneficiario opcional, tipo, estado, coordinador). |
| **F3b – Inventario, Vehículos, Salas, Reservas** | ✅ Hecho | Inventario, Salas, Vehículos: CRUD completo (Repository, Service, Policy, Livewire). Reservas: listado admin con filtros. |
| **Solicitudes afiliación** | ✅ Hecho | Cliente solicita → Admin aprueba/rechaza; SweetAlert en confirmaciones y flash. |
| F4 – Pagos | Pendiente | Wompi/Bancolombia/Nequi, webhooks, Jobs. **Dejado para el final.** Vista placeholder. |
| **F5 – Obituarios** | ✅ Hecho | CRUD admin, campo cédula, búsqueda pública por cédula/nombre, listado y ficha pública. |
| F6 – Reportes | Pendiente | PDF, Excel. Vista placeholder. |
| F7 – Producción | Pendiente | Seguridad, Docker, CI/CD. |

## Por dónde seguir (orden sugerido)

1. **F3b – Inventario, Vehículos, Salas, Reservas**  
   Mismo patrón: Repository + Service + Policy + Livewire (admin) y vistas cliente si aplica. Las vistas placeholder ya existen; darles CRUD real.

2. **F5 – Obituarios / Comunicación**  
   Módulo de obituarios (listado, crear, publicar). Notificaciones o PQR según prioridad.

3. **F6 – Reportes**  
   Exportar PDF/Excel (afiliados, pagos, servicios).

4. **F4 – Pagos (al final)**  
   Integrar pasarela (Wompi u otra); webhooks; Jobs; carrusel de pago en cliente.

## SweetAlert2

- Incluido en layouts **admin** y **cliente** (CDN).
- Mensajes flash: `session('success')`, `session('error')`, `session('info')` se muestran con SweetAlert (toast o modal).
- Confirmaciones: aprobar/rechazar solicitud de afiliación usan SweetAlert en lugar de `confirm()`.

Para más confirmaciones (p. ej. eliminar en Livewire), se puede usar `wire:confirm` (nativo) o sustituir por SweetAlert con un poco de JS.

## Próximos pasos recomendados (detalle)

1. **Replicar patrón en Afiliados**
   - `AfiliadoRepositoryInterface` + `AfiliadoRepository`
   - `AfiliadoService`
   - `AfiliadoPolicy` (admin todo; cliente solo su afiliado)
   - Form Requests: `StoreAfiliadoRequest`, `UpdateAfiliadoRequest`
   - Livewire Admin: Afiliados Index/Create/Edit usando `AfiliadoService`

2. **Beneficiarios**
   - Repository + Service + Policy (cliente solo los de su afiliado)
   - Livewire en admin y cliente

3. **Eventos (opcional en F1)**
   - `PlanExequialCreado` / `PlanExequialActualizado` → listener de auditoría
   - Registrar en `EventServiceProvider` o `app/Providers/AppServiceProvider` (Laravel 11)

4. **Pagos (F4)**
   - `PagoService` con integración pasarela
   - Jobs: `ProcesarWebhookPago`, `EnviarComprobantePago`
   - Rutas API para webhooks (sin Livewire)

## Estructura ya creada

```
app/
├── Contracts/Repositories/
│   └── PlanExequialRepositoryInterface.php
├── Repositories/
│   └── PlanExequialRepository.php
├── Services/
│   └── PlanExequialService.php
├── Http/Requests/Admin/PlanExequial/
│   ├── StorePlanExequialRequest.php
│   └── UpdatePlanExequialRequest.php
├── Policies/
│   └── PlanExequialPolicy.php
└── Livewire/Admin/Planes/   (refactorizados para usar Service + authorize)
```

Binding: `AppServiceProvider` registra `PlanExequialRepositoryInterface` → `PlanExequialRepository`.
