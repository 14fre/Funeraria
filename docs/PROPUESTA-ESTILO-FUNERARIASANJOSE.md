# Propuesta de estilo inspirada en funerariasanjose.co

Referencia: [Funerales San José del Huila SAS](https://www.funerariasanjose.co/). Misma paleta (vinotinto, dorado, negro, azul) y estética corporativa.

---

## Inicio

| Elemento | Propuesta | Estado |
|----------|-----------|--------|
| Hero + frases rotativas | Ya implementado | ✓ |
| Consultar plan exequial | Ya implementado | ✓ |
| **Video / Quiénes somos** | Bloque de dos columnas: izquierda imagen o video (placeholder o embed), derecha texto "Somos una empresa del sector funerario con experiencia de más de 40 años, con presencia en el Huila y parte del Tolima", dirección (Calle 9 Nro. 13-50, Neiva), enlace redes/Instagram. Alternar imagen y texto en móvil. | Implementado |
| Servicios destacados | Mantener cards; opcional: una fila con imagen grande + texto (estilo “feature”) | Actual |
| **Sedes** | Sección antes del CTA: grid de 5 tarjetas (Neiva, Parque Crematorio, La Plata, Yaguará, Natagaima) con icono, dirección y teléfono. Misma paleta. | Implementado |
| Por qué elegirnos / Obituarios / CTA | Sin cambio estructural | ✓ |

---

## Servicios

| Elemento | Propuesta | Estado |
|----------|-----------|--------|
| Page hero | Ya con banner FUNE | ✓ |
| Bloques imagen + texto | Mantener alternancia (imagen izquierda / texto derecha y viceversa). **Unificar colores**: vinotinto, dorado y azul oscuro en iconos y bordes (quitar azul genérico y amarillo genérico). | Implementado |
| Posición de imágenes | Icono o imagen en un tercio; texto en dos tercios. Opcional: si hay fotos reales de salas/vehículos, usar en lugar de iconos. | Actual |

---

## Planes Exequiales

| Elemento | Propuesta | Estado |
|----------|-----------|--------|
| Page hero | Ya con banner FUNE | ✓ |
| **Número en cada plan** | Como en la referencia: badge o número grande (1, 2, 3, 4) en cada tarjeta para “Plan Familiar”, “Plan Individual”, etc. Refuerza orden y seriedad. | Implementado |
| Cards | Mantener header vinotinto, precio y CTA. Check en dorado o vinotinto. | ✓ |

---

## Obituarios

| Elemento | Propuesta | Estado |
|----------|-----------|--------|
| Page hero | Ya con banner FUNE | ✓ |
| **Cita destacada** | Bloque encima o debajo del hero: *"Siempre tendré presente tu cuerpo y tu voz, aunque pase el tiempo y no te encuentre entre nosotros, tu alma sigue conmigo."* — tipografía serif o itálica, fondo sutil (vinotinto muy suave o gris claro), borde lateral dorado. | Implementado |
| Búsqueda y listado | Sin cambio; ya con paleta. | ✓ |

---

## Contacto

| Elemento | Propuesta | Estado |
|----------|-----------|--------|
| Page hero | Ya con banner FUNE | ✓ |
| **Dos columnas** | Izquierda: información de contacto (teléfonos, email, dirección, emergencias 24/7) + **Sedes** (lista o mini-cards con las 5 ubicaciones y teléfono). Derecha: formulario. Como en la referencia. | Implementado (Sedes en contacto) |
| Formulario | Focus con color vinotinto/dorado; botones con btn-vinotinto. | ✓ |
| Redes | Iconos con colores de marca (hover dorado) en lugar de azul/rosa genérico. | Implementado |

---

## Footer (todas las vistas)

| Elemento | Propuesta | Estado |
|----------|-----------|--------|
| **Sedes** | Nueva columna o bloque: las 5 sedes con nombre, dirección y teléfono (Neiva, Parque Crematorio, La Plata, Yaguará, Natagaima). Icono de ubicación, mismo estilo que el resto del footer. | Implementado |
| Enlaces rápidos / Contacto / Atención | Sin cambio | ✓ |
| Fondo | Gradiente negro a azul oscuro; texto y enlaces con hover dorado. | ✓ |

---

## Datos de sedes (referencia funerariasanjose.co)

| Sede | Dirección | Teléfono |
|------|-----------|----------|
| Neiva | Calle 9 Nro. 13-50 (Altico) | 3186298729 |
| Parque Crematorio | Km 1 Vía Fortalecillas | 3152094373 |
| La Plata | Calle 4 Nro. 2-17 | 3174368794 |
| Yaguará | Carrera 2 Nro. 5-78 | 3118347886 |
| Natagaima | Calle 7 Nro. 5-33 | 3176437058 |

Configuración en `config/funeraria.php` (sedes) para reutilizar en Inicio, Contacto y Footer.

---

## Resumen de implementación

- **Config:** `config/funeraria.php` con `sedes` y datos de contacto.
- **Partial:** `resources/views/partials/sedes.blade.php` para listar sedes (footer, contacto, inicio).
- **Inicio:** Sección “Video / Quiénes somos” + sección “Nuestras sedes”.
- **Footer:** Bloque Sedes con las 5 ubicaciones.
- **Planes:** Número (1–4) en cada card.
- **Obituarios:** Cita emotiva en bloque destacado.
- **Contacto:** Sedes en columna info; redes con colores de marca.
- **Servicios:** Paleta unificada (vinotinto, dorado, azul oscuro) en iconos y botones.
