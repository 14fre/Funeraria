# Obituarios – Concepto y flujo

## ¿Qué es un obituario aquí?

En la funeraria, un **obituario** es la **ficha pública de una persona fallecida** que la funeraria ha atendido (o tiene en su base). No es solo un aviso: es el registro que permite:

- **Guardar** los datos del fallecido (nombre, cédula, fechas, biografía, velación, sepultura, foto, etc.).
- **Publicar** o no cada ficha (solo las publicadas se ven en la web).
- **Consultar** desde la página pública por **cédula** o por **nombre**, para que cualquier persona pueda verificar o encontrar el obituario.

Es decir: la “base de muchas personas fallecidas” que comentas **es el listado de obituarios** en el sistema. Cada obituario = un fallecido con su información y su aviso (publicado o no).

---

## Cómo encaja con tu idea

| Tu idea | En el sistema |
|--------|----------------|
| Tener una base de muchos fallecidos | Tabla `obituarios`: un registro por fallecido. |
| Tenerlos “en inventario” / consultables | Están en la base de datos; el admin los crea/edita y puede publicarlos. |
| Consultar desde la página principal | En la **página pública de Obituarios** (y/o en la portada) hay un **buscar por cédula** (y por nombre). |
| Clic y poder averiguar con el número de cédula | Búsqueda por **número de documento (cédula)**; al dar clic se abre la ficha completa del obituario. |

No hace falta “inventario” aparte: el propio módulo de **obituarios** es ese registro de fallecidos. Solo faltaba:

1. **Campo cédula** en la ficha (número de documento).
2. **Búsqueda pública** por cédula y por nombre.
3. **Admin** para dar de alta/editar/publicar cada obituario (CRUD completo).

---

## Flujo propuesto

### 1. Admin (funeraria)

- **Obituarios** en el menú admin.
- **Listado** de todos los obituarios (publicados y no publicados).
- **Crear** obituario: nombre completo, **número de cédula**, fechas, lugar, biografía, mensaje familia, foto, datos de velación/sepultura, y **Publicado (sí/no)**.
- **Editar** cualquier obituario.
- Solo los marcados como **Publicado** se ven en la web pública.

### 2. Página pública (cualquier persona, sin login)

- En **Inicio** (y en la sección Obituarios): enlace claro tipo **“Consultar obituarios”** o **“Buscar por cédula”**.
- En **/obituarios**:
  - **Buscar por cédula**: se escribe el número de documento y se buscan obituarios **publicados** con esa cédula. Si hay uno, se puede ir directo a la ficha; si hay varios (casos raros), listado.
  - **Buscar por nombre**: igual, por nombre completo.
  - **Listado** de obituarios publicados recientes (como ahora) y resultados de búsqueda.
- **Clic** en un obituario → **Ficha completa** (obituario-show): datos, fechas, velación, sepultura, condolencias.

### 3. Resumen

- **Base de fallecidos** = registros en `obituarios` (con cédula, nombre, fechas, etc.).
- **Consultar** = página pública con búsqueda por **cédula** y por **nombre**, y listado de publicados.
- **Averiguar con la cédula** = buscar por número de documento y abrir la ficha del obituario al hacer clic.

Así se mantiene un solo concepto (obituario = ficha del fallecido) y se cumple lo que necesitas: base única, consultable desde la web y búsqueda por cédula.
