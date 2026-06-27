{{-- Layered wave divider with subtle horizontal drift on the back layers.
     Required: $colorClass (e.g. "text-[#9C2245]" — overall fill colour for the front layer).
     Optional: $variant — "burgundy" | "cream" | "white" (controls back-layer tint). --}}
@php
    $colorClass = $colorClass ?? 'text-[#9C2245]';
    $variant    = $variant ?? 'burgundy';

    $backTint = [
        'burgundy' => 'rgba(156, 34, 69, 0.40)',
        'cream'    => 'rgba(250, 241, 237, 0.55)',
        'white'    => 'rgba(255, 255, 255, 0.55)',
    ][$variant] ?? 'rgba(156, 34, 69, 0.40)';

    $midTint = [
        'burgundy' => 'rgba(156, 34, 69, 0.65)',
        'cream'    => 'rgba(250, 241, 237, 0.78)',
        'white'    => 'rgba(255, 255, 255, 0.78)',
    ][$variant] ?? 'rgba(156, 34, 69, 0.65)';
@endphp

<div class="wave-divider absolute inset-x-0 bottom-0 block w-full" aria-hidden="true">
    <svg viewBox="0 0 1440 110" class="block w-full {{ $colorClass }}" preserveAspectRatio="none">
        {{-- Back layer (most transparent, slowest drift) --}}
        <path class="wave-back" fill="{{ $backTint }}"
              d="M0,55 C240,95 480,15 720,45 C960,75 1200,25 1440,55 L1440,110 L0,110 Z"/>
        {{-- Mid layer --}}
        <path class="wave-mid" fill="{{ $midTint }}"
              d="M0,68 C300,100 600,28 900,58 C1140,80 1320,40 1440,62 L1440,110 L0,110 Z"/>
        {{-- Front layer (full opacity, no drift) --}}
        <path fill="currentColor"
              d="M0,78 C360,108 720,18 1080,52 C1260,70 1380,82 1440,62 L1440,110 L0,110 Z"/>
    </svg>
</div>
