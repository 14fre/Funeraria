@props([
    'imagenes' => [],
    'id' => 'carousel-imagenes',
    'autoplayMs' => 4500,
    'class' => '',
])

@if(count($imagenes) > 0)
    <div class="carousel-imagenes reveal-on-scroll {{ $class }}" id="{{ $id }}" data-autoplay="{{ $autoplayMs }}">
        <div class="carousel-imagenes__track">
            @foreach($imagenes as $path)
                <div class="carousel-imagenes__slide">
                    <img src="{{ asset($path) }}" alt="Servicio funerario" loading="lazy" class="carousel-imagenes__img">
                </div>
            @endforeach
        </div>
        @if(count($imagenes) > 1)
            <button type="button" class="carousel-imagenes__btn carousel-imagenes__btn--prev" aria-label="Anterior">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="carousel-imagenes__btn carousel-imagenes__btn--next" aria-label="Siguiente">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="carousel-imagenes__dots" role="tablist"></div>
        @endif
    </div>
@endif
