@extends('layouts.public')

@section('title', 'Inicio')

@section('content')
    <!-- Hero Section: imagen FUNE con efecto parallax (fondo fijo) + overlay -->
    <section class="hero-video-container hero-parallax">
        @if(file_exists(public_path('images/FUNE.jpeg')))
            <div class="hero-bg-image" aria-hidden="true"></div>
        @else
            <div class="hero-gradient-fallback-only"
                 style="background: linear-gradient(135deg, var(--color-vinotinto) 0%, var(--color-negro) 50%, var(--color-azul-oscuro) 100%);"></div>
        @endif
        <div class="hero-overlay"></div>
        <x-particles class="particles-bg--hero" />
        <div class="hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-glow-dorado" style="color: var(--color-dorado);">
                <i class="fas fa-cross mr-3"></i>
                Funeraria San José del Huila
            </h1>
            <div class="hero-phrases-wrap mb-8">
                <div class="hero-phrases" id="hero-phrases" role="presentation" aria-live="polite">
                    <p class="hero-phrase is-visible" data-index="0">Acompañamos a las familias con respeto, dignidad y profesionalismo</p>
                    <p class="hero-phrase" data-index="1">No llores porque se ha ido, sonríe porque existió.</p>
                    <p class="hero-phrase" data-index="2">Contamos con personal altamente calificado, gestionando y respondiendo a sus necesidades</p>
                    <p class="hero-phrase" data-index="3">Estamos para ofrecer los servicios funerarios y asistencia exequial con calidad</p>
                    <p class="hero-phrase" data-index="4">Brindamos una atención de alta calidad en momentos difíciles</p>
                </div>
                <div class="hero-phrases-dots" id="hero-phrases-dots" aria-hidden="true"></div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('planes') }}" class="btn-dorado px-8 py-3 rounded-lg font-semibold text-lg">
                    <i class="fas fa-file-contract mr-2"></i>
                    Ver Planes Exequiales
                </a>
                <a href="{{ route('contacto') }}"
                    class="bg-transparent border-2 px-8 py-3 rounded-lg font-semibold text-lg transition-colors"
                    style="border-color: var(--color-dorado); color: var(--color-dorado);"
                    onmouseover="this.style.backgroundColor='var(--color-dorado)'; this.style.color='var(--color-negro)';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--color-dorado)';">
                    <i class="fas fa-phone mr-2"></i>
                    Contáctanos
                </a>
            </div>
        </div>
    </section>

    <!-- Video / Quiénes somos (estilo funerariasanjose.co) -->
    @php
        $videoMp4Path = config('funeraria.video_mp4', 'videos/Video.mp4');
        $videoWebmPath = config('funeraria.video_webm', 'videos/VIDEO2.webm');
        $videoMp4 = file_exists(public_path($videoMp4Path));
        $videoWebm = file_exists(public_path($videoWebmPath));
        $tieneVideo = $videoMp4 || $videoWebm;
    @endphp
    <section id="video" class="py-16 bg-white reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="about-section about-section--reverse">
                <div class="about-section__media about-section__media--video">
                    @if($tieneVideo)
                        <video class="about-video" controls playsinline preload="metadata" poster="{{ file_exists(public_path('images/FUNE.jpeg')) ? asset('images/FUNE.jpeg') : '' }}">
                            @if($videoMp4)
                                <source src="{{ asset($videoMp4Path) }}" type="video/mp4">
                            @endif
                            @if($videoWebm)
                                <source src="{{ asset($videoWebmPath) }}" type="video/webm">
                            @endif
                            Tu navegador no soporta la reproducción de video.
                        </video>
                    @else
                        <i class="fas fa-play-circle"></i>
                    @endif
                </div>
                <div class="about-section__content">
                    <h2 class="text-2xl md:text-3xl font-bold" style="color: var(--color-vinotinto);">
                        Funeraria San José del Huila
                    </h2>
                    <p class="text-muted mb-4">
                        Somos una empresa del sector funerario con experiencia de más de 40 años, con presencia en el Huila y parte del Tolima. Contamos con personal idóneo, altamente calificado, gestionando y respondiendo a sus necesidades en el momento que más lo necesita.
                    </p>
                    <p class="address mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ config('funeraria.direccion_principal') }}<br>
                        {{ config('funeraria.ciudad') }}
                    </p>
                    <p class="text-muted text-sm mb-4">
                        Móvil: {{ implode(' - ', config('funeraria.telefonos', [])) }}
                    </p>
                    <div class="flex gap-4">
                        <a href="https://www.instagram.com/funerariasanjosedelhuila" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-dorado transition-colors" aria-label="Instagram">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-dorado transition-colors" aria-label="Facebook">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Consultar plan exequial (destacado como funerariasanjose.co) -->
    <section class="py-10 bg-gray-100 reveal-on-scroll">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="consultar-plan-box">
                <h2 class="consultar-plan-box__title">
                    Aquí puedes consultar el estado de tu <strong>Plan Exequial</strong>, tanto el tuyo como el de tu familia.
                </h2>
                <a href="{{ route('login') }}" class="consultar-plan-box__cta">
                    <i class="fas fa-search mr-2"></i>
                    Consultar
                </a>
            </div>
        </div>
    </section>

    <!-- Protección Exequial: 4 planes (estilo funerariasanjose.co) -->
    @php
        $planesInicio = \App\Models\PlanExequial::where('activo', true)->orderBy('id')->take(4)->get();
    @endphp
    @if($planesInicio->count() > 0)
        <section class="py-16 bg-white reveal-on-scroll">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-10" style="color: var(--color-vinotinto);">
                    Protección Exequial
                </h2>
                <div class="proteccion-exequial">
                    @foreach($planesInicio as $index => $plan)
                        <div class="proteccion-exequial__card reveal-on-scroll">
                            <span class="proteccion-exequial__num" aria-hidden="true">{{ $index + 1 }}</span>
                            <h3>{{ $plan->nombre }}</h3>
                            <p>{{ Str::limit($plan->descripcion ?? 'Plan de protección exequial diseñado para ti y tu familia.', 120) }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('planes') }}" class="btn-vinotinto px-6 py-2 rounded-lg text-white font-semibold inline-flex items-center">
                        Ver todos los planes <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Servicios Destacados -->
    <section class="py-16" style="background-color: var(--color-fondo-claro);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal-on-scroll">
                <h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: var(--color-vinotinto);">
                    Nuestros Servicios
                </h2>
                <p class="text-lg max-w-2xl mx-auto" style="color: var(--color-negro);">
                    Ofrecemos servicios funerarios completos con la más alta calidad y respeto
                </p>
            </div>

            <x-carousel-imagenes :imagenes="imagenes_para_vista('home', 6)" :autoplay-ms="4500" class="mb-12" />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Velación -->
                <div class="bg-white rounded-lg shadow-lg p-6 card-hover border-t-4 reveal-on-scroll reveal-delay-1"
                    style="border-top-color: var(--color-vinotinto);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                        style="background: linear-gradient(135deg, var(--color-vinotinto), #7a1a3d);">
                        <i class="fas fa-door-open text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2" style="color: var(--color-vinotinto);">Velación</h3>
                    <p class="mb-4" style="color: var(--color-negro);">
                        Salas de velación cómodas y espaciosas para despedir a sus seres queridos con dignidad.
                    </p>
                    <a href="{{ route('servicios') }}" class="font-medium" style="color: var(--color-vinotinto);">
                        Más información <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Velación Virtual -->
                <div class="bg-white rounded-lg shadow-lg p-6 card-hover border-t-4 reveal-on-scroll reveal-delay-2"
                    style="border-top-color: var(--color-azul-oscuro);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                        style="background: linear-gradient(135deg, var(--color-azul-oscuro), #1e3a5f);">
                        <i class="fas fa-video text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2" style="color: var(--color-azul-oscuro);">Velación Virtual</h3>
                    <p class="mb-4" style="color: var(--color-negro);">
                        Transmisión en vivo para que familiares y amigos puedan participar desde cualquier lugar.
                    </p>
                    <a href="{{ route('servicios') }}" class="font-medium" style="color: var(--color-azul-oscuro);">
                        Más información <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Cremación -->
                <div class="bg-white rounded-lg shadow-lg p-6 card-hover border-t-4 reveal-on-scroll reveal-delay-3"
                    style="border-top-color: var(--color-dorado);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 gradient-dorado">
                        <i class="fas fa-fire text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-dorado">Cremación</h3>
                    <p class="mb-4" style="color: var(--color-negro);">
                        Servicio de cremación con todas las garantías y respeto que su ser querido merece.
                    </p>
                    <a href="{{ route('servicios') }}" class="font-medium text-dorado">
                        Más información <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Traslados -->
                <div class="bg-white rounded-lg shadow-lg p-6 card-hover border-t-4 reveal-on-scroll reveal-delay-4"
                    style="border-top-color: var(--color-vinotinto);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 gradient-vinotinto">
                        <i class="fas fa-car text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-vinotinto">Traslados</h3>
                    <p class="mb-4" style="color: var(--color-negro);">
                        Traslados nacionales e internacionales con toda la documentación necesaria.
                    </p>
                    <a href="{{ route('servicios') }}" class="font-medium text-vinotinto">
                        Más información <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Planes Exequiales -->
                <div class="bg-white rounded-lg shadow-lg p-6 card-hover border-t-4 reveal-on-scroll reveal-delay-5"
                    style="border-top-color: var(--color-dorado);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 gradient-dorado">
                        <i class="fas fa-file-contract text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-dorado">Planes Exequiales</h3>
                    <p class="mb-4" style="color: var(--color-negro);">
                        Planes de previsión exequial para proteger a su familia con anticipación.
                    </p>
                    <a href="{{ route('planes') }}" class="font-medium text-dorado">
                        Ver planes <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Asesoría -->
                <div class="bg-white rounded-lg shadow-lg p-6 card-hover border-t-4 reveal-on-scroll reveal-delay-6"
                    style="border-top-color: var(--color-vinotinto);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 gradient-vinotinto">
                        <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-vinotinto">Asesoría Personalizada</h3>
                    <p class="mb-4" style="color: var(--color-negro);">
                        Nuestro equipo está disponible para asesorarle en todo momento con empatía y profesionalismo.
                    </p>
                    <a href="{{ route('contacto') }}" class="font-medium text-vinotinto">
                        Contáctanos <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Por qué elegirnos -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal-on-scroll">
                <h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: var(--color-vinotinto);">
                    ¿Por qué elegirnos?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center reveal-on-scroll reveal-delay-1">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 gradient-dorado">
                        <i class="fas fa-award text-white text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2" style="color: var(--color-vinotinto);">Experiencia</h3>
                    <p style="color: var(--color-negro);">Años de experiencia sirviendo a las familias del Huila</p>
                </div>

                <div class="text-center reveal-on-scroll reveal-delay-2">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 gradient-vinotinto">
                        <i class="fas fa-heart text-white text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-vinotinto">Respeto</h3>
                    <p style="color: var(--color-negro);">Tratamos a cada familia con el máximo respeto y dignidad</p>
                </div>

                <div class="text-center reveal-on-scroll reveal-delay-3">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4"
                        style="background: linear-gradient(135deg, var(--color-azul-oscuro), #1e3a5f);">
                        <i class="fas fa-clock text-white text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2" style="color: var(--color-azul-oscuro);">Disponibilidad</h3>
                    <p style="color: var(--color-negro);">Atención 24 horas los 365 días del año</p>
                </div>

                <div class="text-center reveal-on-scroll reveal-delay-4">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 gradient-dorado">
                        <i class="fas fa-shield-alt text-white text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-dorado">Confianza</h3>
                    <p style="color: var(--color-negro);">Servicios garantizados con transparencia total</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestras sedes (estilo funerariasanjose.co) -->
    <section class="py-16 bg-white reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold mb-2" style="color: var(--color-vinotinto);">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Nuestras sedes
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Estamos presentes en el Huila y Tolima para atenderle con calidad y respeto.
                </p>
            </div>
            <div class="sedes-list sedes-list--cards">
                @foreach(config('funeraria.sedes', []) as $sede)
                    <div class="sede-item">
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

    <!-- Protocolos COVID-19 (estilo funerariasanjose.co) -->
    <section class="py-16 bg-white border-t border-gray-100 reveal-on-scroll">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-3" style="color: var(--color-vinotinto);">
                <i class="fas fa-shield-virus mr-2"></i>
                Protocolos COVID-19
            </h2>
            <p class="text-lg text-gray-600 mb-6">
                Nos hemos preparado física y logísticamente para enfrentar la pandemia. Con protocolos de bioseguridad para las áreas de: <strong>Salas de Velación</strong>, <strong>Atención al Cliente</strong> y <strong>Parque Crematorio San José</strong>.
            </p>
        </div>
    </section>

    <!-- Obituarios: cita + consultar por cédula -->
    <section class="py-12 bg-gray-50 reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-6" style="color: var(--color-vinotinto);">
                <i class="fas fa-book mr-2"></i>
                Obituarios
            </h2>
            <blockquote class="block-quote-funeraria max-w-3xl mx-auto mb-8 text-center">
                <p>"Siempre tendré presente tu cuerpo y tu voz, aunque pase el tiempo y no te encuentre entre nosotros, tu alma sigue conmigo."</p>
            </blockquote>
            <div class="text-center">
                <p class="text-gray-600 mb-4">Consulte nuestro registro de obituarios por número de cédula o nombre.</p>
                <a href="{{ route('obituarios') }}" class="inline-flex items-center px-6 py-3 rounded-lg font-semibold text-white transition-colors" style="background-color: var(--color-vinotinto);">
                    <i class="fas fa-search mr-2"></i>
                    Consultar por cédula o nombre
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section (estilo funerariasanjose.co) -->
    <section class="py-16 gradient-vinotinto text-white reveal-on-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg mb-4" style="color: var(--color-dorado-suave);">
                Contactarnos, tenemos planes diseñados para diversos núcleos familiares y acorde a tus necesidades.
            </p>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Protege a tu familia con nuestros planes exequiales
            </h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto" style="color: var(--color-dorado-suave);">
                Planifica con anticipación y brinda tranquilidad a tus seres queridos.
            </p>
            <a href="{{ route('contacto') }}" class="btn-dorado px-8 py-3 rounded-lg font-semibold text-lg inline-block mr-4">
                <i class="fas fa-phone mr-2"></i>
                Contáctenos
            </a>
            <a href="{{ route('planes') }}" class="inline-block px-8 py-3 rounded-lg font-semibold text-lg border-2 transition-colors" style="border-color: var(--color-dorado); color: var(--color-dorado);" onmouseover="this.style.background='var(--color-dorado)'; this.style.color='var(--color-negro)';" onmouseout="this.style.background='transparent'; this.style.color='var(--color-dorado)';">
                <i class="fas fa-file-contract mr-2"></i>
                Ver Planes
            </a>
        </div>
    </section>
@endsection
