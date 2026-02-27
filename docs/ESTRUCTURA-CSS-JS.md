# Estructura CSS y JS - Sitio público

## CSS (`resources/css/`)

- **`public.css`** – Punto de entrada. Solo importa los archivos de la carpeta `public/`.
- **`public/`**
  - **`_variables.css`** – Variables de diseño (paleta de colores).
  - **`_base.css`** – Utilidades de marca, botones, cards, gradientes, inputs.
  - **`_components.css`** – Scroll reveal, WhatsApp flotante.
  - **`_layout.css`** – Page hero, sedes, plan badge, block quote.
  - **`_home.css`** – Hero inicio, frases rotativas, about/video, galería de imágenes.
  - **`_auth.css`** – Estilos de login y registro (fondo, tarjeta).

Para añadir estilos: elegir el archivo que corresponda por responsabilidad o crear uno nuevo en `public/` y añadir su `@import` en `public.css`.

---

## JS (`resources/js/`)

- **`public.js`** – Punto de entrada del sitio público. Importa y ejecuta los módulos.
- **`public/`**
  - **`mobile-menu.js`** – Toggle del menú móvil.
  - **`reveal-on-scroll.js`** – Animación al entrar en viewport (`.reveal-on-scroll`).
  - **`hero-phrases.js`** – Frases rotativas del hero en Inicio.

Para añadir comportamiento: crear un módulo en `public/` que exporte una función `init*` y llamarla desde `public.js`.

---

## Imágenes por vista

La función **`imagenes_para_vista($vista, $max)`** (en `app/Helpers/helpers.php`) devuelve las rutas de imágenes que se muestran en cada página, según `config('funeraria.imagenes_por_vista')`:

| Vista        | Clave        | Imágenes (orden en config)                    |
|-------------|--------------|-----------------------------------------------|
| Inicio      | `home`       | REUNION, CARRO, VELAS, FLORES, ATAUD2 (máx. 4) |
| Servicios   | `servicios`  | CARRO, VELAS, TASAS, FLORES, ATAUD2 (máx. 3)   |
| Planes      | `planes`      | REUNION, FIRMAR (máx. 2)                       |
| Obituarios  | `obituarios` | FLORES, VELAS (máx. 2)                         |
| Contacto    | `contacto`   | REUNION, 2COBERTURA (máx. 2)                  |

Los archivos deben estar en `public/images/` con el nombre en mayúsculas (ej. `REUNION.jpg`, `ATAUD2.png`). Se excluyen FUNE e ICONO.

---

## Después de tocar helpers o config

```bash
composer dump-autoload
```

Para compilar assets:

```bash
npm run dev
# o
npm run build
```
