@extends('layouts.auth')
@section('content')
<div class="pageLoader" id="pageLoader"></div>
<body class="login_body">
    <span class="shap d-none d-md-block position-absolute bottom-0 start-0 masked" style="-webkit-mask-image: url('{{ asset('images/login-shap-2.png') }}');">
        <img src="{{ asset('images/login-shap-2.png') }}">
    </span>
    <span class="shap d-none d-md-block position-absolute top-0 end-0 masked" style="-webkit-mask-image: url('{{ asset('images/login-shap-1.png') }}');">
        <img src="{{ asset('images/login-shap-1.png') }}">
    </span>
    <div class="container login_container">
        <div class="forms d-flex align-items-center justify-content-center flex-wrap">
            <div class="firm_login_label">
                <span>brain-friend</span>
            </div>
            <div class="form login">
                <div class="text-center">
                    <!-- <a href="#"><img class="logo_style" src="{{asset('images/logo.png')}}" alt="logo"></a> -->
                </div>
                <div class="login_form">
                    <div class="title">Login</div>
                    <form method="POST" action="{{ route('login.post') }}" id="login_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group input-field">
                            <label>Email <span>*</span></label>
                            <input type="email" placeholder="Enter your email" name="email" id="email" @if (isset($_COOKIE["email"])) value="{{$_COOKIE["email"]}}" @endif required class="mt-2">
                        </div>
                        @error('email')
                            <p class="login_css" id="email_error">{{ $message }}</p>
                        @enderror
                        <div class="form-group input-field pass_field">
                            <label for="password">Password <span>*</span></label>
                            <div class="position-relative d-flex mt-2 ">
                                <input type="password" class="passwordform-control" name="password" id="password" 
                                    @if (isset($_COOKIE["password"])) value="{{ $_COOKIE["password"] }}" @endif 
                                    required placeholder="Enter your password">
                                <i class="fas fa-eye form_user_icon" id="toggle-password" style="cursor: pointer;"></i>
                            </div>
                        </div>
                        
                        <div class="error mt-3" id="error_message"></div>

                        <div class="checkbox-text">
                            <div class="checkbox-content">
                                <input type="checkbox" id="logCheck" name="remember" @if (isset($_COOKIE["email"]) && isset($_COOKIE["password"])) checked @endif>
                                <label for="logCheck" class="text label_text">Remember me</label>
                            </div>
                            <a href="{{ route('forgot.password') }}" class="footer-link">Forgot Password?</a>
                        </div>
                        <div class="input-field button login_btn_design mt-2">
                            <button type="submit" class="btn btn-danger btn-lg btn-block login_btn mb-2" id="login_btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="login_img login-img-admin">
                <img class="logo_style" src="{{asset('images/login-logo.webp')}}" alt="logo">
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        storeTimezone();
        $('#login_form').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
                $("#email_error").empty();
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                // Check if "Remember Me" is checked
                if ($('#logCheck').is(':checked')) {
                    document.cookie = "email=" + $('#email').val() + "; path=/; max-age=" + (60 * 60 * 24 * 30);
                    document.cookie = "password=" + $('#password').val() + "; path=/; max-age=" + (60 * 60 * 24 * 30);
                } else {
                    document.cookie = "email=; path=/; max-age=0";
                    document.cookie = "password=; path=/; max-age=0";
                }

                $("#login_btn").attr("disabled", true);
                form.submit();
            }
        });

        $('#toggle-password').click(function() {
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
    });
</script>
@endsection
