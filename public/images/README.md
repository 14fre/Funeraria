# Imágenes del sitio público

## Favicon (icono de pestaña)

**Archivo:** `icono.ico` y/o `icono.png` (recomendado: ambos para mejor compatibilidad).

- **Uso:** Se muestra en la pestaña del navegador en todas las vistas (inicio, login, registro, admin, cliente).
- Si solo tienes uno, usa `icono.ico` (clásico) o `icono.png`. Si tienes imagen en JPEG, renómbrala a `icono.png` o exporta a PNG/ICO.

---

## Logo (Grupo San José / Funeraria San José)

**Coloque aquí la imagen del logo** (la que dice "Grupo San José" / "Funeraria San José" con el árbol dorado y "Crecemos para Proteger").

- **Carpeta:** `public/images/` (esta misma carpeta).
- **Nombre del archivo:** `logo-funeraria-san-jose.png` (o `logo-funeraria-san-jose.webp` si prefiere).
- **Uso:** Se mostrará en la barra de navegación, en login/registro y en el pie de página.
- **Formato recomendado:** PNG con fondo transparente o WebP. Tamaño sugerido: alto entre 40px y 60px para la nav (el ancho se ajusta automáticamente).

Una vez guardado el archivo con ese nombre en esta carpeta, el sitio usará automáticamente el logo en lugar del icono de cruz.

---

## Enlace de storage (fotos de obituarios, etc.)

Para que las fotos subidas (obituarios, etc.) se vean en la web, debe existir el enlace de Laravel a la carpeta de almacenamiento. Ejecute **una sola vez** en la raíz del proyecto (desde la terminal de Laragon o CMD donde tenga `php`):

```bash
php artisan storage:link
```

Eso crea el enlace `public/storage` → `storage/app/public`. Si ya lo ejecutó antes, no hace falta repetirlo.
