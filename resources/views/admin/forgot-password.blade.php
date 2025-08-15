@extends('layouts.auth')
@section('content')
<div class="pageLoader" id="pageLoader"></div>
    <body class="login_body">
        <span class="shap d-none d-md-block position-absolute bottom-0 start-0 masked"  style="-webkit-mask-image: url('{{ asset('images/login-shap-2.png') }}');">
            <img src="{{ asset('images/login-shap-2.png') }}">
        </span>
        <span class="shap d-none d-md-block position-absolute top-0 end-0 masked" style="-webkit-mask-image: url('{{ asset('images/login-shap-1.png') }}');">
            <img src="{{ asset('images/login-shap-1.png') }}">
        </span>
        <div class="position-absolute backArrow d-none d-md-block" style="z-index: 99;">
            <a href="{{ route('login') }}">
              <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#9E1CFF
                    " stroke-width="3" stroke-linecap="round"></path>
              </svg>
            </a>
          </div>
        <div class="container login_container">
            <div class="forms d-flex align-items-center justify-content-center flex-wrap position-relative">
                <div class="position-absolute backArrow d-block d-md-none" style="z-index: 99;">
                    <a href="{{ route('login') }}" class="back_button_mobile">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#29b5e4" stroke-width="3" stroke-linecap="round"></path>
                        </svg>
                    </a>
                </div>
                <div class="firm_login_label">
                    <span>Brain-Friend</span>
                </div>
                <div class="form login">
                        <div class="title">Forgot Password</div>
                        <form method="POST" action="{{ route('forgot.password.post') }}" id="forgot_word_form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group input-field">
                                <label>Email <span>*</span></label>
                                <input type="email" placeholder="Enter your email" name="email" id="email" @if (isset($_COOKIE["email"])) value="{{$_COOKIE["email"]}}" @endif required class="mt-2">
                            </div>
                            @error('email')
                                <p class="login_css" id="email_error">{{ $message }}</p>
                            @enderror
                            <div class="input-field button login_btn_design mt-5">
                                <button type="submit" class="btn btn-danger btn-lg btn-block login_btn mb-2" id="submit_btn">Submit</button>
                            </div>
                        </form>
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
                $('#forgot_word_form').validate({
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
                    submitHandler: function(form) { // <- pass 'form' argument in
                        $("#submit_btn").attr("disabled", true);
                        form.submit();
                    }
                });

            });
        </script>
@endsection
