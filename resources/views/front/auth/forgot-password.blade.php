@extends('front.layouts.auth.master')
@section('content')

    <section class="login_form position-relative">
          <div class="position-absolute backArrow d-none d-md-block" style="z-index: 99;">
                <a href="{{ route('front_login')}}">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#ffffff
                            " stroke-width="3" stroke-linecap="round"></path>
                    </svg>
                </a>
            </div>
        <div class="row justify-content-center align-items-center w-100">
        <div class="col-xl-5 col-lg-9 col-md-10 col-12">
                <div class="register_box position-relative">
                        <div class="position-absolute backArrow d-block d-md-none" style="z-index: 99;">
                            <a href="{{ route('front_login')}}">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" stroke="#9E1CFF
                                        " stroke-width="3" stroke-linecap="round"></path>
                                </svg>
                            </a>
                        </div>
                    <div class="register_form">
                         <a href="{{ route('home') }}"><img class="logo_img m-auto mb-3" src="{{ getSetting('logo') != null ? url('storage/setting', getSetting('logo')) : url('images/logo.png') }}" alt="logo" width="100"></a>
                        <h4 class="register_title">Forgot Password</h4>

                        <div class="mt-3">
                            <form id="forgot_password_form" method="post" action="{{ route('front.forgot.password.post') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group input-field pass_field">
                                            <label class="login_label mb-2">Email</label>
                                            <input type="text" class="text form-control" name="email" id="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3 text-center">
                                        {{-- <a href="#"> --}}
                                            <button type="submit" class="btn load_more_btn">Submit</button>
                                        {{-- </a> --}}
                                    </div>
                                </div>
                            </form>
                            <!-- <div class="col-12 mt-3 text-center">
                                <a href="{{ route('front_login')}}">
                                    <button type="button" class="btn load_more_btn">Go Back</button>
                                </a>
                            </div> -->
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
            $('#forgot_password_form').validate();
        });
    </script>
@endsection
