@props(['img_url'])

@php
$classes = 'img-fluid';
$fileName = pathinfo(public_path($img_url), PATHINFO_FILENAME);
@endphp

@if(file_exists(public_path($img_url)))
<img src="{{ asset($img_url)}}" alt="{{$fileName}}"{{ $attributes->merge(['class' => $classes]) }}  />
@endif