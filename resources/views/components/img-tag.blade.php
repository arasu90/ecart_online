@props(['image_url','img_alt'])

@if (file_exists(public_path($image_url)))
    <div class="zoom-img"><img src="{{ asset($image_url) }}"  class="width-10 prod-detail-img" alt="{{$img_alt}}" /></div>
@else
    <img src="{{ asset(env('NOIMAGE')) }}" alt="File Not Found" class="width-10" />
@endif
