@extends('layouts.public')

@section('title', 'Nuestros Servicios')

@section('content')
    {{-- Hero Servicios: cruz giratoria, vela, tipografía (estilo referencia con nuestros colores) --}}
    <section class="servicios-hero" id="servicios-hero">
        <x-particles class="servicios-hero__particles" />

        <svg class="servicios-hero__cruz" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <rect x="92" y="18" width="16" height="164" rx="3" fill="currentColor"/>
            <rect x="18" y="68" width="164" height="16" rx="3" fill="currentColor"/>
            <circle cx="100" cy="100" r="92" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <circle cx="100" cy="100" r="68" stroke="currentColor" stroke-width="0.5" fill="none" stroke-dasharray="4 6"/>
        </svg>

        <div class="servicios-hero__vela">
            <div class="servicios-hero__llama"></div>
            <div class="servicios-hero__pabilo"></div>
            <div class="servicios-hero__cuerpo-vela"></div>
            <div class="servicios-hero__base-vela"></div>
        </div>

        <div class="servicios-hero__ornamento">✦ Nuestros Servicios ✦</div>
        <h1 class="servicios-hero__titulo">
            Servicios
            <em class="servicios-hero__titulo-cursiva">con dignidad y respeto</em>
        </h1>
        <div class="servicios-hero__divisor"></div>
        <p class="servicios-hero__subtitulo">
            Coordinación del servicio, salas de velación, parque automotor,<br>
            velación virtual y parque crematorio. La más alta calidad para su familia.
        </p>
        <div class="servicios-hero__acciones">
            <a href="{{ route('planes') }}" class="servicios-hero__btn servicios-hero__btn--oro">Ver Planes</a>
            <a href="{{ route('contacto') }}" class="servicios-hero__btn servicios-hero__btn--borde">Contáctenos</a>
        </div>
        <div class="servicios-hero__scroll">
            <span>Descubrir</span>
            <div class="servicios-hero__scroll-linea"></div>
        </div>
    </section>

    <div class="page-servicios-content relative">
    @php
        $imgsServ = imagenes_para_vista('servicios', 5);
        $imgVelacion = $imgsServ[4] ?? null;
        $imgVelacionVirtual = $imgsServ[3] ?? null;
        $imgCremacion = $imgsServ[1] ?? $imgsServ[2] ?? null;
        $imgTraslados = $imgsServ[0] ?? null;
    @endphp

    <!-- Intro Servicio Funerario -->
    <section class="section-servicios-intro py-10 bg-white border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="section-title mb-4">Servicio Funerario</h2>
            <p class="text-lg text-gray-600 mb-6">
                Coordinación del servicio, salas de velación, parque automotor, velación virtual y parque crematorio. Estamos para ofrecer los servicios funerarios y asistencia exequial con la más alta calidad.
            </p>
            <a href="{{ route('login') }}" class="text-vinotinto font-semibold hover:underline">
                <i class="fas fa-search mr-1"></i>
                Consulte su Plan Exequial
            </a>
        </div>
    </section>

    <!-- Servicios Detallados -->
    <section class="py-16 bg-gray-50 section-reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-12">
                <!-- Salas de Velación -->
                <div class="servicio-card bg-white shadow-lg card-hover hover-lift border-l-4 reveal-on-scroll" style="border-left-color: var(--color-vinotinto);">
                    <div class="md:flex">
                        <div class="md:w-1/3 servicio-block-media flex items-center justify-center min-h-[220px]" style="background: linear-gradient(135deg, var(--color-vinotinto), #7a1a3d);">
                            @if($imgVelacion)
                                <img src="{{ asset($imgVelacion) }}" alt="Velación" class="servicio-block-img">
                            @else
                                <i class="fas fa-door-open text-white text-6xl"></i>
                            @endif
                        </div>
                        <div class="md:w-2/3 p-8">
                            <h2 class="servicio-card__title text-3xl font-bold mb-4 text-vinotinto">Salas de Velación</h2>
                            <p class="text-gray-600 mb-4">
                                Contamos con salas de velación amplias, cómodas y climatizadas para que usted y su familia puedan despedir a su ser querido con toda la dignidad y respeto que merece.
                            </p>
                            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                                <li>Salas con capacidad para diferentes grupos</li>
                                <li>Ambiente climatizado y cómodo</li>
                                <li>Servicio de cafetería</li>
                                <li>Estacionamiento disponible</li>
                                <li>Atención personalizada 24 horas</li>
                            </ul>
                            <a href="{{ route('contacto') }}" class="servicio-card__btn inline-block btn-vinotinto text-white">
                                Solicitar Información
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Velación Virtual -->
                <div class="servicio-card bg-white shadow-lg card-hover hover-lift border-l-4 reveal-on-scroll" style="border-left-color: var(--color-azul-oscuro);">
                    <div class="md:flex">
                        <div class="md:w-1/3 servicio-block-media flex items-center justify-center order-2 md:order-1 min-h-[220px]" style="background: linear-gradient(135deg, var(--color-azul-oscuro), #1e3a5f);">
                            @if($imgVelacionVirtual)
                                <img src="{{ asset($imgVelacionVirtual) }}" alt="Velación virtual" class="servicio-block-img">
                            @else
                                <i class="fas fa-video text-white text-6xl"></i>
                            @endif
                        </div>
                        <div class="md:w-2/3 p-8 order-1 md:order-2">
                            <h2 class="servicio-card__title text-3xl font-bold mb-4" style="color: var(--color-azul-oscuro);">Velación Virtual</h2>
                            <p class="text-gray-600 mb-4">
                                Para aquellos familiares y amigos que no pueden estar presentes físicamente, ofrecemos transmisión en vivo de alta calidad de la ceremonia de velación.
                            </p>
                            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                                <li>Transmisión en vivo HD</li>
                                <li>Acceso desde cualquier dispositivo</li>
                                <li>Grabación disponible</li>
                                <li>Sin límite de participantes</li>
                                <li>Enlace privado y seguro</li>
                            </ul>
                            <a href="{{ route('contacto') }}" class="servicio-card__btn inline-block text-white rounded-full" style="background: var(--color-azul-oscuro);" onmouseover="this.style.background='#1e3a5f';" onmouseout="this.style.background='var(--color-azul-oscuro)';">
                                Solicitar Información
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cremación -->
                <div class="servicio-card bg-white shadow-lg card-hover hover-lift border-l-4 reveal-on-scroll" style="border-left-color: var(--color-dorado);">
                    <div class="md:flex">
                        <div class="md:w-1/3 servicio-block-media flex items-center justify-center min-h-[220px] gradient-dorado">
                            @if($imgCremacion)
                                <img src="{{ asset($imgCremacion) }}" alt="Cremación" class="servicio-block-img">
                            @else
                                <i class="fas fa-fire text-white text-6xl"></i>
                            @endif
                        </div>
                        <div class="md:w-2/3 p-8">
                            <h2 class="servicio-card__title text-3xl font-bold mb-4 text-dorado">Parque Crematorio San José</h2>
                            <p class="text-gray-600 mb-4">
                                Servicio de cremación realizado con los más altos estándares de calidad, respeto y profesionalismo. Ofrecemos diferentes opciones de urnas y ceremonias.
                            </p>
                            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                                <li>Proceso certificado y garantizado</li>
                                <li>Amplia variedad de urnas</li>
                                <li>Ceremonia de despedida opcional</li>
                                <li>Asesoría en disposición final</li>
                                <li>Documentación completa</li>
                            </ul>
                            <a href="{{ route('contacto') }}" class="servicio-card__btn inline-block btn-dorado">
                                Solicitar Información
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Traslados -->
                <div class="servicio-card bg-white shadow-lg card-hover hover-lift border-l-4 reveal-on-scroll" style="border-left-color: var(--color-vinotinto);">
                    <div class="md:flex">
                        <div class="md:w-1/3 servicio-block-media flex items-center justify-center order-2 md:order-1 min-h-[220px] gradient-vinotinto">
                            @if($imgTraslados)
                                <img src="{{ asset($imgTraslados) }}" alt="Traslados" class="servicio-block-img">
                            @else
                                <i class="fas fa-car text-white text-6xl"></i>
                            @endif
                        </div>
                        <div class="md:w-2/3 p-8 order-1 md:order-2">
                            <h2 class="servicio-card__title text-3xl font-bold mb-4 text-vinotinto">Parque Automotor / Traslados</h2>
                            <p class="text-gray-600 mb-4">
                                Realizamos traslados a cualquier parte del país o del mundo, gestionando toda la documentación necesaria para que el proceso sea lo más sencillo posible para la familia.
                            </p>
                            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                                <li>Traslados nacionales</li>
                                <li>Traslados internacionales</li>
                                <li>Gestión de documentación</li>
                                <li>Vehículos especializados</li>
                                <li>Acompañamiento durante el proceso</li>
                            </ul>
                            <a href="{{ route('contacto') }}" class="servicio-card__btn inline-block btn-vinotinto text-white">
                                Solicitar Información
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA (estilo funerariasanjose.co) -->
    <section class="py-16 gradient-vinotinto text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg mb-4" style="color: var(--color-dorado-suave);">Contactarnos, tenemos planes diseñados para diversos núcleos familiares y acorde a tus necesidades.</p>
            <h2 class="text-3xl font-bold mb-4">¿Necesitas más información?</h2>
            <p class="text-xl mb-8" style="color: var(--color-dorado-suave);">Nuestro equipo está disponible para atenderte</p>
            <a href="{{ route('contacto') }}" class="btn-dorado px-8 py-3 rounded-lg font-semibold text-lg inline-block">
                <i class="fas fa-phone mr-2"></i>
                Contáctenos
            </a>
        </div>
    </section>
    </div>
@endsection

