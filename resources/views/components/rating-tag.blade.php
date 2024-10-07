
@props(['rating'=>"0",'starclass'=>''])

@php
$classes = 'text-primary';

@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @for($i=0;$i<'5';$i++)
        @if($rating != null && $i<(floor($rating)))
        <small data-value="{{$i+1}}" class="{{$starclass}} fas fa-star"></small>
        @elseif($i<$rating )
            <small data-value="{{$i+1}}" class="{{$starclass}} fas fa-star-half-alt"></small>
        @else
            <small data-value="{{$i+1}}" class="{{$starclass}} far fa-star"></small>
        @endif
    @endfor
</div>
