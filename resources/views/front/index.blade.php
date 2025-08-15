@extends('front.layouts.master')
@section('meta')
{{-- @if($sub_cat->meta_title == null) --}}
        <title>{{ getSetting('meta-title') != null ? getSetting('meta-title') : 'Healing-Hospital' }}</title>
        <meta name="DC.title" content="{{ getSetting('meta-title') != null ? getSetting('meta-title') : 'Healing-Hospital' }}">
        <meta name="keywords" content="{{ getSetting('keywords') != null ? getSetting('keywords') : '' }}">
        <meta name="description" content="{{ getSetting('meta-description') != null ? getSetting('meta-description') : '' }}">
        <link rel="canonical" href="{{ getSetting('canonical') != null ? getSetting('canonical') : '' }}"/>

        <meta property="og:title" content="{{ getSetting('meta-title') != null ? getSetting('meta-title') : 'Healing-Hospital' }}">
        <meta property="og:description" content="{{ getSetting('meta-description') != null ? getSetting('meta-description') : '' }}">
            <meta property="og:image" content="{{ getSetting('og-image') != null ? url('storage/setting', getSetting('og-image')) : asset('assets/front/image/logo.png') }}">
            <meta property="og:image:type" content="image/png">
            <meta property="og:image:width" content="1000">
            <meta property="og:image:height" content="500">
@endsection
@section('content')
@includeIf('front.layouts.banner')
<div class="pageLoader" id="pageLoader"></div>
<!-- ------------ about section start ------------ -->

