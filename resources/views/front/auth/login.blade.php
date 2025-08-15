@extends('front.layouts.auth.master')

@section('content')
<section class="login_form position-relative">
        <div class="position-absolute backArrow d-none d-lg-block" style="z-index: 99;">
                    <a href="{{ route('home') }}">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#ffffff
                                " stroke-width="3" stroke-linecap="round"></path>
                        </svg>
                    </a>
        </div>
    <div class="row justify-content-center align-items-center w-100">
        <div class="col-xl-6 col-lg-9 col-md-10 col-12">
            <div class="register_box position-relative">
                    <div class="position-absolute mobile_backArrow d-block d-lg-none" style="z-index: 99;">
                        <a href="{{ route('home') }}">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#9E1CFF
                                    " stroke-width="3" stroke-linecap="round"></path>
                            </svg>
                        </a>
                    </div>
                <div class="register_form">
                    <a href="{{ route('home') }}"><img class="logo_img m-auto mb-3" src="{{ getSetting('logo') != null ? url('storage/setting', getSetting('logo')) : url('images/logo.png') }}" alt="logo" width="100"></a>
                    <h4 class="register_title">Login</h4>
                    <div class="mt-3">
                        <form id="front_login_form" method="post" action="{{ route('front_login.post') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group input-field pass_field">
                                        <label class="login_label mb-2">Email</label>
                                        <input type="text" class="text form-control" name="email" id="front_email" placeholder="Email" required
                                            @if (isset($_COOKIE["front_email"])) value="{{ $_COOKIE["front_email"] }}" @endif>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group input-field pass_field">
                                        <label class="login_label mb-2">Password</label>
                                        <div class="d-flex position-relative">
                                            <input type="password" class="password form-control" name="password" id="front_password" placeholder="******" minlength="6" required
                                                @if (isset($_COOKIE["front_password"])) value="{{ $_COOKIE["front_password"] }}" @endif>
                                            <i class="fas fa-eye form_user_icon" id="toggleFrontPassword"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex gap-sm-3 gap-2 align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <input type="checkbox" name="remember_me" id="front_remember_txt" class="me-2" @if (isset($_COOKIE["front_email"])) checked @endif>
                                            <label class="remember_me_txt" for="front_remember_txt">Remember me</label>
                                        </div>
                                        <div>
                                            <a href="{{ route('front_forgot_password') }}" class="text-capitalize fw-semibold text-primary">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3 text-center">
                                    <button type="submit" class="btn load_more_btn">Login</button>
                                </div>
                                <div class="col-12 text-center mt-3">
                                    <a class="google_btn" href="{{ route('login.google') }}">
                                        <svg width="20px" height="20px" viewBox="0 0 256 292" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                                            <g>
                                                <path d="M255.878,133.451 C255.878,122.717 255.007,114.884 253.122,106.761 L130.55,106.761 L130.55,155.209 L202.497,155.209 C201.047,167.249 193.214,185.381 175.807,197.565 L175.563,199.187 L214.318,229.21 L217.003,229.478 C241.662,206.704 255.878,173.196 255.878,133.451" fill="#4285F4"></path>
                                                <path d="M130.55,261.1 C165.798,261.1 195.389,249.495 217.003,229.478 L175.807,197.565 C164.783,205.253 149.987,210.62 130.55,210.62 C96.027,210.62 66.726,187.847 56.281,156.37 L54.75,156.5 L14.452,187.687 L13.925,189.152 C35.393,231.798 79.49,261.1 130.55,261.1" fill="#34A853"></path>
                                                <path d="M56.281,156.37 C53.525,148.247 51.93,139.543 51.93,130.55 C51.93,121.556 53.525,112.853 56.136,104.73 L56.063,103 L15.26,71.312 L13.925,71.947 C5.077,89.644 0,109.517 0,130.55 C0,151.583 5.077,171.455 13.925,189.152 L56.281,156.37" fill="#FBBC05"></path>
                                                <path d="M130.55,50.479 C155.064,50.479 171.6,61.068 181.029,69.917 L217.873,33.943 C195.245,12.91 165.798,0 130.55,0 C79.49,0 35.393,29.301 13.925,71.947 L56.136,104.73 C66.726,73.253 96.027,50.479 130.55,50.479" fill="#EB4335"></path>
                                            </g>
                                        </svg>
                                        Login with Google
                                    </a>
                                </div>
                                <div class="col-lg-12 mt-4 text-center">
                                    <p class="text-18 bright fw-regular d-flex justify-content-center flex-wrap">Not registered yet?
                                        <a href="{{ route('front_register') }}" class="text-18 text-primary fw-bold text-center d-block ms-2">Register</a>
                                    </p>
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
    $(document).ready(function () {
        storeTimezone();
        $('#toggleFrontPassword').click(function() {
            const passwordField = $('#front_password');
            const passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('#front_login_form').validate({
            rules: {
                'email': {
                    required: true,
                    email: true
                },
                'password': {
                    required: true,
                    minlength: 6
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
                if ($('#front_remember_txt').is(':checked')) {
                    document.cookie = "front_email=" + $('#front_email').val() + "; path=/; max-age=" + (60 * 60 * 24 * 30); // 30 days
                    document.cookie = "front_password=" + $('#front_password').val() + "; path=/; max-age=" + (60 * 60 * 24 * 30); // 30 days
                } else {
                    document.cookie = "front_email=; path=/; max-age=0";
                    document.cookie = "front_password=; path=/; max-age=0";
                }
                form.submit();
            }
        });
    });
</script>
@endsection
