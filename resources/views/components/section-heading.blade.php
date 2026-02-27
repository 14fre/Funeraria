@props([
    'title',
    'icon' => 'fa-cross',
    'center' => false,
])

<h2 class="section-heading {{ $center ? 'section-heading--center' : '' }}">
    <span class="section-heading__icon" aria-hidden="true">
        <i class="fas {{ $icon }}"></i>
    </span>
    <span class="section-heading__line" aria-hidden="true"></span>
    <span>{{ $title }}</span>
</h2>
