@extends('layouts.public')

@section('title', 'Planes Exequiales')

@section('content')
    {{-- Hero mismo tamaño que Servicios / Quiénes / Obituarios --}}
    <section class="custom-hero" id="hero-planes">
        <x-particles class="custom-hero__particles" />
        <x-hero-decorative variant="planes" class="custom-hero__symbol" />

        <div class="custom-hero__vela">
            <div class="custom-hero__llama"></div>
            <div class="custom-hero__pabilo"></div>
            <div class="custom-hero__cuerpo-vela"></div>
            <div class="custom-hero__base-vela"></div>
        </div>

        <div class="custom-hero__ornamento">✦ Planes Exequiales ✦</div>
        <h1 class="custom-hero__titulo">
            Planes Exequiales
            <em class="custom-hero__titulo-cursiva">protege a tu familia</em>
        </h1>
        <div class="custom-hero__divisor"></div>
        <p class="custom-hero__subtitulo">
            Planes de previsión exequial para ti y los tuyos. Calidad y respeto.
        </p>
        <div class="custom-hero__acciones">
            <a href="#planes-list" class="custom-hero__btn custom-hero__btn--oro">Ver planes</a>
            <a href="{{ route('contacto') }}" class="custom-hero__btn custom-hero__btn--borde">Contáctenos</a>
        </div>
        <div class="custom-hero__scroll">
            <span>Descubrir</span>
            <div class="custom-hero__scroll-linea"></div>
        </div>
    </section>

    @php $imgsPlanes = imagenes_para_vista('planes', 2); @endphp
    @if(count($imgsPlanes) > 0)
        <section class="imagenes-planes-acento reveal-on-scroll">
            <div class="imagenes-planes-acento__inner hover-lift-img">
                <img src="{{ asset($imgsPlanes[0]) }}" alt="Planes exequiales" loading="lazy">
            </div>
        </section>
    @endif

    <!-- Nuestros Planes Exequiales: bloque destacado -->
    <section class="planes-intro-section">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="planes-intro-box">
                <div class="planes-intro-box__icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <h2 class="section-title mb-4">
                    Nuestros Planes Exequiales
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-0">
                    Los planes exequiales de <strong>Funerales San José del Huila SAS</strong> están diseñados para cubrir por el periodo de un año extensible por el tiempo que deseen nuestros afiliados, e incluyen protección para todas las personas de los núcleos familiares de los colombianos.
                </p>
            </div>
        </div>
    </section>

    <!-- Tarjetas de planes -->
    <section id="planes-list" class="py-16 bg-gray-50 section-reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $planes = \App\Models\PlanExequial::where('activo', true)->get();
            @endphp

            @if($planes->count() > 0)
                <p class="text-center text-gray-600 mb-10 max-w-2xl mx-auto reveal-on-scroll">
                    Elija el plan que mejor se adapte a su núcleo familiar. Todos incluyen cobertura exequial y la posibilidad de afiliar beneficiarios.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($planes as $index => $plan)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover hover-lift border-2 relative planes-card reveal-on-scroll" style="border-color: var(--color-dorado);">
                            <span class="plan-number-badge" aria-hidden="true">{{ $index + 1 }}</span>
                            <!-- Header del Plan -->
                            <div class="gradient-vinotinto text-white p-6 text-center">
                                <h3 class="text-2xl font-bold mb-2">{{ $plan->nombre }}</h3>
                                <p class="text-sm" style="color: var(--color-dorado-suave);">{{ $plan->descripcion }}</p>
                            </div>

                            <!-- Precios -->
                            <div class="p-6 border-b">
                                <div class="text-center mb-4">
                                    <span class="text-4xl font-bold text-gray-900">
                                        ${{ number_format((float)($plan->precio_mensual ?? 0), 0, ',', '.') }}
                                    </span>
                                    <span class="text-gray-600">/mes</span>
                                </div>
                                <div class="text-center">
                                    <span class="text-lg text-gray-600">Anual: </span>
                                    <span class="text-xl font-semibold text-gray-900">
                                        ${{ number_format((float)($plan->precio_anual ?? 0), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Características -->
                            <div class="p-6">
                                <ul class="space-y-3 mb-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                        <span class="text-gray-700">Hasta {{ $plan->max_beneficiarios }} beneficiario{{ $plan->max_beneficiarios > 1 ? 's' : '' }}</span>
                                    </li>
                                    @if($plan->servicios_incluidos)
                                        @foreach(array_slice($plan->servicios_incluidos, 0, 3) as $servicio)
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                                <span class="text-gray-700">{{ ucfirst(str_replace('_', ' ', $servicio)) }}</span>
                                            </li>
                                        @endforeach
                                        @if(count($plan->servicios_incluidos) > 3)
                                            <li class="text-gray-500 text-sm">
                                                +{{ count($plan->servicios_incluidos) - 3 }} servicios más
                                            </li>
                                        @endif
                                    @endif
                                </ul>

                                @auth
                                    <a href="{{ auth()->user()->getDashboardRoute() }}" 
                                       class="block w-full btn-vinotinto text-white text-center py-2 rounded-lg">
                                        Ver en mi cuenta
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" 
                                       class="block w-full btn-vinotinto text-white text-center py-2 rounded-lg">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Afiliarse
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-contract text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-600 text-lg">No hay planes disponibles en este momento.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Beneficios -->
    <section class="py-16 bg-white planes-beneficios">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal-on-scroll">
                <h2 class="section-title mb-2">Beneficios de nuestros planes</h2>
                <p class="text-gray-600 max-w-xl mx-auto">Protección, tranquilidad y precios pensados en tu familia.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="planes-beneficio-item text-center reveal-on-scroll">
                    <div class="planes-beneficio-item__icon gradient-dorado">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-vinotinto">Protección Garantizada</h3>
                    <p class="text-gray-600">Tu familia estará protegida ante cualquier eventualidad</p>
                </div>
                <div class="planes-beneficio-item text-center reveal-on-scroll">
                    <div class="planes-beneficio-item__icon gradient-vinotinto">
                        <i class="fas fa-dollar-sign text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-vinotinto">Precios Accesibles</h3>
                    <p class="text-gray-600">Planes adaptados a diferentes necesidades y presupuestos</p>
                </div>
                <div class="planes-beneficio-item text-center reveal-on-scroll">
                    <div class="planes-beneficio-item__icon gradient-dorado">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-dorado">Tranquilidad</h3>
                    <p class="text-gray-600">Planifica con anticipación y brinda paz a tus seres queridos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Planes -->
    <section class="py-16 gradient-vinotinto text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg mb-4" style="color: var(--color-dorado-suave);">Contactarnos, tenemos planes diseñados para diversos núcleos familiares y acorde a tus necesidades.</p>
            <h2 class="text-2xl md:text-3xl font-bold mb-8">¿Listo para proteger a tu familia?</h2>
            <a href="{{ route('contacto') }}" class="btn-dorado px-8 py-3 rounded-lg font-semibold text-lg inline-block mr-4">
                <i class="fas fa-phone mr-2"></i>
                Contáctenos
            </a>
            @guest
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 rounded-lg font-semibold text-lg border-2 transition-colors" style="border-color: var(--color-dorado); color: var(--color-dorado);" onmouseover="this.style.background='var(--color-dorado)'; this.style.color='var(--color-negro)';" onmouseout="this.style.background='transparent'; this.style.color='var(--color-dorado)';">
                    <i class="fas fa-user-plus mr-2"></i>
                    Afiliarse
                </a>
            @endguest
        </div>
    </section>
@endsection

