# Efectos visuales – Estrategia frontend

## Criterio general

- **Identidad:** Todas las vistas públicas comparten la imagen FUNE y la paleta (vinotinto, dorado, negro, azul).
- **No exagerar:** Parallax fuerte solo en Inicio; en el resto, efectos más suaves para no cansar ni restar impacto al home.
- **Rendimiento:** Evitar muchos `background-attachment: fixed` (solo 1 en Inicio) y animaciones pesadas.

---

## 1. Parallax (fondo fijo al hacer scroll)

- **Dónde:** Solo en **Inicio** (`/`).
- **Cómo:** Imagen FUNE con `background-attachment: fixed` en el hero a pantalla completa.
- **Por qué:** Da el “wow” en la página principal; si se repite en todas las páginas, pierde efecto y puede afectar rendimiento en móviles.

---

## 2. Banner de cabecera (misma imagen, sin parallax)

- **Dónde:** **Servicios**, **Planes**, **Obituarios**, **Contacto**.
- **Cómo:** Cabecera de altura media (~16–20rem) con la misma imagen FUNE de fondo + overlay oscuro + título de la página. La imagen **no** usa `fixed` (solo `background-size: cover`), así que no hay parallax pero sí unidad visual.
- **Por qué:** Refuerza la marca y la sensación de “mismo sitio” sin repetir el efecto fuerte del Inicio.

---

## 3. Scroll reveal (entrada suave al hacer scroll)

- **Dónde:** Secciones de contenido (tarjetas, bloques de texto) en páginas públicas.
- **Cómo:** Clase utilitaria (por ejemplo `.section-reveal`) que aplica una animación suave (fade-in o slide-up) cuando el bloque entra en viewport. Se puede hacer con CSS + Intersection Observer (poco JS) o solo CSS con animación al cargar.
- **Por qué:** Da sensación de dinamismo sin ser invasivo; mejora la percepción de calidad.

---

## 4. Admin y portal cliente

- **Criterio:** Interfaz de trabajo, no marketing. Sin fondos con imagen ni parallax.
- **Opcional:** Fondo muy sutil (gradiente o patrón ligero) si se quiere algo de marca, pero sin FUNE para no distraer.

---

## Resumen por vista

| Vista              | Parallax | Banner FUNE | Scroll reveal |
|--------------------|----------|-------------|----------------|
| Inicio (/)         | Sí       | —           | Opcional       |
| Servicios          | No       | Sí          | Sí (sutil)     |
| Planes             | No       | Sí          | Sí             |
| Obituarios         | No       | Sí          | Sí             |
| Contacto           | No       | Sí          | Sí             |
| Login/Registro     | Fondo fijo (ya hecho) | — | —    |
| Admin / Cliente    | No       | No          | No             |

---

## Implementación realizada

- **Banner FUNE:** Componente Blade `resources/views/components/page-hero.blade.php` con props `title`, `subtitle`, `icon`. Si existe `public/images/FUNE.jpeg`, muestra fondo FUNE + overlay; si no, gradiente vinotinto/negro. Usado en Servicios, Planes, Obituarios y Contacto.
- **Estilos:** En `resources/css/public.css`: `.page-hero`, `.page-hero--with-image`, `.page-hero__bg`, `.page-hero__overlay`, `.page-hero__content`, `.page-hero__title`, `.page-hero__icon`, `.page-hero__subtitle`.
- **Scroll reveal:** Clase `.section-reveal` con animación `sectionReveal` (fade-in + translateY). Clases de retraso: `.section-reveal-delay-1` a `.section-reveal-delay-4`. Aplicada a la primera sección de contenido en Servicios, Planes, Obituarios y Contacto (animación al cargar la página). Opcional: añadir Intersection Observer para animar al entrar en viewport.
