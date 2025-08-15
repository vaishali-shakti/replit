@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit Profile</h2>
        <div class="profile px-0 pt-0">
            <!-- <div class="top-close d-flex justify-content-end"> -->
                <!-- <a href="#" class="profial-cls d-flex text-20 fw-bold">Close</a> -->
            <!-- </div> -->
            <div class="content-box">
                <form id="edit_user_form" method="post" action="{{ route('update-profile') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row porfile-form pt-4">
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Name <span class="error">*<span></label>
                                <input type="text" placeholder="Name" class="w-100 text-16 textdark px-4 py-3" name="name" maxlength ="50" id="name" value="{{ old('name',$user->name) }}" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Email<span class="text-danger">*<span></label>
                            <input type="email" placeholder="Email" class="w-100 text-16 textdark px-4 py-3" name="email" id="email" value="{{ old('email',$user->email) }}" required>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Mobile Number<span class="error"><span></label>
                            <input type="text" placeholder="Mobile Number" class="w-100 text-16 textdark py-3 " name="mobile_number_1" id="mobile_number_1" id="mobile" value="{{ old('mobile',$user->mobile_number_1) }}" pattern="[0-9]+">
                            @error('mobile')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="cetificate-btns col-12">
                            <button type="submit"class="save-btn text-22 my-md-3 mx-1 anim">Save</button></a>
                            <a href="{{route('admin.dashboard')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            jQuery.validator.addMethod("noSpace", function(value, element) {
                return value == '' || value.trim().length != 0;
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("letterswithspace", function(value, element) {
                return this.optional(element) || /^[a-z][a-z\s]*$/i.test(value);
            }, "letters only");

            $('#mobile').keypress(function(event) {
                if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
                    return false;
                }
            });

            jQuery.validator.addMethod("noHTML", function(value, element) {
                return this.optional(element) || /<.*?>/g.test(value) === false;
            }, "HTML tags are not allowed.");

            $.validator.addMethod("onlyCharacters", function(value, element) {
                var re = new RegExp("^[a-zA-Z ]+$");
                return this.optional(element) || re.test(value);
            }, "Please enter only characters.");

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
            })(jQuery);

            $('#edit_user_form').validate({
                ignore: [],
                rules: {
                    'name': {
                                required: true,
                                maxlength: 50,
                                noHTML: true,
                                onlyCharacters: true,
                            },
                   'mobile_number_1': {
                                required: true,
                                digits: true,
                            },
                            'email': {
                                required: true,
                                email: true,
                                remote: {
                                    type: 'get',
                                    url: "{{ route('check.email.edit') }}",
                                    data: {
                                        'email': function() {
                                            return $('#email').val();
                                        },
                                        'id': function() {
                                            return "{{ $user->id }}";
                                        },
                                    },
                                    dataFilter: function(data) {
                                        var json = JSON.parse(data);
                                        if (json.status == 1) {
                                            return "\"" + json.message + "\"";
                                        } else {
                                            return 'true';
                                        }
                                    }
                                },
                            },
                },
                messages: {
                    'mobile': {
                        minlength: "Please enter at least 10 digit."
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

            });
            $("#mobile_number_1").on("countrychange", function (e) {
                mobile_length();
            });
            mobile_length();
        });

        function mobile_length(){
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
    </script>
@endsection
