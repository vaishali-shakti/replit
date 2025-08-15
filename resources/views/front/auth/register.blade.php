@extends('front.layouts.auth.master')
@section('content')
<style>
    .google_btn {
      display: inline-flex;
      align-items: center;
      padding: 10px 25px;
      text-decoration: none;
      color: #000;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      font-size: 16px;
      font-weight: 500;
    }
    .google_btn svg {
      margin-right: 10px;
    }
    .google_btn:hover {
      background-color: #f7f7f7;
    }
</style>
    <section class="login_form position-relative">
            <div class="position-absolute backArrow d-none d-lg-block" style="z-index: 99;">
                <a href="{{ route('front_login') }}">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#ffffff
                            " stroke-width="3" stroke-linecap="round"></path>
                    </svg>
                </a>
            </div>
        <div class="row justify-content-center align-items-center w-100 ">
        <div class="col-xl-8 col-lg-10 col-12">
                <div class="register_box position-relative">
                    <div class="position-absolute mobile_backArrow d-block d-lg-none" style="z-index: 99;">
                        <a href="{{ route('front_login') }}">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#9E1CFF
                                    " stroke-width="3" stroke-linecap="round"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="register_form">
                    <a href="{{ route('home') }}"><img class="logo_img m-auto mb-3" src="{{ getSetting('logo') != null ? url('storage/setting', getSetting('logo')) : url('images/logo.png') }}" alt="logo" width="100"></a>
                        <h4 class="register_title">Create User Account</h4>

                        <div class="mt-3">
                            <form id="register_form" method="post" action="{{ route('front_register.post') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Name<span class="text-danger">*<span></label>
                                        <input type="text" placeholder="Name" class="form-control" name="name" maxlength ="50" id="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">DOB<span class="text-danger">*<span></label>
                                        <input type="text" placeholder="YYYY/MM/DD" class="form-control register_dob_input" name="dob" id="dob" value="{{ old('dob') }}" required>
                                        @error('dob')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Time of birth(AM/PM)</label></label>
                                        <input type="time" placeholder="Time of birth(AM/PM)" class="form-control" name="time_of_birth" id="time_of_birth" value="{{ old('time_of_birth') }}">
                                        @error('time_of_birth')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Place of birth</label>
                                        <input type="text" placeholder="Place of birth" class="form-control" maxlength="100" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}">
                                        @error('place_of_birth')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Mobile No. 1<span class="text-danger">*<span></label>
                                        <input type="text" placeholder="Mobile No. 1" class="form-control" name="mobile_number_1" maxlength ="15" minlength="6" id="mobile_number_1" value="{{ old('mobile_number_1') }}" pattern="[0-9]+" required>
                                        @error('mobile_number_1')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Mobile No. 2</label>
                                        <input type="text" placeholder="Mobile No. 2" class="form-control" name="mobile_number_2" maxlength ="15" minlength="6" id="mobile_number_2" value="{{ old('mobile_number_2') }}" pattern="[0-9]+">
                                        @error('mobile_number_2')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Email<span class="text-danger">*<span></label>
                                        <input type="email" placeholder="Email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                                        <span id="email-error" class="text-danger" style="display: none;"></span>
                                            @error('email')
                                                <p class="text-danger" id="email-error">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Your discomfort</label>
                                        <input type="text" placeholder="Your discomfort" class="form-control" maxlength="150" name="discomfort"  id="discomfort" value="{{ old('discomfort') }}">
                                        @error('discomfort')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Password<span class="text-danger">*<span></label>
                                        <div class="position-relative d-flex">
                                            <input type="password" placeholder="Password" class="form-control" name="password" id="password" minlength="6" value="{{ old('password') }}" required>
                                            <i class="fas fa-eye form_user_icon" id="togglePassword"></i>
                                        </div>
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                         @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Confirm Password<span class="text-danger">*<span></label>
                                        <div class="position-relative d-flex">
                                             <input type="password" placeholder="Confirm Password" class="form-control" id="conpassword" name="conpassword" minlength="6" id="conpassword" value="{{ old('conpassword') }}" required>
                                            <i class="fas fa-eye form_user_icon" id="togglePassword1"></i>
                                        </div>
                                        @error('conpassword')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                     <!-- Image -->
                                    <div class="form-group col-lg-12 col-md-12 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Image<span class="text-danger">*<span></label>
                                        <input type="file" class="ss_help form-control" name="image" id="image" accept="image/png,image/jpeg,image/jpg,image/webp" rows="3" placeholder="Image" required>
                                    </div>
                                    <!-- Image Preview -->
                                    <div id="image_preview" class="form-group col-lg-12 col-md-12 mb-4" style="display: none;">
                                        <img id="image_preview_img" src="" alt="Image Preview" class="img-fluid rounded-3" style="max-width: 100%; width:100px; height:100px"/>
                                    </div>
                                    <div class="col-12 mt-3 text-center">
                                        {{-- <a href="#"> --}}
                                            <button type="submit" class="btn load_more_btn">Register</button>
                                        {{-- </a> --}}
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <a class="google_btn" href="{{ route('login.google',['slug' => 'register']) }}">
                                            <svg width="20px" height="20px" viewBox="0 0 256 292" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
                                                <g>
                                                    <path d="M255.878,133.451 C255.878,122.717 255.007,114.884 253.122,106.761 L130.55,106.761 L130.55,155.209 L202.497,155.209 C201.047,167.249 193.214,185.381 175.807,197.565 L175.563,199.187 L214.318,229.21 L217.003,229.478 C241.662,206.704 255.878,173.196 255.878,133.451" fill="#4285F4"></path>
                                                    <path d="M130.55,261.1 C165.798,261.1 195.389,249.495 217.003,229.478 L175.807,197.565 C164.783,205.253 149.987,210.62 130.55,210.62 C96.027,210.62 66.726,187.847 56.281,156.37 L54.75,156.5 L14.452,187.687 L13.925,189.152 C35.393,231.798 79.49,261.1 130.55,261.1" fill="#34A853"></path>
                                                    <path d="M56.281,156.37 C53.525,148.247 51.93,139.543 51.93,130.55 C51.93,121.556 53.525,112.853 56.136,104.73 L56.063,103 L15.26,71.312 L13.925,71.947 C5.077,89.644 0,109.517 0,130.55 C0,151.583 5.077,171.455 13.925,189.152 L56.281,156.37" fill="#FBBC05"></path>
                                                    <path d="M130.55,50.479 C155.064,50.479 171.6,61.068 181.029,69.917 L217.873,33.943 C195.245,12.91 165.798,0 130.55,0 C79.49,0 35.393,29.301 13.925,71.947 L56.136,104.73 C66.726,73.253 96.027,50.479 130.55,50.479" fill="#EB4335"></path>
                                                </g>
                                            </svg>
                                            Continue with Google
                                        </a>
                                    </div>
                                    <div class="col-lg-12 mt-4 text-center">
                                        <div class="d-flex gap-3 align-items-center justify-content-center">
                                            <div>
                                                <p class="text-18 bright fw-regular d-flex justify-content-center flex-wrap">Already have an User Account?
                                                    <a href="{{ route('front_login') }}" class="text-18 text-primary fw-bold text-center d-block parLogin ms-2">Login</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('auth-script')
    <script>
        $('#dob').flatpickr({
            dateFormat: 'd-m-Y',
            maxDate: new Date().fp_incr(-1),
            disableMobile:true
            // defaultDate: new Date().setFullYear(new Date().getFullYear() - 5)
        }); 
        flatpickr("#time_of_birth", {
            disableMobile: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // 12-hour format with AM/PM
            time_24hr: false // Ensures AM/PM is displayed
        });

        $(document).ready(function() {
            $.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0;
            }, "No spaces are allowed.");

            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param);
            }, 'File size must be less than 2 MB');

            $.validator.addMethod("noHTML", function(value, element) {
                return !/<[^>]*>/g.test(value);
            }, "HTML tags are not allowed.");

            $.validator.addMethod("onlyCharacters", function(value, element) {
                return /^[a-zA-Z\s]*$/.test(value);
            }, "Only alphabetic characters are allowed.");

            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
            $('#togglePassword1').click(function() {
                const passwordField = $('#conpassword');
                const passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            (function($) {
                var phoneInput1 = document.querySelector('input[name="mobile_number_1"]');
                if (phoneInput1 !== null) {
                    intlTelInput(phoneInput1, {
                        geoIpLookup: function(success, failure) {
                            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                                var countryCode = (resp && resp.country) ? resp.country : "IN";
                                success(countryCode);
                            });
                        },
                        preferredCountries: ['IN'],
                        hiddenInput: "mobile_number_1",
                        separateDialCode: true,
                        utilsScript: "{{ url('adminassets/js-county/utils.js') }}",
                    });

                    phoneInput1.addEventListener('input', function() {
                        phoneInput1.value = phoneInput1.value.replace(/\D/g, '');
                    });
                }

                var phoneInput2 = document.querySelector('input[name="mobile_number_2"]');
                if (phoneInput2 !== null) {
                    intlTelInput(phoneInput2, {
                        geoIpLookup: function(success, failure) {
                            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                                var countryCode = (resp && resp.country) ? resp.country : "IN";
                                success(countryCode);
                            });
                        },
                        preferredCountries: ['IN'],
                        hiddenInput: "mobile_number_2",
                        separateDialCode: true,
                        utilsScript: "{{ url('adminassets/js-county/utils.js') }}",
                    });

                    phoneInput2.addEventListener('input', function() {
                        phoneInput2.value = phoneInput2.value.replace(/\D/g, '');
                    });
                }
            })(jQuery);
            $('#register_form').validate({
                rules: {
                    'name': {
                        required: true,
                        maxlength: 50,
                        noHTML: true,
                        onlyCharacters: true,
                    },
                    'dob': {
                        required: true,
                        // date: true,
                    },
                    'mobile_number_1': {
                        required: true,
                        digits: true,
                    },
                    'mobile_number_2': {
                        digits: true,
                    },
                    'discomfort': {
                        noHTML: true,
                    },
                    'email': {
                        required: true,
                        noSpace: true,
                        remote: {
                            type: 'get',
                            url: "{{ route('check.email') }}",
                            data: {
                                'email': function() {
                                    return $("input[name='email']").val();
                                }
                            },
                            dataFilter: function(data) {
                                var json = JSON.parse(data);
                                if (json.status == 1) {
                                    return "\"" + json.message + "\"";
                                } else {
                                    return 'true';
                                }
                            }
                        }
                    },
                    'image': {
                        required: true,
                        filesize:2097152
                    },
                    'password': {
                        required: true,
                    },
                    'conpassword': {
                        required: true,
                        equalTo: "#password",
                    },
                },
                messages: {
                    'email': {
                        email: "Please enter a valid email address.",
                        remote: "This email is already registered."
                    },
                    'password': {
                        minlength: "Password must be at least 6 characters long.",
                    },
                    'conpassword': {
                        equalTo: "Password and confirmation must match.",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    $('#SubmitBtn').prop('disabled', true);
                    form.submit();
                }
            });

            $('#image').on('change', function(event) {
                var file = event.target.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_preview').show();
                    $('#image_preview_img').attr('src', e.target.result);
                };

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    $('#image_preview').hide();
                }
            });

            $("#mobile_number_1").on("countrychange", function (e) {
                mobile1_length();
            });
            $("#mobile_number_2").on("countrychange", function (e) {
                mobile2_length();
            });
            mobile1_length();
            mobile2_length();
        });
        function mobile1_length(){
            var phoneinput = document.querySelector('input[name="mobile_number_1"]');
            var iti = window.intlTelInputGlobals.getInstance(phoneinput);
            var countrycode = iti.getSelectedCountryData().dialCode;
            var countryname = iti.getSelectedCountryData().name;
            $('#country').val(countryname);
            if(countrycode != "" && countrycode != "91"){
                $("#mobile_number_1").attr('maxlength','15');
                $("#mobile_number_1").attr('minlength','6');
            } else{
                $("#mobile_number_1").attr('maxlength','10');
                $("#mobile_number_1").attr('minlength','10');
            }
        }
        function mobile2_length(){
            var phoneinput = document.querySelector('input[name="mobile_number_2"]');
            var iti = window.intlTelInputGlobals.getInstance(phoneinput);
            var countrycode = iti.getSelectedCountryData().dialCode;
            var countryname = iti.getSelectedCountryData().name;
            $('#country').val(countryname);
            if(countrycode != "" && countrycode != "91"){
                $("#mobile_number_2").attr('maxlength','15');
                $("#mobile_number_2").attr('minlength','6');
            } else{
                $("#mobile_number_2").attr('maxlength','10');
                $("#mobile_number_2").attr('minlength','10');
            }
        }
    </script>
@endsection
