@extends('front.layouts.master')
@section('meta')
@section('meta')
@if($sub_cat->meta_title == null)
        <title>{{ $sub_cat->name }}</title>
        @else
        <title>{{ $sub_cat->meta_title }}</title>
        @endif
        {{-- {{ getSetting('footer-description') != null ? getSetting('footer-description') : 'AGNEY Foundation works in the field of Wellness, through the research & development with the support of scalar sound & light frequencies.' }} --}}
        <meta name="DC.title" content="{{ $sub_cat->meta_title }}">
        <meta name="keywords" content="{{ $sub_cat->keyword }}">
        <meta name="description" content="{{ $sub_cat->meta_description }}">
        <link rel="canonical" href="{{ $sub_cat->canonical }}"/>

        <meta property="og:title" content="{{ $sub_cat->meta_title }}">
        <meta property="og:description" content="{{ $sub_cat->meta_description }}">
            <meta property="og:image" content="{{ asset('storage/subcategory/' . $sub_cat->original_image) }}">
            <meta property="og:image:type" content="image/png">
            <meta property="og:image:width" content="1000">
            <meta property="og:image:height" content="500">
@endsection
@section('content')
<div class="pageLoader" id="pageLoader"></div>
<!-- --------------- banner slider start ------------ -->

<section>
    <div class="main_banner_section">
        <div class="banner_box">
            <div  class="banner_img_box">
                <h3 class="main_heading_title">{{ $sub_cat->main_category->name }}</h3>
                <nav aria-label="breadcrumb" class="breadcrumb_nav">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category', $sub_cat->main_category->super_category->slug_name) }}">{{ $sub_cat->main_category->super_category->name }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('main_categories', [$sub_cat->main_category->super_category->slug_name, $sub_cat->main_category->slug_name]) }}">{{ $sub_cat->main_category->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $sub_cat->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- --------------- banner slider end ------------ -->


