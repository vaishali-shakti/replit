<!-- --------------- banner slider start ------------ -->

<section>
    <div class="main_banner_slider">
        <div class="owl-carousel owl-theme" id="banner-slider">
            @foreach(getBanner() as $banner)
                <div class="item">
                    <div  class="banner_img">
                        <img src="{{ $banner->image }}" alt="Banner" width="100%" height="100%" class="position-relative" loading="lazy">
                        <h1 class="banner_title">{{ $banner->title }}</h1>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- --------------- banner slider end ------------ -->
