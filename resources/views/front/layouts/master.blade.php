<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
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

    <!-- ---magnific-popup -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/magnific-popup.min.css') }}">
    <!-- ------ style css -->
     <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/front/css/custom.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.css') }}"/>
    <link href="{{ asset('assets/front/css/flatpickr.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('assets/front/css/intlTelInput.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">




    <link rel="stylesheet" href="{{ asset('assets/front/css/font-awesome.min.css') }}">
</head>
<body>
    <!-- --- scroll top icon -- -->
    <div class="" id="scroll">
        <span class="d-flex justify-content-center align-items-center d-block">
                <img src="{{ asset('assets/front/image/subtract.webp') }}" alt="" class="scroll_img" loading="lazy">
        </span>
    </div>

    <!-- --------  loader   -->
     <!-- <div>
        <div class="loader_bg">
            <div class="loader spin">
                <div class="spin__blocker"></div>
            </div>
        </div>
     </div> -->

    @includeIf('front.layouts.header')


    @yield('content')

    <script src="{{ asset('assets/front/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.js') }}"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/flatpickr.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/front/js/intlTelInput.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/front/js/lozad.min.js') }}"></script>

    @includeIf('front.layouts.footer')

    @yield('script')
    @includeIf('layouts.toastr')

    <script>
        $(document).ready(function() {
            $(document).on('change', '.category_select', function (event) {
                var val = $(this).val();
                setSearchData("#category_search",val);
            });
            $(document).on('change', '.category_select_mobile', function (event) {
                var val = $(this).val();
                setSearchData("#category_search_mobile",val);
            });
            $('#inquiry_form').validate({
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "email") {
                        error.insertAfter('#email_error');
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData($('#inquiry_form')[0]);
                    var token = '<?php echo csrf_token(); ?>';
                    $.ajax({
                        type: "POST",
                        enctype: 'multipart/form-data',
                        url: $("#inquiry_form").attr("action"),
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
                            if (data.status == 1) {
                                toastr.options = {
                                    "positionClass": "toast-bottom-left",
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                                toastr.success("Thank you for subscribing us!");
                                $('#inquiry_form')[0].reset();
                            }
                        },
                    });
                }
            });
            console.log("{{ session()->get('user_country') }}");

            @if(session()->get('user_country') == null)
                $.ajax({
                    url: '{{ route("save_user_country") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    },
                    success: function(data) {
                        console.log(data);
                    },
                });
            @endif


            function setSearchData(ele_id,id = null){
                if(id != null){
                    var url = "{{ route('get_main_categories',':id') }}";
                    url = url.replace(':id', id);
                }

                var categoryList = new Bloodhound({
                    prefetch: url ? url : "{{ route('get_main_categories') }}",
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                });

                categoryList.clearPrefetchCache();
                categoryList.initialize();

                var route_category = "{{ route('main_categories', [':slug', ':slug1']) }}";
                var route_sub_category = "{{ route('sub_categories', [':slug', ':slug1', ':slug2']) }}";
                $(ele_id).typeahead('destroy'); // Destroy existing typeahead instance

                $(ele_id).typeahead({
                    hint: false,
                    highlight: true
                }, {
                    source: categoryList.ttAdapter(),
                    name: 'categoryList',
                    display: 'name',
                    limit: Infinity,
                    templates: {
                        empty: [
                            '<div class="list-group search-results-dropdown "><div class="list-group-item list-box" style="font-weight:600">No results found.</div></div>'
                        ],
                        header: [
                            // '<div class="list-group search-results-dropdown">'
                            '<div class="list-group search-results-dropdown" style="top: 138px; left: 1155.5px; display: block;">'
                        ],
                        suggestion: function(data) {
                            if(data.type == 'main_category'){
                                var route_category1 = route_category.replace(':slug', data.super_category.slug_name);
                                var url_category = route_category1.replace(':slug1', data.slug_name);
                            } else if(data.type == 'sub_category'){
                                var route_category1 = route_sub_category.replace(':slug', data.main_category.super_category.slug_name);
                                var route_category2 = route_category1.replace(':slug', data.main_category.slug_name);
                                var url_category = route_category2.replace(':slug2', data.slug_name);
                            }
                            // return '<div class="list-group-item list-box" style="font-weight:600"><a data-href="' + url_category + '" class="">' + data.name + '</a></div>';
                            return '<div class="list-group-item list-box" style="font-weight:600"><a data-href="' + url_category + '" class="">' + data.name + '</a></div>';
                        }
                    }
                }).on('typeahead:selected', function(e, suggestion) {
                    if(suggestion.type == 'main_category'){
                        var route_category1 = route_category.replace(':slug', suggestion.super_category.slug_name);
                        var url_category = route_category1.replace(':slug1', suggestion.slug_name);
                    }else if(suggestion.type == 'sub_category'){
                        var route_category1 = route_sub_category.replace(':slug', suggestion.main_category.super_category.slug_name);
                        var route_category2 = route_category1.replace(':slug1', suggestion.main_category.slug_name);
                        var url_category = route_category2.replace(':slug2', suggestion.slug_name);
                    }
                    window.location.href = url_category;
                });
            }

            setSearchData("#category_search_mobile");
            setSearchData("#category_search");

            $(document).on('change', '.cur_select', function (event) {
                var value = $(this).val();
                $.ajax({
                    url: '{{ route("save_user_currency") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    },
                    data:{
                        value: value
                    },
                    success: function(data) {
                        location.reload();
                    },
                });
            });
        });
        // Disable right-click
        document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        }, false);

        // Disable F12 key
        document.addEventListener('keydown', function (e) {
        if (e.key === 'F12') {
            e.preventDefault();
        }

        // Disable Ctrl + Shift + I
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'I') {
            e.preventDefault();
        }
        }, false);

    </script>
</body>
</html>
