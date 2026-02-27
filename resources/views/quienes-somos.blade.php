@extends('layouts.public')

@section('title', 'Quiénes Somos')

@section('content')
    {{-- Hero estilo Servicios: símbolo anillos, vela, tipografía (sin tocar Inicio) --}}
    <section class="custom-hero" id="hero-quienes">
        <x-particles class="custom-hero__particles" />
        <x-hero-decorative variant="quienes" class="custom-hero__symbol" />

        <div class="custom-hero__vela">
            <div class="custom-hero__llama"></div>
            <div class="custom-hero__pabilo"></div>
            <div class="custom-hero__cuerpo-vela"></div>
            <div class="custom-hero__base-vela"></div>
        </div>

        <div class="custom-hero__ornamento">✦ Quiénes Somos ✦</div>
        <h1 class="custom-hero__titulo">
            Quiénes Somos
            <em class="custom-hero__titulo-cursiva">nuestra historia y valores</em>
        </h1>
        <div class="custom-hero__divisor"></div>
        <p class="custom-hero__subtitulo">
            Conoce nuestra misión, visión y más de 40 años acompañando a las familias<br>
            con respeto, dignidad y profesionalismo.
        </p>
        <div class="custom-hero__acciones">
            <a href="{{ route('servicios') }}" class="custom-hero__btn custom-hero__btn--oro">Nuestros Servicios</a>
            <a href="{{ route('contacto') }}" class="custom-hero__btn custom-hero__btn--borde">Contáctenos</a>
        </div>
        <div class="custom-hero__scroll">
            <span>Descubrir</span>
            <div class="custom-hero__scroll-linea"></div>
        </div>
    </section>

    @php $imgsQs = imagenes_para_vista('quienes_somos', 4); @endphp

    <!-- Nuestra Historia -->
    <section class="py-16 bg-white reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <x-section-heading title="Nuestra Historia" icon="fa-landmark" />
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        <strong>Funerales San José del Huila SAS</strong> es una empresa del sector funerario con experiencia de más de <strong>40 años</strong>, con presencia en el Huila y parte del Tolima. Nacimos con el compromiso de acompañar a las familias en sus momentos más difíciles, ofreciendo servicios con respeto, dignidad y profesionalismo.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        A lo largo de nuestra trayectoria hemos crecido en infraestructura, sedes y equipo humano, manteniendo siempre el trato cercano y la calidad que nos caracteriza.
                    </p>
                </div>
                @if(count($imgsQs) > 0)
                    <div class="quienes-somos-img-wrap hover-lift-img rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset($imgsQs[0]) }}" alt="Nuestra historia" class="w-full h-full object-cover" style="min-height: 280px;" loading="lazy">
                    </div>
                @else
                    <div class="quienes-somos-img-placeholder rounded-xl overflow-hidden flex items-center justify-center" style="min-height: 280px; background: linear-gradient(135deg, var(--color-vinotinto), #7a1a3d);">
                        <i class="fas fa-landmark text-white text-6xl opacity-50"></i>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Misión y Visión -->
    <section id="mision" class="py-16 bg-gray-50 reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12"><x-section-heading title="Misión y Visión" icon="fa-bullseye" :center="true" /></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 border-l-4 hover-lift" style="border-left-color: var(--color-vinotinto);">
                    <div class="w-14 h-14 rounded-full gradient-vinotinto flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" style="color: var(--color-vinotinto);">Misión</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Ofrecer servicios funerarios y de asistencia exequial con la más alta calidad, respeto y calidez humana, acompañando a las familias del Huila y Tolima en el momento más difícil, con personal idóneo y altamente calificado que gestiona y responde a sus necesidades.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 border-l-4 hover-lift" style="border-left-color: var(--color-dorado);">
                    <div class="w-14 h-14 rounded-full gradient-dorado flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-gray-900 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-dorado">Visión</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Ser la empresa funeraria de referencia en la región, reconocida por nuestro compromiso con las familias, la excelencia en el servicio y la constante mejora en infraestructura y atención al cliente.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores Corporativos -->
    <section class="py-16 bg-white reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center mb-12"><x-section-heading title="Valores Corporativos" icon="fa-heart" :center="true" /></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 rounded-xl bg-gray-50 hover-lift border border-gray-100">
                    <div class="w-16 h-16 rounded-full gradient-vinotinto flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold mb-2" style="color: var(--color-vinotinto);">Respeto</h3>
                    <p class="text-gray-600 text-sm">Trato digno a las familias y a quienes partieron.</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-gray-50 hover-lift border border-gray-100">
                    <div class="w-16 h-16 rounded-full gradient-dorado flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-gray-900 text-2xl"></i>
                    </div>
                    <h3 class="font-bold mb-2 text-dorado">Compromiso</h3>
                    <p class="text-gray-600 text-sm">Cumplimiento y calidad en cada servicio.</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-gray-50 hover-lift border border-gray-100">
                    <div class="w-16 h-16 rounded-full gradient-vinotinto flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold mb-2" style="color: var(--color-vinotinto);">Transparencia</h3>
                    <p class="text-gray-600 text-sm">Claridad y honestidad en toda nuestra gestión.</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-gray-50 hover-lift border border-gray-100">
                    <div class="w-16 h-16 rounded-full gradient-dorado flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-gray-900 text-2xl"></i>
                    </div>
                    <h3 class="font-bold mb-2 text-dorado">Solidaridad</h3>
                    <p class="text-gray-600 text-sm">Acompañamiento cercano en el duelo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Principios Corporativos -->
    <section class="py-16 bg-gray-50 reveal-on-scroll">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center mb-10"><x-section-heading title="Principios Corporativos" icon="fa-check-double" :center="true" /></div>
            <ul class="space-y-4">
                <li class="flex items-start gap-4 p-4 bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: var(--color-dorado);">
                    <i class="fas fa-check-circle mt-1" style="color: var(--color-dorado);"></i>
                    <span class="text-gray-700">Atención con el mejor trato humano y flexibilidad para resolver las necesidades de las familias.</span>
                </li>
                <li class="flex items-start gap-4 p-4 bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: var(--color-dorado);">
                    <i class="fas fa-check-circle mt-1" style="color: var(--color-dorado);"></i>
                    <span class="text-gray-700">Garantía de calidad en la coordinación del servicio y en todas las etapas del proceso.</span>
                </li>
                <li class="flex items-start gap-4 p-4 bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: var(--color-dorado);">
                    <i class="fas fa-check-circle mt-1" style="color: var(--color-dorado);"></i>
                    <span class="text-gray-700">Respeto por las creencias y costumbres de cada familia.</span>
                </li>
                <li class="flex items-start gap-4 p-4 bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: var(--color-dorado);">
                    <i class="fas fa-check-circle mt-1" style="color: var(--color-dorado);"></i>
                    <span class="text-gray-700">Profesionalismo y discreción en el manejo de la información.</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- Imagen de acento (opcional) -->
    @if(count($imgsQs) > 1)
        <section class="py-8 bg-white reveal-on-scroll">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="contacto-acento-img__inner hover-lift-img rounded-xl overflow-hidden shadow-lg" style="max-width: 680px; aspect-ratio: 16/9;">
                    <img src="{{ asset($imgsQs[1]) }}" alt="Funerales San José" class="w-full h-full object-cover" loading="lazy">
                </div>
            </div>
        </section>
    @endif

    <!-- Sedes + Mapa de cobertura -->
    <section id="sedes" class="py-16 bg-white reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center mb-4"><x-section-heading title="Sedes" icon="fa-map-marker-alt" :center="true" /></div>
            <p class="text-center text-gray-600 mb-10 max-w-2xl mx-auto">Estamos presentes en el Huila y Tolima para atenderle con calidad y respeto.</p>

            @if(isset($imgsQs[3]))
                <div class="sedes-mapa-wrap mb-12">
                    <img src="{{ asset($imgsQs[3]) }}" alt="Mapa de cobertura - Funerales San José del Huila" class="sedes-mapa-img" loading="lazy">
                </div>
            @endif

            <div class="sedes-list sedes-list--cards">
                @foreach(config('funeraria.sedes', []) as $sede)
                    <div class="sede-item hover-lift">
                        <div class="sede-item__icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="sede-item__content">
                            <strong class="sede-item__nombre">{{ $sede['nombre'] }}</strong>
                            <span class="sede-item__direccion">{{ $sede['direccion'] }}{{ !empty($sede['detalle']) ? ' - ' . $sede['detalle'] : '' }}</span>
                            <a href="tel:{{ preg_replace('/\D/', '', $sede['telefono']) }}" class="sede-item__telefono">Cel. {{ $sede['telefono'] }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Aliados Estratégicos (placeholder para imágenes que agregarás) -->
    <section class="py-16 bg-gray-50 reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center mb-10"><x-section-heading title="Aliados Estratégicos" icon="fa-handshake" :center="true" /></div>
            <div class="flex flex-wrap justify-center items-center gap-8">
                @if(count($imgsQs) > 2)
                    <div class="quienes-aliado-item rounded-lg overflow-hidden shadow-md bg-white p-4 hover-lift">
                        <img src="{{ asset($imgsQs[2]) }}" alt="Aliado" class="h-16 w-auto object-contain" loading="lazy">
                    </div>
                @endif
                <div class="quienes-aliado-placeholder rounded-lg border-2 border-dashed border-gray-300 bg-white p-8 text-center text-gray-400">
                    <i class="fas fa-handshake text-4xl mb-2"></i>
                    <p class="text-sm">Próximamente más aliados</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trabaje con Nosotros -->
    <section class="py-16 gradient-vinotinto text-white reveal-on-scroll">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="section-heading section-heading--center mb-4" style="color: white;">
                <span class="section-heading__icon" style="color: var(--color-dorado);" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
                <span class="section-heading__line" style="background: linear-gradient(90deg, transparent, var(--color-dorado), transparent);"></span>
                <span>Trabaje con Nosotros</span>
            </h2>
            <p class="text-lg mb-8" style="color: var(--color-dorado-suave);">
                Contamos con personal idóneo, altamente calificado. Si desea hacer parte de nuestro equipo, contáctenos.
            </p>
            <a href="{{ route('contacto') }}" class="btn-dorado px-8 py-3 rounded-lg font-semibold text-lg inline-block">
                <i class="fas fa-envelope mr-2"></i>
                Contáctenos
            </a>
        </div>
    </section>
@endsection
