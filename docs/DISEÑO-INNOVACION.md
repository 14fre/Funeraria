# Innovación de diseño – Plataforma Funeraria San José

Ideas para modernizar el frontend manteniendo la paleta (vinotinto, dorado, negro, azul) y sustituir la web actual [funerariasanjose.co](https://www.funerariasanjose.co/).

---

## Referencia: sitio actual (funerariasanjose.co)

- **Hero:** Carrusel de frases (“Contamos con el personal altamente calificado…”, “Estamos para ofrecer los Servicios funerales…”, “Brindamos una atención de alta calidad…”).
- **CTA destacado:** “Consultar estado de tu PLAN EXEQUIAL” con botón “CONSULTAR”.
- **Video:** Presentación de la empresa (40+ años, Huila y Tolima).
- **Planes:** Protección Exequial, Plan Familiar, Plan Individual, Plan Empresarial, Plan Anticipado.
- **Obituarios:** Frase emotiva + enlace.
- **COVID-19:** Protocolos de bioseguridad (opcional mantener o retirar).
- **Footer:** Sedes (Neiva, Parque Crematorio, La Plata, Yaguará, Natagaima), teléfonos, redes, WhatsApp.

---

## Estrategia: ligero y con identidad

| Objetivo | Enfoque |
|----------|--------|
| **Misma paleta** | Seguir con `--color-vinotinto`, `--color-dorado`, `--color-negro`, `--color-azul-oscuro`. |
| **Animaciones** | CSS + Intersection Observer (sin librerías pesadas). Opcional: AOS vía CDN si se quiere más variedad. |
| **Innovar** | Scroll reveal al entrar en viewport, botón WhatsApp flotante, micro-interacciones en cards y nav. |

---

## Ideas implementadas o recomendadas

### 1. Scroll reveal al hacer scroll
- **Qué:** Elementos que hacen fade-in + slide-up cuando entran en el viewport.
- **Cómo:** Clase `.reveal-on-scroll` + script con Intersection Observer en el layout público (sin dependencias).
- **Dónde:** Secciones de Inicio, tarjetas de Servicios/Planes, bloques de texto.

### 2. Botón flotante WhatsApp
- **Qué:** Botón fijo (esquina inferior derecha) que enlaza a WhatsApp.
- **Cómo:** Enlace con número configurable (env `WHATSAPP_NUMBER` o fallback), estilos en `public.css`.
- **Referencia:** Igual que en [funerariasanjose.co](https://www.funerariasanjose.co/).

### 3. Hero con frases rotativas (opcional)
- **Qué:** Varias frases que rotan en el hero (como el carrusel del sitio actual).
- **Cómo:** CSS `animation` con `@keyframes` para cambiar opacidad/texto, o pequeño JS que alterne frases cada 4–5 s. Sin carrusel pesado.

### 4. Consultar plan exequial en Inicio
- **Qué:** Bloque tipo “Aquí puedes CONSULTAR el estado de tu PLAN EXEQUIAL” con botón.
- **Cómo:** Sección en `welcome.blade.php` con enlace a login/cliente o a una ruta “consultar plan” (según lógica de negocio).

### 5. Footer con sedes
- **Qué:** Listado de sedes con dirección y teléfono (Neiva, Parque Crematorio, La Plata, etc.).
- **Cómo:** Datos en config o BD; vista partial del footer con grid de sedes. Misma paleta.

### 6. Micro-interacciones
- **Nav:** Transición suave en hover y en active (ya hay bordes dorados).
- **Cards:** Hover con `transform` y `box-shadow` (ya `.card-hover`); opcional stagger con `animation-delay` en hijos.
- **Botones:** Transición de color y escala (ya en `.btn-dorado` y `.btn-vinotinto`).

### 7. Librerías opcionales (si se quiere más efecto)
- **AOS (Animate On Scroll):** ~3 KB gzip, CDN. Atributos `data-aos="fade-up"` etc. Alternativa: nuestro script con Intersection Observer (0 KB).
- **Alpine.js:** Ya no necesario para lo descrito; si más adelante se quiere acordeones o tabs en Servicios/Planes, se puede valorar.

---

## Resumen de prioridades

1. **Hecho:** Scroll reveal con Intersection Observer; botón WhatsApp flotante; bloque “Consultar plan exequial” en Inicio; clases `.reveal-on-scroll` y delays en secciones de Inicio.
2. **Recomendado:** Footer con sedes (Neiva, Parque Crematorio, La Plata, Yaguará, Natagaima).
3. **Opcional:** Hero con frases rotativas; AOS por CDN si se pide más tipos de animación.

Todo manteniendo colores actuales y sin animaciones pesadas.

---

## Configuración

- **WhatsApp:** En `.env` define `WHATSAPP_NUMBER=573186298729` (o el número con código país, sin +). Por defecto usa `573186298729`.
