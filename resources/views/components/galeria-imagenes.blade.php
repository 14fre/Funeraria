@props([
    'imagenes' => [],
    'maxColumnas' => 4,
    'clase' => '',
])

@if(count($imagenes) > 0)
    @php $cols = min(count($imagenes), $maxColumnas); @endphp
    <div class="service-images-strip service-images-strip--cols-{{ $cols }} reveal-on-scroll {{ $clase }}">
        @foreach($imagenes as $path)
            <div class="service-images-strip__item">
                <img src="{{ asset($path) }}" alt="Servicio funerario" loading="lazy" class="service-images-strip__img">
            </div>
        @endforeach
    </div>
@endif
