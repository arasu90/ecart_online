@props(['rating'])

@php
$classes = 'text-primary'
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @for($i=0;$i<'5';$i++)
        @if($rating != null && $i<(floor($rating)))
        <small class="fas fa-star"></small>
        @elseif($i<$rating )
            <small class="fas fa-star-half-alt"></small>
        @else
            <small class="far fa-star"></small>
        @endif
    @endfor
</div>