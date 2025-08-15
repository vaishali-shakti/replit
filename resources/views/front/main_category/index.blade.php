@extends('front.layouts.master')
@section('meta')
@if($category->meta_title == null)
        <title>{{ $category->name }}</title>
        @else
        <title>{{ $category->meta_title }}</title>
        @endif
        <meta name="DC.title" content="{{ $category->meta_title }}">
        <meta name="keywords" content="{{ $category->keyword }}">
        <meta name="description" content="{{ $category->meta_description }}">
        <link rel="canonical" href="{{ $category->canonical }}"/>

        <meta property="og:title" content="{{ $category->meta_title }}">
        <meta property="og:description" content="{{ $category->meta_description }}">
            {{-- <meta property="og:image" content="{{ asset('storage/main_category/' . $category->original_image) }}">
            <meta property="og:image:type" content="image/png">
            <meta property="og:image:width" content="1000">
            <meta property="og:image:height" content="500"> --}}
@endsection
@section('content')
    <!-- --------------- banner slider start ------------ -->
    <div class="pageLoader" id="pageLoader"></div>
    <section>
            <div class="main_banner_section">
                    <div class="banner_box">
                        <div  class="banner_img_box">
                            <h3 class="main_heading_title">{{ $category->name }}</h3>
                            <nav aria-label="breadcrumb" class="breadcrumb_nav">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('category', $category->super_category->slug_name) }}">{{ $category->super_category->name }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- --------------- banner slider end ------------ -->

    <!-- ---------- General Discomfort FREE for all section start ---------- -->

    <section class="pad-top pad-bottom" style="background-color: #F6F6F6;">
        <div class="container">
            <div class="row px-2">
                @forelse($category->subCategories()->orderBy('order_by','asc')->get() as $subcat)
                @if($subcat->status == 1)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                        <div class="card_box">
                            <div class="card_box_img">
                                <img src="{{ $subcat->image }}" alt="" width="100%" height="100%" loading="lazy">
                            </div>
                            <div class="card_content">
                                <div class="d-flex justify-content-between">
                                    <h4 title="{{ $subcat->name }}">{{ $subcat->name }}</h4>
                                    @if($subcat->payment_type == "premium")
                                        <div class="premium_icon">
                                            <i class="fa-solid fa-crown"></i>
                                        </div>
                                    @endif
                                </div>
                                <p title="{{ strip_tags(html_entity_decode($subcat->description)) }}">{{ strip_tags(html_entity_decode($subcat->description)) }}</p>
                                <a href="{{ route('sub_categories', [$subcat->main_category->super_category->slug_name, $subcat->main_category->slug_name, $subcat->slug_name]) }}">
                                    <button type="button" class="btn view_btn">View More</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="col-12 text-center h3 fw-bolder main_category_no_found">
                        <h3>No Data Found</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @if(!auth()->guard('auth')->check() || (auth()->guard('auth')->check() && is_plan_active($category->id) == false) && organization_user_plan($category->super_cat_id) == false && customise_all_assign() == false && organization_all_assign() == false)
    @if(has_active_plans_for_main_category($category))
        <section class="pad-top pad-bottom">
            <div class="container">
                <div class="row mt-4 justify-content-center">
                    <div class="col-12 text-center">
                        <h3 class="main_heading mx-auto">Get step up plan for {{ $category->name }}
                            <span class="heading_line"></span>
                        </h3>
                    </div>
                    @foreach($category->packages->sortBy('packages_order_by') as $packages)
                        @if($packages->status != 0)
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
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif

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
                        main_cat_id: "{{ $category->id }}",
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
</script>
@endsection