<section class="pad-top pad-bottom" id="about_sec">
    <div class="about_section">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6 col-xl-5 about-col-img order-sm-1 order-2">
                    <div class="about_img_box d-none d-sm-block">
                        <div class="gradient-frame">
                              <img src="{{ $about->image }}" alt="About Us" class="about_image" loading="lazy">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7 about-col-content order-sm-2 order-1">
                    <div class="about_content_box">
                        <h3 class="main_heading about_heading">{{ $about->title }}
                            <span class="heading_line"></span>
                        </h3>
                        <div class="about_img_box d-block d-sm-none">
                            <div class="gradient-frame">
                                <img src="{{ $about->image }}" alt="About Us" class="about_image" loading="lazy">
                            </div>
                        </div>
                        <div class="about_content">
                            {!! $about->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ------------ about section end ------------ -->


<!-- --------------- music pro special section start ------------ -->
@if($pro_music != '[]')
    <section style="background-color: #F6F6F6;" class="pad-top pad-bottom">
        <div class="music_pro_section">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="position-relative">
                            <h3 class="main_heading mx-auto">Frequently Used Frequency
                                <span class="heading_line"></span>
                            </h3>
                            <div class="sell_all_btn">
                                <a href="{{ route('pro_music_list') }}"><span class="text-capitalize">See All</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="owl-carousel owl-theme" id="music_pro_slider">
                    @foreach($pro_music as $music)
                        <div class="item mb-3 ">
                            <div class="card_box">
                                <div class="card_box_img">
                                    <img src="{{ $music->image }}" alt="{{ $music->name }}" width="100%" height="100%" loading="lazy">
                                </div>
                                <div class="card_content">
                                    <h4 title="{{ $music->name }}">{{ $music->name }}</h4>
                                    <p title="{{ strip_tags(html_entity_decode($music->description)) }}">{{ strip_tags(html_entity_decode($music->description)) }}</p>
                                    <a href="{{ route('main_categories', [$music->super_category->slug_name, $music->slug_name]) }}">
                                        <button type="button" class="btn view_btn">View More</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endif
<!-- --------------- music pro special section end ------------ -->

<!-- ---------- Category section start ---------- -->
<?php $i = 0; ?>
@foreach($category as $key => $cat_data)
    @if($cat_data->mainCategories != '[]')
        <section class="pad-top pad-bottom" style="{{ $i % 2 != 0 ? 'background-color: #F6F6F6;' : '' }}">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="main_heading mx-auto">{{ $cat_data->name }}
                            <span class="heading_line"></span>
                        </h3>
                    </div>
                    @foreach($cat_data->mainCategories()->orderBy('order_by','asc')->take(8)->get() as $subcat)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                            <div class="card_box">
                                <div class="card_box_img">
                                    <img src="{{ $subcat->image }}" alt="{{ $subcat->name }}" width="100%" height="100%" loading="lazy">
                                </div>
                                <div class="card_content">
                                    <h4 title="{{ $subcat->name }}">{{ $subcat->name }}</h4>
                                    <p title="{{ strip_tags(html_entity_decode($subcat->description)) }}">{{ strip_tags(html_entity_decode($subcat->description)) }}</p>
                                    <a href="{{ route('main_categories', [$subcat->super_category->slug_name, $subcat->slug_name]) }}">
                                        <button type="button" class="btn view_btn">View More</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($cat_data->mainCategories->count() > 8)
                        <div class="col-12 mt-3 text-center">
                            <a href="{{ route('category', $cat_data->slug_name) }}">
                                <button type="button" class="btn load_more_btn">See All</button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <?php $i++; ?>
    @endif
@endforeach
<!-- ---------- Category section end ---------- -->

<!-- ----------- Pricing section start----------- -->

@if(!auth()->guard('auth')->check() || (auth()->guard('auth')->check() && global_plan_active() == false ) && $plans->isNotEmpty())

<section class="pad-bottom pad-top" id="pricing_sec" style="{{ $i % 2 != 0 ? 'background-color: #F6F6F6;' : '' }}">
    <?php $i++; ?>
    <div class="container">
    <div class="">
            <div class="row mt-4 justify-content-center">
                <div class="col-12 text-center">
                    <h3 class="main_heading mx-auto">All-Inclusive Deals
                        <span class="heading_line"></span>
                    </h3>
                </div>
                @foreach($plans->sortBy('order_by') as $plan)
                        <div class="col-xl-3 col-lg-4 col-md-6" id="{{ $plan->id }}">
                            <div class="plan_box">
                                <h4 class="plan_title" title="{{ $plan->name }}" >
                                    {{ $plan->name }}
                                </h4>
                                <span class="plan_txt" title="{{ str_pad($plan->days, 2, "0", STR_PAD_LEFT) }} day (RS/{{ $plan->cost }})">
                                {{ str_pad($plan->days, 2, "0", STR_PAD_LEFT) }} day ({{ (session()->get('user_country') == "India" ? 'RS/'.$plan->cost : (session()->get('user_currency') == "euro" ? ('€'.$plan->cost_euro) : ('$'.$plan->cost_usd))) }})
                                {{-- {{ str_pad($plan->days, 2, "0", STR_PAD_LEFT) }} day ({{ (session()->get('user_country') == "India" || (session()->get('user_country') != "India" && $plan->cost_usd == null) ? 'RS/'.$plan->cost : ('$' . $plan->cost_usd)) }}) --}}
                                </span>
                                <a href="#" class="package_btn">
                                    <button type="button" class="btn_secondary ms-0 rzp-button" data-id="{{ $plan->id }}">Get This Package</button>
                                </a>
                            </div>
                        </div>
                @endforeach
            </div>
    </div>
    </div>
</section>
@endif

<!-- ----------- pricing end section ----------- -->

<!-- ---------- Contact section start ---------- -->

<section class="pad-top pad-bottom" id="contact_sec" style="{{ $i % 2 != 0 ? 'background-color: #F6F6F6;' : '' }}">
    <div class="contact_section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 col-xl-6 mb-3">
                    <div>
                        <h3 class="main_heading text-center text-sm-start">Contact Us
                            <span class="heading_line"></span>
                        </h3>
                        <div class="conatct_img_box d-sm-none d-block">
                            <img src="{{ asset('assets/front/image/contact.webp') }}" alt="Contact Us" class="contact_image" loading="lazy">
                            <div class="overlay"></div>
                         </div>

                        <div class="contact_content">
                            <form action="{{ route('contact.post') }}" method="POST" id="contact_form">
                                @csrf
                                <input type="text" name="hidden_field" id="hidden_field" style="display:none;">
                                <input type="hidden" name="user_id" value="{{ auth()->guard('auth')->check() ? auth()->guard('auth')->user()->id : '' }}">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ auth()->guard('auth')->check() ? auth()->guard('auth')->user()->name : '' }}" maxlength ="50" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ auth()->guard('auth')->check() ? auth()->guard('auth')->user()->email : '' }}" placeholder="Email" required>
                                </div>
                                <div class="index_cont_field form-group">
                                    <input type="text" name="number" id="number" class="form-control " value="{{ auth()->guard('auth')->check() ? auth()->guard('auth')->user()->mobile_number_1 : '' }}" maxlength ="15" minlength="6" placeholder="Number" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" rows="5" class="form-control" value="{{ auth()->guard('auth')->check() ? auth()->guard('auth')->user()->message : '' }}" placeholder="Message" required></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="btn index_submit_btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 mb-3 conatct_sec_col d-sm-block d-none">
                    <div class="conatct_img_box">
                        <img src="{{ asset('assets/front/image/contact.webp') }}" alt="Contact Us" class="contact_image" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ----------- contact us end section ----------- -->


