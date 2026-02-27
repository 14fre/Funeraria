{{--
  Elemento decorativo rotatorio para heroes (estilo cruz de Servicios).
  No se usa en Inicio. Cada vista tiene su propio símbolo.
  Variantes: cross, planes, quienes, contacto, obituarios
--}}
@props(['variant' => 'cross'])

<svg class="hero-decorative hero-decorative--{{ $variant }}"
     viewBox="0 0 200 200"
     fill="none"
     xmlns="http://www.w3.org/2000/svg"
     aria-hidden="true">
    @switch($variant)
        @case('planes')
            {{-- Documento / plan --}}
            <path d="M45 35 L45 165 L125 165 L125 75 L85 35 Z" stroke="currentColor" fill="none" stroke-width="1.2"/>
            <path d="M85 35 L85 75 L125 75" stroke="currentColor" fill="none" stroke-width="1.2"/>
            <circle cx="100" cy="100" r="75" stroke="currentColor" stroke-width="0.5" fill="none" stroke-dasharray="4 8"/>
            @break
        @case('quienes')
            {{-- Anillos (unidad / equipo) --}}
            <circle cx="100" cy="100" r="88" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <circle cx="100" cy="100" r="58" stroke="currentColor" stroke-width="0.6" fill="none" stroke-dasharray="5 6"/>
            <circle cx="100" cy="100" r="28" stroke="currentColor" stroke-width="0.4" fill="none" opacity="0.8"/>
            @break
        @case('contacto')
            {{-- Sobre / contacto --}}
            <rect x="28" y="48" width="144" height="104" rx="6" stroke="currentColor" fill="none" stroke-width="1.2"/>
            <path d="M28 48 L100 108 L172 48" stroke="currentColor" fill="none" stroke-width="1.2"/>
            <circle cx="100" cy="100" r="65" stroke="currentColor" stroke-width="0.5" fill="none" stroke-dasharray="3 6"/>
            @break
        @case('obituarios')
            {{-- Vela / recuerdo --}}
            <ellipse cx="100" cy="62" rx="18" ry="26" stroke="currentColor" fill="none" stroke-width="1"/>
            <line x1="100" y1="88" x2="100" y2="52" stroke="currentColor" stroke-width="1"/>
            <rect x="86" y="88" width="28" height="52" rx="2" stroke="currentColor" fill="none" stroke-width="1.2"/>
            <rect x="82" y="140" width="36" height="6" rx="2" stroke="currentColor" fill="none" stroke-width="1"/>
            <circle cx="100" cy="100" r="70" stroke="currentColor" stroke-width="0.5" fill="none" stroke-dasharray="4 6"/>
            @break
        @default
            {{-- Cruz (por si se usa variant cross en page-hero-wrap) --}}
            <rect x="92" y="18" width="16" height="164" rx="3" fill="currentColor"/>
            <rect x="18" y="68" width="164" height="16" rx="3" fill="currentColor"/>
            <circle cx="100" cy="100" r="92" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <circle cx="100" cy="100" r="68" stroke="currentColor" stroke-width="0.5" fill="none" stroke-dasharray="4 6"/>
    @endswitch
</svg>
