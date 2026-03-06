@extends('layouts.public')

@section('title', 'Contacto')

@section('content')
    {{-- Hero mismo tamaño que Servicios / Quiénes / Obituarios --}}
    <section class="custom-hero" id="hero-contacto">
        <x-particles class="custom-hero__particles" />
        <x-hero-decorative variant="contacto" class="custom-hero__symbol" />

        <div class="custom-hero__vela">
            <div class="custom-hero__llama"></div>
            <div class="custom-hero__pabilo"></div>
            <div class="custom-hero__cuerpo-vela"></div>
            <div class="custom-hero__base-vela"></div>
        </div>

        <div class="custom-hero__ornamento">✦ Contáctanos ✦</div>
        <h1 class="custom-hero__titulo">
            Contáctanos
            <em class="custom-hero__titulo-cursiva">estamos aquí para ayudarte</em>
        </h1>
        <div class="custom-hero__divisor"></div>
        <p class="custom-hero__subtitulo">
            Estamos aquí para ayudarte en todo momento. Escríbenos o llámanos.
        </p>
        <div class="custom-hero__acciones">
            <a href="#info" class="custom-hero__btn custom-hero__btn--oro">Ver información</a>
            <a href="{{ route('servicios') }}" class="custom-hero__btn custom-hero__btn--borde">Nuestros Servicios</a>
        </div>
        <div class="custom-hero__scroll">
            <span>Descubrir</span>
            <div class="custom-hero__scroll-linea"></div>
        </div>
    </section>

    @php $imgContacto = imagenes_para_vista('contacto', 1); @endphp
    @if(count($imgContacto) > 0)
        <section class="contacto-acento-img reveal-on-scroll">
            <div class="contacto-acento-img__inner hover-lift-img">
                <img src="{{ asset($imgContacto[0]) }}" alt="Contáctenos" loading="lazy">
            </div>
        </section>
    @endif

    <!-- Bloque destacado (estilo funerariasanjose.co) -->
    <section class="py-10 bg-white border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg text-gray-600 mb-6">
                Contactarnos, tenemos planes diseñados para diversos núcleos familiares y acorde a tus necesidades.
            </p>
            <div class="contacto-destacado-box">
                <h2 class="text-xl font-bold mb-2" style="color: var(--color-vinotinto);">Funerales San José del Huila SAS</h2>
                <p class="text-gray-700">{{ config('funeraria.direccion_principal') }}<br>{{ config('funeraria.ciudad') }}</p>
                <p class="text-gray-700 mt-2">Móvil: {{ implode(' - ', config('funeraria.telefonos', [])) }}</p>
                <p class="text-gray-700">{{ config('funeraria.email') }}</p>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="info" class="py-16 bg-gray-50 section-reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Información de Contacto -->
                <div>
                    <h2 class="section-title text-gray-900 mb-6">Información de Contacto</h2>
                    
                    <div class="space-y-6 mb-8">
                        <div class="flex items-start">
                            <div class="p-3 rounded-full mr-4 gradient-vinotinto">
                                <i class="fas fa-phone text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Teléfono</h3>
                                @php $phones = config('funeraria.telefonos', []); @endphp
                                <p class="text-gray-600">{{ count($phones) ? implode(' - ', $phones) : '(608) 871-2345' }}</p>
                                <p class="text-sm text-gray-500">Lunes a Viernes: 8:00 AM - 6:00 PM</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="p-3 rounded-full mr-4" style="background: linear-gradient(135deg, var(--color-azul-oscuro), #1e3a5f);">
                                <i class="fas fa-envelope text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">{{ config('funeraria.email', 'info@funerariasanjose.co') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="p-3 rounded-full mr-4 gradient-dorado">
                                <i class="fas fa-map-marker-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Dirección principal</h3>
                                <p class="text-gray-600">{{ config('funeraria.direccion_principal') }}<br>{{ config('funeraria.ciudad') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="p-3 rounded-full mr-4 gradient-dorado">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Emergencias 24/7</h3>
                                <p class="text-gray-600">Disponibles las 24 horas del día, los 365 días del año</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sedes -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-gray-900 mb-4">Nuestras sedes</h3>
                        <div class="sedes-list sedes-list--cards">
                            @foreach(config('funeraria.sedes', []) as $sede)
                                @php
                                    $dirMaps = $sede['direccion'] . (!empty($sede['detalle']) ? ' ' . $sede['detalle'] : '') . ', Colombia';
                                    $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($dirMaps);
                                @endphp
                                <div class="sede-item">
                                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="sede-item__maps-wrap" title="Ver ubicación en Google Maps">
                                        <div class="sede-item__icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="sede-item__content">
                                            <strong class="sede-item__nombre">{{ $sede['nombre'] }}</strong>
                                            <span class="sede-item__direccion">{{ $sede['direccion'] }}{{ !empty($sede['detalle']) ? ' - ' . $sede['detalle'] : '' }}</span>
                                        </div>
                                    </a>
                                    <a href="tel:{{ preg_replace('/\D/', '', $sede['telefono']) }}" class="sede-item__telefono">Cel. {{ $sede['telefono'] }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Redes Sociales (colores de marca) -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Síguenos</h3>
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" class="p-3 rounded-full transition-colors" style="background: var(--color-vinotinto); color: white;" onmouseover="this.style.background='var(--color-dorado)'; this.style.color='var(--color-negro)';" onmouseout="this.style.background='var(--color-vinotinto)'; this.style.color='white';">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/funerariasanjosedelhuila" target="_blank" rel="noopener noreferrer" class="p-3 rounded-full transition-colors" style="background: var(--color-vinotinto); color: white;" onmouseover="this.style.background='var(--color-dorado)'; this.style.color='var(--color-negro)';" onmouseout="this.style.background='var(--color-vinotinto)'; this.style.color='white';">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @php $wa = config('services.whatsapp.number', '573186298729'); @endphp
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $wa) }}" target="_blank" rel="noopener noreferrer" class="p-3 rounded-full bg-green-600 text-white hover:bg-green-700 transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Contacto (contenedor ajustado al contenido) -->
                <div class="contacto-form-card bg-white rounded-xl shadow-lg p-6 hover-lift self-start">
                    <h2 class="section-title text-gray-900 mb-5">Envíanos un mensaje</h2>
                    <form action="#" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" 
                                   id="nombre"
                                   name="nombre"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg input-focus-funeraria">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" 
                                   id="email"
                                   name="email"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg input-focus-funeraria">
                        </div>
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="tel" 
                                   id="telefono"
                                   name="telefono"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg input-focus-funeraria">
                        </div>
                        <div>
                            <label for="asunto" class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                            <input type="text" 
                                   id="asunto"
                                   name="asunto"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg input-focus-funeraria">
                        </div>
                        <div>
                            <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                            <textarea id="mensaje"
                                      name="mensaje"
                                      rows="3"
                                      required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg input-focus-funeraria"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full btn-vinotinto text-white py-2.5 rounded-xl font-semibold mt-1 transition-all hover:opacity-90">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

