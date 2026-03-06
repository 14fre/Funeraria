@php
    $sedes = config('funeraria.sedes', []);
@endphp
@if(count($sedes) > 0)
    <div class="sedes-list">
        @foreach($sedes as $sede)
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
                        <span class="sede-item__direccion">{{ $sede['direccion'] }}{{ isset($sede['detalle']) && $sede['detalle'] ? ' - ' . $sede['detalle'] : '' }}</span>
                    </div>
                </a>
                <a href="tel:{{ preg_replace('/\D/', '', $sede['telefono']) }}" class="sede-item__telefono">Cel. {{ $sede['telefono'] }}</a>
            </div>
        @endforeach
    </div>
@endif
