<a href="{{ url('/') }}" class="inline-block focus:outline-none text-center">
    @php
        $authLogo = null;
        if (file_exists(public_path('images/FUNE.jpeg'))) {
            $authLogo = asset('images/FUNE.jpeg');
        } elseif (file_exists(public_path('images/logo-funeraria-san-jose.png'))) {
            $authLogo = asset('images/logo-funeraria-san-jose.png');
        } elseif (file_exists(public_path('images/logo-funeraria-san-jose.webp'))) {
            $authLogo = asset('images/logo-funeraria-san-jose.webp');
        }
    @endphp
    @if($authLogo)
        <img src="{{ $authLogo }}" alt="Funeraria San José" class="auth-card-logo-img h-14 md:h-16 w-auto mx-auto object-contain">
    @else
        <div class="auth-logo-funeraria">
            <i class="fas fa-cross"></i>
        </div>
    @endif
</a>
