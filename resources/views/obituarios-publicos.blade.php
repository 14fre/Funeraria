@extends('layouts.public')

@section('title', 'Obituarios')

@section('content')
    <x-river-of-light />
    {{-- Hero estilo Servicios: símbolo vela, tipografía (sin tocar Inicio) --}}
    <section class="custom-hero" id="hero-obituarios">
        <x-stars-interactive />
        <x-particles class="custom-hero__particles" />
        <x-hero-decorative variant="obituarios" class="custom-hero__symbol" />

        <div class="custom-hero__vela">
            <div class="custom-hero__llama"></div>
            <div class="custom-hero__pabilo"></div>
            <div class="custom-hero__cuerpo-vela"></div>
            <div class="custom-hero__base-vela"></div>
        </div>

        <div class="custom-hero__ornamento">✦ Obituarios ✦</div>
        <h1 class="custom-hero__titulo">
            Obituarios
            <em class="custom-hero__titulo-cursiva">recordando con amor y respeto</em>
        </h1>
        <div class="custom-hero__divisor"></div>
        <p class="custom-hero__subtitulo">
            Recordando a quienes se fueron. Consulta por cédula o nombre<br>
            y honra su memoria con nosotros.
        </p>
        <div class="custom-hero__acciones">
            <a href="#busqueda" class="custom-hero__btn custom-hero__btn--oro">Consultar obituario</a>
            <a href="{{ route('contacto') }}" class="custom-hero__btn custom-hero__btn--borde">Contáctenos</a>
        </div>
        <div class="custom-hero__scroll">
            <span>Descubrir</span>
            <div class="custom-hero__scroll-linea"></div>
        </div>
    </section>

    <!-- Cita destacada (estilo funerariasanjose.co) -->
    <section class="py-8 bg-gray-50 border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <blockquote class="block-quote-funeraria reveal-on-scroll">
                <p>"Siempre tendré presente tu cuerpo y tu voz, aunque pase el tiempo y no te encuentre entre nosotros, tu alma sigue conmigo."</p>
            </blockquote>
        </div>
    </section>

    @php $imgObituarios = imagenes_para_vista('obituarios', 1); @endphp
    @if(count($imgObituarios) > 0)
        <section class="obituarios-banner-img reveal-on-scroll">
            <img src="{{ asset($imgObituarios[0]) }}" alt="Recordando con respeto" loading="lazy">
        </section>
    @endif

    <!-- Búsqueda por cédula o nombre -->
    <section id="busqueda" class="py-8 bg-white border-b section-reveal">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-semibold mb-4 text-center" style="color: var(--color-vinotinto);">
                <i class="fas fa-search mr-2"></i>
                Consultar obituario por cédula o nombre
            </h2>
            <form action="{{ route('obituarios') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                       name="cedula"
                       value="{{ $busqueda['cedula'] ?? '' }}"
                       placeholder="Número de cédula"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg input-focus-funeraria">
                <input type="text"
                       name="nombre"
                       value="{{ $busqueda['nombre'] ?? '' }}"
                       placeholder="Nombre completo"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg input-focus-funeraria">
                <button type="submit" class="px-6 py-2 rounded-lg font-medium text-white transition-colors" style="background-color: var(--color-vinotinto);">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
            </form>
            @if($busqueda && ($busqueda['cedula'] !== '' || $busqueda['nombre'] !== ''))
                <p class="text-sm text-gray-600 mt-2 text-center">
                    {{ $obituarios->total() }} resultado(s) encontrado(s).
                </p>
            @endif
        </div>
    </section>

    <!-- Obituarios -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($busqueda && ($busqueda['cedula'] !== '' || $busqueda['nombre'] !== ''))
                <h2 class="text-2xl font-bold mb-6" style="color: var(--color-vinotinto);">Resultados de búsqueda</h2>
            @else
                <h2 class="text-2xl font-bold mb-6" style="color: var(--color-vinotinto);">Obituarios recientes</h2>
            @endif

            @if($obituarios->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($obituarios as $obituario)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover hover-lift border-2 reveal-on-scroll" style="border-color: var(--color-dorado);">
                            @if($obituario->foto)
                                <img src="{{ asset('storage/' . $obituario->foto) }}" 
                                     alt="{{ $obituario->nombre_completo }}"
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-6xl"></i>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $obituario->nombre_completo }}</h3>
                                @if($obituario->fecha_nacimiento)
                                    <p class="text-gray-600 text-sm mb-1">
                                        {{ $obituario->fecha_nacimiento->format('d/m/Y') }} - 
                                        {{ $obituario->fecha_fallecimiento->format('d/m/Y') }}
                                    </p>
                                @else
                                    <p class="text-gray-600 text-sm mb-1">
                                        Falleció el {{ $obituario->fecha_fallecimiento->format('d/m/Y') }}
                                    </p>
                                @endif
                                @if($obituario->lugar_fallecimiento)
                                    <p class="text-gray-500 text-xs mb-3">{{ $obituario->lugar_fallecimiento }}</p>
                                @endif
                                @if($obituario->biografia)
                                    <p class="text-gray-700 text-sm mb-4">{{ Str::limit($obituario->biografia, 100) }}</p>
                                @endif
                                <a href="{{ route('obituario.show', $obituario) }}" 
                                   class="font-medium text-sm text-vinotinto">
                                    Ver más <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-8">
                    {{ $obituarios->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-book text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-600 text-lg">No hay obituarios publicados en este momento.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA (estilo funerariasanjose.co) -->
    <section class="py-12 gradient-vinotinto text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg mb-4" style="color: var(--color-dorado-suave);">Contactarnos, tenemos planes diseñados para diversos núcleos familiares y acorde a tus necesidades.</p>
            <a href="{{ route('contacto') }}" class="btn-dorado px-6 py-3 rounded-lg font-semibold inline-block mr-4">
                <i class="fas fa-phone mr-2"></i>
                Contáctenos
            </a>
            <a href="{{ route('planes') }}" class="inline-block px-6 py-3 rounded-lg font-semibold border-2 transition-colors" style="border-color: var(--color-dorado); color: var(--color-dorado);" onmouseover="this.style.background='var(--color-dorado)'; this.style.color='var(--color-negro)';" onmouseout="this.style.background='transparent'; this.style.color='var(--color-dorado)';">
                <i class="fas fa-file-contract mr-2"></i>
                Ver Planes
            </a>
        </div>
    </section>
@endsection