<!-- ---------- General Discomfort FREE for all section start ---------- -->
@if($sub_cat->status == 1 || is_user_purchased($sub_cat->id,$sub_cat->cat_id) || customise_user_plan($sub_cat->id))
<section class="pad-top pad-bottom" style="background-color: #F6F6F6;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-12 col-xl-10 mb-3 mt-2 mt-sm-4">
                <div class="row description_card mx-0 mx-xl-2">
                    <div class="col-xl-4 col-lg-4 col-md-5 col-12 mb-4">
                        <div class="card_box des_card_box">
                            <div class="card_box_img">
                                @if(auth()->guard('auth')->check())
                                    <i class="fa-solid fa-heart {{ $sub_cat->likedCategories()->where('user_id', auth()->guard('auth')->user()->id)->exists() ? 'active' : '' }}" data-id="{{ $sub_cat->id }}"></i>
                                @endif
                                <img src="{{ $sub_cat->image }}" alt="" width="100%" height="100%" loading="lazy">
                            </div>
                            <div class="card_content category_des_box">
                                <div class="d-flex justify-content-between">
                                    <h4 title="{{ $sub_cat->name }}">{{ $sub_cat->name }}</h4>
                                    @if($sub_cat->payment_type == "premium")
                                        <div class="premium_icon">
                                            <i class="fa-solid fa-crown"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class=" d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="pe-3 score" style="--_score:{{ (($sub_cat->average_rating*100)/5) }}%;"></span>
                                    <span class="text-18 text-end">{{ ($sub_cat->average_rating) }}/5</span>
                                    @if(auth()->guard('auth')->check() && ($sub_cat->payment_type == "free" || is_user_purchased($sub_cat->id,$sub_cat->cat_id) || customise_user_plan($sub_cat->id) || organization_user_plan($sub_cat->main_category->super_cat_id)))
                                        <button class="btn write_review_btn">Write a review</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 col-md-7 col-12 mb-4">
                        <div class="des_box">
                            <div class="d-flex align-items-start gap-3 justify-content-between mb-3 desc_field">
                                <span class="desc_title">{{ $sub_cat->name }}</span>
                            </div>
                            <div class="d-flex align-items-start gap-sm-3 gap-2 justify-content-between mb-2 desc_field flex-column">
                                {{-- <span class="desc_title">description</span> --}}
                                <div class="main_desc_box">
                                    <p>{!! $sub_cat->description !!}</p>
                                </div>
                            </div>
                            <?php $user_purchsed = auth()->guard('auth')->check() && ($sub_cat->payment_type == "free" || (is_plan_active($sub_cat->cat_id, $sub_cat->id) || customise_user_plan($sub_cat->id) || organization_user_plan($sub_cat->main_category->super_cat_id) )); ?>
                            @if($user_purchsed)
                                @if($sub_cat->audio != null)
                                    <div class="d-flex align-items-start gap-sm-3 gap-2 justify-content-between mb-2 desc_field flex-column">
                                        <span class="desc_title">Audio</span>
                                        <audio id="lazyAudio" loop controlsList="nodownload" class="audio_category_box" title="Loading audio..." controls>
                                            Your browser does not support the audio element.
                                        </audio>
                                        {{-- <div class="main_desc_box">
                                            <div id="btn_start" class="audioStartBtn start_btn">
                                                <svg width="45" height="45" class="start_button" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20 10.268C21.3333 11.0378 21.3333 12.9623 20 13.7321L3.5 23.2583C2.16667 24.0281 0.5 23.0659 0.5 21.5263V2.47372C0.5 0.934118 2.16667 -0.0281308 3.5 0.74167L20 10.268Z" fill="#ffffff"/>
                                                </svg>
                                            </div>
                                            <div id="btn_pause" class="audioStartBtn pause_btn hidden">
                                                <svg fill="#f5f5f5" width="45" height="45" viewBox="-1.08 -0.3 13.16 10.18" xmlns="http://www.w3.org/2000/svg" stroke="#f5f5f5" stroke-width="0.00008">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier"> <path d="M0 0v6h2v-6h-2zm4 0v6h2v-6h-2z" transform="translate(1 1)"></path> </g>
                                                </svg>
                                            </div>
                                        </div> --}}
                                    </div>
                                @endif
                                @if($sub_cat->video != null)
                                    <div class="d-flex align-items-start gap-sm-3 gap-2 justify-content-between mb-2 desc_field flex-column">
                                        <span class="desc_title">Video</span>
                                        <video oncontextmenu="return false;" id="lazyVideo" controls loop controlsList="nodownload" width="100%" height="300" class="rounded-3 video_category_box">
                                            {{-- <source src="{{ Storage::disk('s3')->temporaryUrl('video/'.$sub_cat->video,\Carbon\Carbon::now()->addhour(1)) }}" type="video/mp4"> --}}
                                        </video>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if(($sub_cat->payment_type != "free"))
    @if(!auth()->guard('auth')->check() || (auth()->guard('auth')->check() && is_plan_active($sub_cat->cat_id, $sub_cat->id) == false && customise_user_plan($sub_cat->id) == false) && organization_user_plan($sub_cat->main_category->super_cat_id) == false)
        <section class="pad-bottom">
            <div class="container">
                <div class="">
                    {{-- @if($sub_cat->packages->where('status', 1)->count() > 0)
                        <div class="row mt-4 justify-content-center">
                            <div class="col-12 text-center">
                                <h3 class="main_heading mx-auto">Please select a plan
                                    <span class="heading_line"></span>
                                </h3>
                            </div>
                            @foreach($sub_cat->packages->where('status', 1) as $package)
                                <div class="col-xl-3 col-lg-4 col-md-6" id="{{ $package->id }}">
                                    <div class="plan_box">
                                        <h4 class="plan_title" title="{{ $package->name }}">
                                            {{ $package->name }}
                                        </h4>
                                        <span class="plan_txt" title="{{ str_pad($package->days, 2, "0", STR_PAD_LEFT) }} day (RS/{{ $package->cost }})">
                                            {{ str_pad($package->days, 2, "0", STR_PAD_LEFT) }} day ({{ (session()->get('user_country') == "India" ? ('RS/'.$package->cost) : (session()->get('user_currency') == "euro" ? ('€'.$package->cost_euro) : ('$'.$package->cost_usd))) }})
                                        </span>
                                        <a href="#" class="package_btn">
                                            <button type="button" class="btn_secondary ms-0 rzp-button" data-id="{{ $package->id }}">Get This Package</button>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif --}}
                    @if($sub_cat->main_category->packages->where('status', 1)->count() > 0)
                        <div class="row mt-4 justify-content-center">
                            <div class="col-12 text-center">
                                <h3 class="main_heading mx-auto">Get step up plan for {{ $sub_cat->main_category->name }}
                                    <span class="heading_line"></span>
                                </h3>
                            </div>
                            @foreach($sub_cat->main_category->packages->where('status', 1)->sortBy('packages_order_by') as $packages)
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="plan_box">
                                        <h4 class="plan_title" title="{{ $packages->name }}">
                                            {{ $packages->name }}
                                        </h4>
                                        <span class="plan_txt" title="{{ str_pad($packages->days, 2, "0", STR_PAD_LEFT) }} day (RS/{{ $packages->cost }})">
                                            {{ str_pad($packages->days, 2, "0", STR_PAD_LEFT) }} day ({{ (session()->get('user_country') == "India" ? ('RS/'.$packages->cost) : (session()->get('user_currency') == "euro" ? ('€'.$packages->cost_euro) : ('$'.$packages->cost_usd))) }})
                                        </span>
                                        <a href="#" class="package_btn">
                                            <button type="button" class="btn_secondary ms-0 rzp-button" data-id="{{ $packages->id }}">Get This Package</button>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endif
