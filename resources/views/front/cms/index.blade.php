@extends('front.layouts.master')
@section('content')

<!-- --------------- banner slider start ------------ -->
{{-- @dd(Route::currentRouteName() == 'home' ? '#about_sec' : route('home','#about_sec')) --}}

<section>
           <div class="main_banner_section">
                    <div class="banner_box">
                        <div class="banner_img_box">
                             <h3 class="main_heading_title">{{ $cms->title }}</h3>
                             <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="breadcrumb_nav">
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">{{ $cms->title }}</li>
                                </ol>
                              </nav>
                        </div>
                    </div>
                </div>
            </div>
    </section>

<!-- --------------- banner slider end ------------ -->


<!-- ---------- cmc start ---------- -->

 <!-- breadcrumb section start -->

{{-- <section class="main_breadcrumb bg-white">
    <div class="container">
        <ul class="breadcrumb_main_list d-flex align-items-center flex-wrap">
            <li><a href="{{ route('home') }}">Home <i class="fas fa-angle-right"></i></a></li>
            <li><a href="#">{{ $cms->title }}</a></li>
        </ul>
    </div>
</section> --}}

<!-- breadcrumb section end -->

<div class="container main_policy">
 <div class="row">
    @if($cms->image != null)
            <div class="cms-detail mb-4">
  
                <!-- <div class="{{ $cms->image != null ? 'cms-image mb-4' : 'col-md-12' }}"> -->  
                        <img src="{{ $cms->image }}"  class="about-img cms-float-img" style=" background-color:white;" /> 
                         {!! $cms->description !!}
                <!-- </div> -->
          </div>
          @else
             <div class="cms-detail">
                <h2 class="mb-2">{{ $cms->title }}</h2>
                {!! $cms->description !!}
            </div>
        @endif
</div>
</div>

<!-- ----------cms end ---------- -->


@endsection
@section('script')
<script>
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

