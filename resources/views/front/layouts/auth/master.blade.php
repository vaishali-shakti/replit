<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getSetting('meta-title') != null ? getSetting('meta-title') : 'Healing-Hospital' }}</title>
    <link type="image/x-icon" rel="shortcut icon" href="{{ getSetting('favicon') != null ? url('storage/setting', getSetting('favicon')) : asset('assets/imgs/favicon.png') }}"/>
    <!-- ---- BOOTSTRAP ---- -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
     <!-- ----- -->
    <!-- ------ font awesome  -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/sharp-solid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/sharp-regular.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/sharp-light.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/flaticon.css') }}">

    <!-- ------- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/owl.theme.default.min.css') }}">

    <!-- ------ style css -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">
    <link rel="stylesheet"href="{{ asset('assets/front/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.css') }}"/>
    {{-- <link rel="stylesheet" href="{{ asset('assets/front/css/intlTelInput.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">

</head>
<body>
    @yield('content')

    <script src="{{ asset('assets/front/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.js') }}"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/flatpickr.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/front/js/intlTelInput.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    @yield('auth-script')
    @includeIf('layouts.toastr')
</body>
<script>
    function storeTimezone(){
        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone
        $.ajax({
            url: '{{ route("store_timezone") }}',
            type: 'GET',
            data: {timezone: timezone},
            success: function(data) {
            },
        });
    }
</script>
</html>