<!-- -------------- get update sign up now section end ------------ -->

@endsection
@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(document).ready(function() {
        $.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0;
        }, "No spaces are allowed.");

        $.validator.addMethod("noHTML", function(value, element) {
                return !/<[^>]*>/g.test(value);
        }, "HTML tags are not allowed.");

        $.validator.addMethod("onlyCharacters", function(value, element) {
            return /^[a-zA-Z\s]*$/.test(value);
        }, "Only alphabetic characters are allowed.");

        $('#name').on('keyup blur', function() {
                    $(this).valid();
        });


        var phoneInput1 = document.querySelector('input[name="number"]');
        if (phoneInput1 !== null) {
            intlTelInput(phoneInput1, {
                geoIpLookup: function(success, failure) {
                    $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "IN";
                        success(countryCode);
                    });
                },
                preferredCountries: ['IN'],
                hiddenInput: "number",
                separateDialCode: true,
                utilsScript: "{{ url('adminassets/js-county/utils.js') }}",
            });

            phoneInput1.addEventListener('input', function() {
                phoneInput1.value = phoneInput1.value.replace(/\D/g, '');
            });
        }

        document.querySelector("#contact_form").addEventListener('reset', function () {
            setTimeout(function () {
                phoneInput1.value = ""; // Clear the phone number input
            }, 0); // Ensure reset completes before updating
        });

        $('.rzp-button').on('click', function (e) {
            var value = $(this).data('id');
            var type = 1;
            var token = '<?php echo csrf_token(); ?>';
            // alert(value);
            e.preventDefault();
            @if(!auth()->guard('auth')->check())
                $.ajax({
                    url: "{{ route('save_checkout_detail') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        pricing: "pricing_sec",
                    },
                    dataType: 'json',
                    success: function (response) {
                        window.location.href = "{{ route('front_login') }}";
                    }
                });
            @endif

            // Fetch dynamic values from the server
            $('#pageLoader').show(1);
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
                    console.log(response.amount);
                    if(response.status == 1){
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
                    }else if(response.status == 0){
                        window.location.href = "{{ route('home') }}";
                        $('#pageLoader').fadeOut("slow");
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $("#pageLoader").fadeOut("slow");
                }
            });
        });
        $('#contact_form').validate({
            rules: {
                    'name': {
                            required: true,
                            noHTML: true,
                            onlyCharacters: true,
                            },
                    'number': {
                            required: true,
                            digits: true,
                        },
                    'email': {
                            required: true,
                            noSpace: true,
                            },
                    },
                    errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');  // Make sure you have CSS for this class
                element.closest('.form-group').append(error);  // Append error below the input field
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },

            submitHandler: function(form) {
                var formData = new FormData($('#contact_form')[0]);
                var token = '<?php echo csrf_token(); ?>';
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: $("#contact_form").attr("action"),
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
                            toastr.success("Message sent successfully.");
                            $('#contact_form')[0].reset();
                        } else if (data.status == 1) {
                            toastr.options =
                            {
                                "positionClass": "toast-bottom-left",
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.error("Please try again later.");
                            $('#contact_form')[0].reset();
                        }
                    },
                    error: function(xhr) {
                    if (xhr.status === 403) {
                      toastr.error('Your submission was detected as spam. Please try again.');
                      $('#contact_form')[0].reset();
                    } else {
                        toastr.error('An unexpected error occurred. Please try again later.');
                    }
                }
                });
            }
        });
        $("#number").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $("#number").on("countrychange", function (e) {
            mobile1_length();
        });
        mobile1_length();
    });
    function mobile1_length(){
        console.log("called");

        var phoneinput = document.querySelector('input[name="number"]');
        var iti = window.intlTelInputGlobals.getInstance(phoneinput);
        var countrycode = iti.getSelectedCountryData().dialCode;
        var countryname = iti.getSelectedCountryData().name;
        $('#country').val(countryname);
        if(countrycode != "" && countrycode != "91"){
            $("#number").attr('maxlength','15');
            $("#number").attr('minlength','6');
        } else{
            $("#number").attr('maxlength','10');
            $("#number").attr('minlength','10');
        }
    }
</script>
@endsection
