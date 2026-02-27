# Instrucciones para Agregar Video de Fondo

## Ubicación del Video

1. Coloca tu video en la carpeta: `public/videos/hero-background.mp4`
2. Formatos recomendados: MP4, WebM
3. Resolución recomendada: 1920x1080 (Full HD)
4. Duración: 30-60 segundos (se repetirá en loop)

## Activar el Video

Una vez que tengas el video en `public/videos/hero-background.mp4`, descomenta las líneas en `resources/views/welcome.blade.php`:

```php
<!-- Descomentar estas líneas: -->
<video autoplay muted loop class="hero-video-background">
    <source src="{{ asset('videos/hero-background.mp4') }}" type="video/mp4">
</video>

<!-- Y comentar esta línea: -->
<!-- <div class="hero-video-background" style="background: linear-gradient(...)"></div> -->
```

## Características del Video

- Se reproduce automáticamente
- Sin sonido (muted)
- Loop infinito
- Cubre toda la sección hero
- Overlay oscuro para legibilidad del texto

## Alternativa: Imagen de Fondo

Si prefieres usar una imagen en lugar de video, puedes cambiar:

```php
<div class="hero-video-background" style="background-image: url('{{ asset('images/hero-background.jpg') }}'); background-size: cover; background-position: center;"></div>
```

