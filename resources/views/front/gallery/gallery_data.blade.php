@foreach ($gallary as $photos)
    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
        <div class="gallery_box">
            <a href="{{ $photos->image }}" class="thum_anchor image-popup-vertical-fit">
                <img data-src="{{ $photos->image }}" src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'><rect width='200' height='200' fill='%23f0f0f0'/><text x='50%' y='50%' font-size='20' text-anchor='middle' fill='%23bbb'>Loading...</text></svg> " alt="" width="100%" height="100%" class="rounded photo_display lozad" loading="lazy">
            </a>
        </div>
    </div>
@endforeach

@if($gallary_count > 12)
    <div class="col-12 mt-3 text-center">
        {{-- <a href="#"> --}}
            <button type="button" class="btn load_more_btn" data-url="{{ route('gallery_load_more') }}" data-id="{{ $photos->id }}">Load More</button>
        {{-- </a> --}}
    </div>
@endif
