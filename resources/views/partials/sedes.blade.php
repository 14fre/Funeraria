@php
    $sedes = config('funeraria.sedes', []);
@endphp
@if(count($sedes) > 0)
    <div class="sedes-list">
        @foreach($sedes as $sede)
            <div class="sede-item">
                <div class="sede-item__icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="sede-item__content">
                    <strong class="sede-item__nombre">{{ $sede['nombre'] }}</strong>
                    <span class="sede-item__direccion">{{ $sede['direccion'] }}{{ isset($sede['detalle']) && $sede['detalle'] ? ' - ' . $sede['detalle'] : '' }}</span>
                    <a href="tel:{{ preg_replace('/\D/', '', $sede['telefono']) }}" class="sede-item__telefono">Cel. {{ $sede['telefono'] }}</a>
                </div>
            </div>
        @endforeach
    </div>
@endif
