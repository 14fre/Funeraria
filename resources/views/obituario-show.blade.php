@extends('layouts.public')

@section('title', $obituario->nombre_completo . ' - Obituario')

@section('content')
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('obituarios') }}" 
               class="text-red-600 hover:text-red-700 mb-6 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a Obituarios
            </a>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Foto -->
                @if($obituario->foto)
                    <img src="{{ asset('storage/' . $obituario->foto) }}" 
                         alt="{{ $obituario->nombre_completo }}"
                         class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-8xl"></i>
                    </div>
                @endif

                <!-- Contenido -->
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $obituario->nombre_completo }}</h1>
                    
                    @if($obituario->fecha_nacimiento)
                        <p class="text-gray-600 text-lg mb-2">
                            {{ $obituario->fecha_nacimiento->format('d/m/Y') }} - 
                            {{ $obituario->fecha_fallecimiento->format('d/m/Y') }}
                        </p>
                    @else
                        <p class="text-gray-600 text-lg mb-2">
                            Falleció el {{ $obituario->fecha_fallecimiento->format('d/m/Y') }}
                        </p>
                    @endif

                    @if($obituario->lugar_fallecimiento)
                        <p class="text-gray-500 mb-6">{{ $obituario->lugar_fallecimiento }}</p>
                    @endif

                    @if($obituario->biografia)
                        <div class="mb-6">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-3">Biografía</h2>
                            <p class="text-gray-700 leading-relaxed">{{ $obituario->biografia }}</p>
                        </div>
                    @endif

                    @if($obituario->mensaje_familia)
                        <div class="mb-6 bg-red-50 p-6 rounded-lg border-l-4 border-red-500">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">Mensaje de la Familia</h2>
                            <p class="text-gray-700 italic">{{ $obituario->mensaje_familia }}</p>
                        </div>
                    @endif

                    <!-- Información de Velación y Sepultura -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        @if($obituario->fecha_velacion)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-door-open text-red-600 mr-2"></i>
                                    Velación
                                </h3>
                                <p class="text-gray-700">{{ $obituario->fecha_velacion->format('d/m/Y') }}</p>
                                @if($obituario->lugar_velacion)
                                    <p class="text-gray-600 text-sm">{{ $obituario->lugar_velacion }}</p>
                                @endif
                            </div>
                        @endif

                        @if($obituario->fecha_sepultura)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-monument text-gray-600 mr-2"></i>
                                    Sepultura
                                </h3>
                                <p class="text-gray-700">{{ $obituario->fecha_sepultura->format('d/m/Y') }}</p>
                                @if($obituario->lugar_sepultura)
                                    <p class="text-gray-600 text-sm">{{ $obituario->lugar_sepultura }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Condolencias -->
                    <div class="border-t pt-6">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Condolencias</h2>
                        @php
                            $condolencias = $obituario->condolenciasAprobadas()->orderBy('created_at', 'desc')->get();
                        @endphp

                        @if($condolencias->count() > 0)
                            <div class="space-y-4 mb-6">
                                @foreach($condolencias as $condolencia)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-900">{{ $condolencia->nombre }}</h4>
                                            <span class="text-xs text-gray-500">{{ $condolencia->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <p class="text-gray-700">{{ $condolencia->mensaje }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 mb-6">Aún no hay condolencias publicadas.</p>
                        @endif

                        <!-- Formulario de Condolencias -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-4">Deja tu condolencia</h3>
                            <form action="#" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <input type="text" 
                                           name="nombre"
                                           placeholder="Tu nombre"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                </div>
                                <div>
                                    <input type="email" 
                                           name="email"
                                           placeholder="Tu email (opcional)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                </div>
                                <div>
                                    <textarea name="mensaje"
                                              rows="3"
                                              placeholder="Tu mensaje de condolencia"
                                              required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"></textarea>
                                </div>
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Enviar Condolencia
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

