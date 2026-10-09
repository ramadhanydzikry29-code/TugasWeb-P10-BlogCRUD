@props(['title' => null])

<div {{ $attributes->merge(['class' => 'card shadow-sm h-100']) }}>
    @if ($title)
        <div class="card-header fw-semibold">{{ $title }}</div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer bg-white">
            {{ $footer }}
        </div>
    @endisset
</div>