@else
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mt-5">
                <div class="position-relative">
                    <h3 class="main_heading mx-auto">No Data Found
                        <span class="heading_line"></span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endif




<!-- ---------- General Discomfort FREE for all section end ---------- -->

{{-- write review model --}}
<div id="write_review" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="write_review_form" action="{{ route('review_store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Write A Review</h4>
                    <span class="close" data-bs-dismiss="modal" aria-label="Close" aria-hidden="true" style="cursor: pointer;">X</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="sub_cat_id" id="sub_cat_id" value="{{ $sub_cat->id }}"/>
                    <?php $user_review = auth()->guard('auth')->check() ? get_user_review($sub_cat->id) : null; ?>
                    <div class="star-wrap mb-2">
                        <label class="d-block fw-bold">Rating</label>
                        <span class="d-block star-rating">
                            <input type="radio" name="rating" value="1" {{ $user_review != null && $user_review->rating == 1 ? 'checked' : '' }} required><i></i>
                            <input type="radio" name="rating" value="2" {{ $user_review != null && $user_review->rating == 2 ? 'checked' : '' }} required><i></i>
                            <input type="radio" name="rating" value="3" {{ $user_review != null && $user_review->rating == 3 ? 'checked' : '' }} required><i></i>
                            <input type="radio" name="rating" value="4" {{ $user_review != null && $user_review->rating == 4 ? 'checked' : '' }} required><i></i>
                            <input type="radio" name="rating" value="5" {{ $user_review != null && $user_review->rating == 5 ? 'checked' : '' }} required><i></i>
                        </span>
                        <label id="rating-error" class="error" for="rating"></label>
                    </div>
                    <div class="form-group">
                        <label class="d-block fw-bold">Review</label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Write your review here...">{{ $user_review != null ? $user_review->description : '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- write review model end --}}
