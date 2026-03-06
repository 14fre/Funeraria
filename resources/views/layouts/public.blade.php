<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Funeraria San José del Huila')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icono.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/icono.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icono.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Cinzel:wght@400;500;700&family=EB+Garamond:ital,wght@0,400;1,400&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/public.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="font-sans antialiased">
    <!-- Barra superior: redes y contacto (estilo funerariasanjose.co) -->
    <div class="nav-top">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-9 text-sm">
            <span class="text-white/90 hidden sm:inline">{{ config('funeraria.ciudad', 'Neiva - Huila') }}</span>
            <div class="flex items-center gap-4">
                <a href="https://www.instagram.com/funerariasanjosedelhuila" target="_blank" rel="noopener noreferrer" class="text-white/90 hover:text-dorado transition-colors" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" class="text-white/90 hover:text-dorado transition-colors" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                @php $wa = config('services.whatsapp.number', '573186298729'); @endphp
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $wa) }}" target="_blank" rel="noopener noreferrer" class="text-white/90 hover:text-dorado transition-colors" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-dorado">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        @php
                            $logoPath = null;
                            if (file_exists(public_path('images/FUNE.jpeg'))) {
                                $logoPath = asset('images/FUNE.jpeg');
                            } elseif (file_exists(public_path('images/logo-funeraria-san-jose.png'))) {
                                $logoPath = asset('images/logo-funeraria-san-jose.png');
                            } elseif (file_exists(public_path('images/logo-funeraria-san-jose.webp'))) {
                                $logoPath = asset('images/logo-funeraria-san-jose.webp');
                            }
                        @endphp
                        @if($logoPath)
                            <img src="{{ $logoPath }}" alt="Funeraria San José" class="h-10 md:h-12 w-auto object-contain">
                        @else
                            <i class="fas fa-cross text-dorado text-2xl"></i>
                            <span class="text-xl font-bold" style="color: var(--color-vinotinto);">Funeraria San José</span>
                        @endif
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-dorado transition-colors font-medium {{ request()->routeIs('home') ? 'text-dorado font-semibold border-b-2 border-dorado pb-1' : '' }}">
                        Inicio
                    </a>
                    <a href="{{ route('quienes-somos') }}" 
                       class="text-gray-700 hover:text-dorado transition-colors font-medium {{ request()->routeIs('quienes-somos') ? 'text-dorado font-semibold border-b-2 border-dorado pb-1' : '' }}">
                        Quiénes Somos
                    </a>
                    <a href="{{ route('servicios') }}" 
                       class="text-gray-700 hover:text-dorado transition-colors font-medium {{ request()->routeIs('servicios') ? 'text-dorado font-semibold border-b-2 border-dorado pb-1' : '' }}">
                        Servicios
                    </a>
                    <a href="{{ route('planes') }}" 
                       class="text-gray-700 hover:text-dorado transition-colors font-medium {{ request()->routeIs('planes') ? 'text-dorado font-semibold border-b-2 border-dorado pb-1' : '' }}">
                        Planes
                    </a>
                    <a href="{{ route('obituarios') }}" 
                       class="text-gray-700 hover:text-dorado transition-colors font-medium {{ request()->routeIs('obituarios') ? 'text-dorado font-semibold border-b-2 border-dorado pb-1' : '' }}">
                        Obituarios
                    </a>
                    <a href="{{ route('contacto') }}" 
                       class="text-gray-700 hover:text-dorado transition-colors font-medium {{ request()->routeIs('contacto') ? 'text-dorado font-semibold border-b-2 border-dorado pb-1' : '' }}">
                        Contacto
                    </a>
                    
                    @auth
                        <a href="{{ auth()->user()->getDashboardRoute() }}" 
                           class="btn-dorado px-4 py-2 rounded-lg">
                            Mi Cuenta
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-dorado transition-colors font-medium">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" 
                           class="btn-vinotinto px-4 py-2 rounded-lg text-white">
                            Registrarse
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-yellow-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Inicio</a>
                <a href="{{ route('quienes-somos') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Quiénes Somos</a>
                <a href="{{ route('servicios') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Servicios</a>
                <a href="{{ route('planes') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Planes</a>
                <a href="{{ route('obituarios') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Obituarios</a>
                <a href="{{ route('contacto') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Contacto</a>
                @auth
                    <a href="{{ auth()->user()->getDashboardRoute() }}" class="block px-3 py-2 bg-yellow-500 text-white rounded-md">Mi Cuenta</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 bg-red-600 text-white rounded-md">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer (estilo funerariasanjose.co) -->
    <footer class="mt-16 footer-public">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Datos de contacto destacados -->
            <div class="text-center mb-10">
                <h3 class="text-xl font-bold mb-2" style="color: var(--color-dorado);">Funerales San José del Huila SAS</h3>
                <p class="text-white/90">{{ config('funeraria.direccion_principal') }}<br>{{ config('funeraria.ciudad') }}</p>
                <p class="text-white/90 mt-1">Móvil: {{ implode(' - ', config('funeraria.telefonos', [])) }}<br>{{ config('funeraria.email') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <div>
                    <h4 class="footer-title">Nuestro Equipo</h4>
                    <p class="text-sm text-white/80">Contamos con personal idóneo, altamente calificado, gestionando y respondiendo a sus necesidades en el momento que más lo necesita.</p>
                </div>
                <div>
                    <h4 class="footer-title">Quiénes Somos</h4>
                    <ul class="space-y-1 text-sm">
                        <li><a href="{{ route('quienes-somos') }}" class="text-white/80 hover:text-dorado transition-colors">Nuestra Historia</a></li>
                        <li><a href="{{ route('quienes-somos') }}#mision" class="text-white/80 hover:text-dorado transition-colors">Misión y Visión</a></li>
                        <li><a href="{{ route('quienes-somos') }}#sedes" class="text-white/80 hover:text-dorado transition-colors">Sedes</a></li>
                        <li><a href="{{ route('servicios') }}" class="text-white/80 hover:text-dorado transition-colors">Servicios</a></li>
                        <li><a href="{{ route('contacto') }}" class="text-white/80 hover:text-dorado transition-colors">Contáctenos</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-title">Servicios</h4>
                    <ul class="space-y-1 text-sm">
                        <li><a href="{{ route('servicios') }}" class="text-white/80 hover:text-dorado transition-colors">Coordinación Servicio</a></li>
                        <li><a href="{{ route('servicios') }}" class="text-white/80 hover:text-dorado transition-colors">Salas de Velación</a></li>
                        <li><a href="{{ route('servicios') }}" class="text-white/80 hover:text-dorado transition-colors">Parque Automotor</a></li>
                        <li><a href="{{ route('servicios') }}" class="text-white/80 hover:text-dorado transition-colors">Velación Virtual</a></li>
                        <li><a href="{{ route('servicios') }}" class="text-white/80 hover:text-dorado transition-colors">Parque Crematorio</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-title">Planes Exequiales</h4>
                    <ul class="space-y-1 text-sm">
                        <li><a href="{{ route('planes') }}" class="text-white/80 hover:text-dorado transition-colors">Ver planes</a></li>
                        <li><a href="{{ route('contacto') }}" class="text-white/80 hover:text-dorado transition-colors">Contactenos</a></li>
                    </ul>
                </div>
            </div>

            <!-- Sedes en fila (como en funerariasanjose.co) -->
            <div class="footer-sedes-row">
                @foreach(config('funeraria.sedes', []) as $sede)
                    @php
                        $dirMaps = $sede['direccion'] . (!empty($sede['detalle']) ? ' ' . $sede['detalle'] : '') . ', Colombia';
                        $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($dirMaps);
                    @endphp
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="footer-sede-card" title="Ver ubicación en Google Maps">
                        <div class="footer-sede-card__icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="footer-sede-card__nombre">{{ $sede['nombre'] }}</span>
                        <span class="footer-sede-card__direccion">{{ $sede['direccion'] }}{{ !empty($sede['detalle']) ? ' ' . $sede['detalle'] : '' }}</span>
                        <span class="footer-sede-card__tel-wrap"><a href="tel:{{ preg_replace('/\D/', '', $sede['telefono']) }}" class="footer-sede-card__tel" onclick="event.stopPropagation()">Cel. {{ $sede['telefono'] }}</a></span>
                    </a>
                @endforeach
            </div>

            <div class="border-t border-white/20 mt-10 pt-8 text-center text-sm text-white/70">
                <p>&copy; {{ date('Y') }} Funerales San José del Huila S.A.S.</p>
                <p class="mt-1 text-xs">Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    @php
        $whatsappNumber = config('services.whatsapp.number', '573186298729');
        $whatsappUrl = 'https://wa.me/' . preg_replace('/\D/', '', $whatsappNumber);
    @endphp
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="whatsapp-float" title="Contactar por WhatsApp" aria-label="Abrir WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <button type="button" class="to-top" id="to-top" aria-label="Volver arriba" title="Volver arriba">
        <i class="fas fa-chevron-up"></i>
    </button>

    @if(!request()->routeIs('home'))
    <a href="{{ route('home') }}" class="back-float" id="back-float" aria-label="Volver" title="Volver">
        <i class="fas fa-arrow-left"></i>
        <span class="back-float__text">Volver</span>
    </a>
    @endif

    <!-- Angelito / mascota flotante (solo sitio público) -->
    <div class="mascot-angel" aria-hidden="true">
        <span class="mascot-angel__halo" aria-hidden="true"></span>
        <i class="fas fa-dove mascot-angel__icon"></i>
    </div>

    @livewireScripts

    <script>
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        (function() {
            var els = document.querySelectorAll('.reveal-on-scroll');
            if (!els.length) return;
            var io = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) entry.target.classList.add('is-visible');
                });
            }, { rootMargin: '0px 0px -40px 0px', threshold: 0.1 });
            els.forEach(function(el) { io.observe(el); });
        })();
        (function() {
            var container = document.getElementById('hero-phrases');
            var dotsContainer = document.getElementById('hero-phrases-dots');
            if (!container || !dotsContainer) return;
            var phrases = container.querySelectorAll('.hero-phrase');
            if (phrases.length <= 1) return;
            var current = 0, nextTimeout;
            function updateDots() {
                var dots = dotsContainer.querySelectorAll('.hero-phrases-dot');
                dots.forEach(function(dot, i) { dot.classList.toggle('is-active', i === current); });
            }
            for (var i = 0; i < phrases.length; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'hero-phrases-dot' + (i === 0 ? ' is-active' : '');
                dot.setAttribute('aria-label', 'Frase ' + (i + 1));
                (function(idx) {
                    dot.addEventListener('click', function() {
                        clearTimeout(nextTimeout);
                        phrases[current].classList.remove('is-visible', 'is-exiting');
                        current = idx;
                        phrases[current].classList.add('is-visible');
                        updateDots();
                        nextTimeout = setTimeout(goNext, 5200);
                    });
                })(i);
                dotsContainer.appendChild(dot);
            }
            function goNext() {
                phrases[current].classList.add('is-exiting');
                setTimeout(function() {
                    phrases[current].classList.remove('is-visible', 'is-exiting');
                    current = (current + 1) % phrases.length;
                    phrases[current].classList.add('is-visible');
                    updateDots();
                    nextTimeout = setTimeout(goNext, 5200);
                }, 620);
            }
            nextTimeout = setTimeout(goNext, 5200);
        })();
        (function initCarousels() {
            var carousels = document.querySelectorAll('.carousel-imagenes');
            carousels.forEach(function(carousel) {
                var track = carousel.querySelector('.carousel-imagenes__track');
                var slides = carousel.querySelectorAll('.carousel-imagenes__slide');
                var dotsWrap = carousel.querySelector('.carousel-imagenes__dots');
                var btnPrev = carousel.querySelector('.carousel-imagenes__btn--prev');
                var btnNext = carousel.querySelector('.carousel-imagenes__btn--next');
                var autoplayMs = parseInt(carousel.getAttribute('data-autoplay'), 10) || 4500;
                if (!track || slides.length === 0) return;
                slides[0].classList.add('is-active');
                var idx = 0, autoplayTimer;
                function goTo(i) {
                    slides[idx].classList.remove('is-active');
                    idx = (i + slides.length) % slides.length;
                    slides[idx].classList.add('is-active');
                    if (dotsWrap) {
                        var dots = dotsWrap.querySelectorAll('.carousel-imagenes__dot');
                        dots.forEach(function(d, k) { d.classList.toggle('is-active', k === idx); });
                    }
                }
                if (slides.length > 1 && dotsWrap) {
                    for (var d = 0; d < slides.length; d++) {
                        var dot = document.createElement('button');
                        dot.type = 'button';
                        dot.className = 'carousel-imagenes__dot' + (d === 0 ? ' is-active' : '');
                        dot.setAttribute('aria-label', 'Ir a imagen ' + (d + 1));
                        (function(k) { dot.addEventListener('click', function() { goTo(k); resetAutoplay(); }); })(d);
                        dotsWrap.appendChild(dot);
                    }
                }
                function resetAutoplay() {
                    clearInterval(autoplayTimer);
                    autoplayTimer = setInterval(function() { goTo(idx + 1); }, autoplayMs);
                }
                if (btnPrev) btnPrev.addEventListener('click', function() { goTo(idx - 1); resetAutoplay(); });
                if (btnNext) btnNext.addEventListener('click', function() { goTo(idx + 1); resetAutoplay(); });
                if (slides.length > 1 && autoplayMs > 0) autoplayTimer = setInterval(function() { goTo(idx + 1); }, autoplayMs);
            });
        })();
        (function toTop() {
            var btn = document.getElementById('to-top');
            if (!btn) return;
            function show() {
                if (window.scrollY > 400) btn.classList.add('is-visible');
                else btn.classList.remove('is-visible');
            }
            window.addEventListener('scroll', show, { passive: true });
            show();
            btn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        })();
        (function backFloat() {
            var back = document.getElementById('back-float');
            if (!back) return;
            back.addEventListener('click', function(e) {
                if (window.history.length > 1) {
                    e.preventDefault();
                    window.history.back();
                }
            });
        })();
        (function particlesBg() {
            var canvas = document.getElementById('particles-bg');
            if (!canvas) return;
            var ctx = canvas.getContext('2d');
            function resize() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
            }
            resize();
            window.addEventListener('resize', resize);
            function Particula() {
                this.reset = function() {
                    this.x = Math.random() * (canvas.width || 1);
                    this.y = Math.random() * (canvas.height || 1);
                    this.radio = Math.random() * 1.4 + 0.3;
                    this.opacidad = Math.random() * 0.35 + 0.06;
                    this.vy = -(Math.random() * 0.35 + 0.08);
                    this.vx = (Math.random() - 0.5) * 0.18;
                    this.vida = 0;
                    this.maxVida = Math.random() * 180 + 90;
                };
                this.reset();
            }
            Particula.prototype.update = function() {
                this.x += this.vx;
                this.y += this.vy;
                this.vida++;
                if (this.vida > this.maxVida || this.y < -8) this.reset();
            };
            Particula.prototype.draw = function() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radio, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255, 215, 0, ' + this.opacidad + ')';
                ctx.fill();
            };
            var particulas = Array.from({ length: 70 }, function() { return new Particula(); });
            function animar() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particulas.forEach(function(p) { p.update(); p.draw(); });
                requestAnimationFrame(animar);
            }
            animar();
        })();
        (function starsInteractive() {
            var container = document.getElementById('stars-interactive');
            var canvas = document.getElementById('stars-canvas');
            var namedEl = document.getElementById('stars-named');
            if (!container || !canvas || !namedEl) return;
            var ctx = canvas.getContext('2d');
            var mouse = { x: -9999, y: -9999 };
            var stars = [];
            var parallaxStrength = 25;
            function resize() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
                if (stars.length === 0) {
                    for (var i = 0; i < 80; i++) {
                        stars.push({
                            x: Math.random() * canvas.width,
                            y: Math.random() * canvas.height,
                            baseX: 0, baseY: 0,
                            r: Math.random() * 1.2 + 0.4,
                            opacity: Math.random() * 0.4 + 0.1
                        });
                    }
                    stars.forEach(function(s, i) {
                        s.baseX = s.x;
                        s.baseY = s.y;
                    });
                }
            }
            container.addEventListener('mousemove', function(e) {
                var rect = container.getBoundingClientRect();
                mouse.x = e.clientX - rect.left;
                mouse.y = e.clientY - rect.top;
            });
            container.addEventListener('click', function(e) {
                var rect = container.getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;
                var name = window.prompt('Nombre para esta estrella (memorial):', '');
                if (name == null || !name.trim()) return;
                var div = document.createElement('div');
                div.className = 'stars-interactive__named-star';
                div.textContent = name.trim();
                div.style.left = (x / rect.width * 100) + '%';
                div.style.top = (y / rect.height * 100) + '%';
                namedEl.appendChild(div);
            });
            function draw() {
                if (!canvas.width || !canvas.height) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                stars.forEach(function(s) {
                    var dx = mouse.x - s.x;
                    var dy = mouse.y - s.y;
                    var dist = Math.sqrt(dx * dx + dy * dy) || 1;
                    var force = Math.min(parallaxStrength / dist, 8);
                    var ox = (dx / dist) * force;
                    var oy = (dy / dist) * force;
                    ctx.beginPath();
                    ctx.arc(s.baseX + ox, s.baseY + oy, s.r, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(255, 215, 0, ' + s.opacity + ')';
                    ctx.fill();
                });
                requestAnimationFrame(draw);
            }
            resize();
            window.addEventListener('resize', resize);
            draw();
        })();
        (function riverOfLight() {
            var river = document.getElementById('river-of-light');
            if (!river) return; /* Solo en Obituarios */
            var stream = river.querySelector('.river-of-light__stream');
            if (!stream) return;
            function update() {
                var y = (window.scrollY || 0) % (window.innerHeight * 1.5);
                stream.style.transform = 'translateY(' + y + 'px)';
            }
            window.addEventListener('scroll', update, { passive: true });
            update();
        })();
    </script>
</body>
</html>

