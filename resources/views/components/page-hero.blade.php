@props([
    'title',
    'subtitle' => '',
    'icon' => 'fa-cross',
])

@php
    $hasFune = file_exists(public_path('images/FUNE.jpeg'));
@endphp

<section class="page-hero {{ $hasFune ? 'page-hero--with-image' : 'page-hero--gradient' }}">
    @if($hasFune)
        <div class="page-hero__bg" aria-hidden="true"></div>
        <div class="page-hero__overlay" aria-hidden="true"></div>
    @endif
    <div class="page-hero__content">
        <h1 class="page-hero__title">
            <i class="fas {{ $icon }} page-hero__icon"></i>
            {{ $title }}
        </h1>
        @if($subtitle)
            <p class="page-hero__subtitle">{{ $subtitle }}</p>
        @endif
    </div>
</section>