@endsection
@section('script')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        $('.rzp-button').on('click', function (e) {
            var value = $(this).data('id');
            var type = 2;
            var token = '<?php echo csrf_token(); ?>';
            e.preventDefault();
            @if(!auth()->guard('auth')->check())
                $.ajax({
                    url: "{{ route('save_checkout_detail') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        id: "{{ $sub_cat->id }}",
                    },
                    dataType: 'json',
                    success: function (response) {
                        window.location.href = "{{ route('front_login') }}";
                    }
                });
            @endif

            // Fetch dynamic values from the server
            $("#pageLoader").show(1);
            $.ajax({
                url: "{{ route('fetch_payment_details') }}", // Your server endpoint to fetch payment details
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    package_id: value,
                    type: type
                },
                dataType: 'json',
                success: function (response) {
                    // Use the fetched data to initialize Razorpay options
                    const options = {
                        key: response.key, // Razorpay API Key
                        amount: response.amount, // Amount
                        currency: response.currency, // Currency code (e.g., "INR")
                        name: response.name, // Company/Brand Name
                        description: response.description, // Payment description
                        order_id: response.order_id, // Razorpay Order ID
                        handler: function (paymentResponse) {
                            // Send the payment response to the server for verification
                            var token = '<?php echo csrf_token(); ?>';
                            $.ajax({
                                url: "{{ route('payment_callback') }}",
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': token
                                },
                                data: {
                                    payment_response: paymentResponse,
                                    package_id: value,
                                    type: type,
                                    receipt_no: response.receipt_no,
                                    currency: response.currency,
                                    amount: response.amount,
                                },
                                complete: function () {
                                    $("#pageLoader").fadeOut("slow");
                                },
                                success: function (data) {
                                    if(data.status == "success"){
                                        window.location.href = "{{ route('user_dashboard',['slug' => 'pur-frequency']) }}";
                                        toastr.success(data.message);
                                    }
                                },
                                error: function () {
                                    $.ajax({
                                        url: "{{ route('payment_failure') }}",
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': token
                                        },
                                        complete: function () {
                                            $("#pageLoader").fadeOut("slow");
                                        },
                                        success: function (data) {
                                            if(data.status == "error"){
                                            toastr.error(data.message);
                                            }
                                        },
                                        error: function () {
                                            toastr.error("Payment could not be completed. Please try again.");
                                        }
                                    });
                                }
                            });
                        },
                        theme: {
                            color: '#3399cc'
                        },
                        modal: {
                            ondismiss: function () {
                                // Hide loader if Razorpay modal is closed/canceled
                                $("#pageLoader").fadeOut("slow");
                            }
                        }
                    };

                    // Initialize Razorpay instance
                    const rzp = new Razorpay(options);
                    rzp.open(); // Open Razorpay modal
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $("#pageLoader").fadeOut("slow");
                }
            });
        });
        // document.addEventListener('DOMContentLoaded', () => {
        @if($sub_cat->status == 1 || is_user_purchased($sub_cat->id,$sub_cat->cat_id) || customise_user_plan($sub_cat->id))
        @if($user_purchsed == true)
            $(window).on("load", function () {
                var token = '<?php echo csrf_token(); ?>';
                // Get the current audio source
                $.ajax({
                    url: "{{ route('audio_detail') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        id: "{{ $sub_cat->id }}",
                    },
                    success: function (data) {
                        const audioElement = document.getElementById('lazyAudio');
                        if(data.status == 1){
                            audioElement.src = "data:audio/mpeg;    base64," + data.url;
                            audioElement.title = "";

                            @if($sub_cat->audio_duration != '')
                                audioElement.addEventListener('play', () => {
                                    setTimeout(() => {
                                        audioElement.pause(); // Stop playback
                                    }, convertToMilliseconds("{{ $sub_cat->audio_duration }}"));
                                });
                            @endif
                        } else if(data.status == 0) {
                            // If audio is not available, display a message
                            audioElement.title = data.message;
                        }
                    }
                });

                @if($sub_cat->video != '')
                    var token = '<?php echo csrf_token(); ?>';
                    // Get the current video source
                    $.ajax({
                        url: "{{ route('video_detail') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        data: {
                            id: "{{ $sub_cat->id }}",
                        },
                        success: function (data) {
                            const videoElement = document.getElementById('lazyVideo');
                            if(data.status == 1){
                                videoElement.src = "data:video/mp4;base64," + data.url;
                                videoElement.title = "";
                            } else if(data.status == 0) {
                                // If video is not available, display a message
                                videoElement.title = data.message;
                            }
                        }
                    });
                @endif
            });
        @endif
        @endif
        $(document).ready(function () {
            $(document).on('click', '.write_review_btn', function (e) {
                $('#write_review').modal('show');
                $('#write_review_form').validate({
                    submitHandler: function(form) {
                        var formData = new FormData($('#write_review_form')[0]);
                        var token = '<?php echo csrf_token(); ?>';
                        $.ajax({
                            type: "POST",
                            enctype: 'multipart/form-data',
                            url: $("#write_review_form").attr("action"),
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            data: formData,
                            processData: false,
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            timeout: 600000,
                            success: function (data) {
                                if (data.status == 0) {
                                    toastr.options =
                                    {
                                        "positionClass": "toast-bottom-left",
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                    toastr.success("Review submitted successfully.");
                                    $('#write_review').modal('hide');
                                }
                            },
                        });
                    }
                });
            });

            $(document).on('click', '.card_box_img i', function (e) {
                var token = '<?php echo csrf_token(); ?>';
                var id = $(this).data('id');
                var icon = $(this);
                $.ajax({
                    url: "{{ route('like_unlike_category') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        icon.toggleClass('active');
                    }
                });
            });
        });

        function convertToMilliseconds(audioDuration) {
            // Split the time into hours, minutes, and seconds
            let [hours, minutes, seconds] = audioDuration.split(":").map(Number);

            // Convert to milliseconds
            let milliseconds = ((hours * 3600) + (minutes * 60) + seconds) * 1000;

            return milliseconds;
        }
    </script>
@endsection
