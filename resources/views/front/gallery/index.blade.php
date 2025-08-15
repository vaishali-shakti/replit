@extends('front.layouts.master')
@section('content')

<!-- --------------- banner slider start ------------ -->
{{-- @dd(Route::currentRouteName() == 'home' ? '#about_sec' : route('home','#about_sec')) --}}

<section>
           <div class="main_banner_section">
                    <div class="banner_box">
                        <div class="banner_img_box">
                             <h3 class="main_heading_title">our gallery</h3>
                             <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="breadcrumb_nav">
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                                </ol>
                              </nav>
                        </div>
                    </div>
                </div>
            </div>
    </section>

<!-- --------------- banner slider end ------------ -->


<!-- ---------- gallery start ---------- -->

<section class="pad-top pad-bottom" style="background-color: #F6F6F6;">
    <div class="container">
        <div class="row gallary-data">
            @include('front.gallery.gallery_data')
        </div>
    </div>
</section>

<!-- ----------gallery end ---------- -->


@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var observer = lozad('.lozad', {
            loaded: (el) => {
                el.classList.add('fadeIn');
            }
        });
        observer.observe();
    });
    $(document).ready(function() {
        $(document).on('click', ".photo_display", function() {
            var src = $(this).attr('src');
            $('#image1').attr('src', src);
            $('#myModalViewPhoto').modal('show');
        });

        $(document).on('click', ".load_more_btn", function() {
            var id = $(this).data('id');
            var url = $(this).data('url');
            var token = '<?php echo csrf_token(); ?>';
            $.ajax({
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url:url,
                data:{
                    id:id
                },
                success:function(data) {
                    if(data.status == 1){
                        $('.load_more_btn').hide();
                        $('.gallary-data').append(data.html);
                        imageZoom();
                        var newObserver = lozad('.lozad', {
                            loaded: (el) => {
                                el.classList.add('fadeIn');
                            }
                        });
                        newObserver.observe();
                    } else{
                        toastr_error(data.message);
                    }
                }
            });
        });
    });

    imageZoom();
    function imageZoom(){
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom',
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function
                opener: function(openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });
    }
</script>
@endsection
