@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit User</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_user_form" method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- This is for the PUT/PATCH HTTP method for updating -->

                    <div class="row porfile-form pt-4">
                        <!-- Name Field -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="name" class="d-block text-18 fw-bold pb-2">Name<span class="text-danger">*</span></label>
                            <input type="text" placeholder="Name" class="w-100 text-16 textdark px-4 py-3" name="name" maxlength="50" id="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DOB Field -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="dob" class="d-block text-18 fw-bold pb-2">DOB<span class="text-danger">*</span></label>
                            <input type="text" placeholder="YYYY/MM/DD" class="w-100 text-16 textdark px-4 py-3" name="dob" id="dob" value="{{ old('dob', $user->dob ? date('d-m-Y', strtotime($user->dob)) : '') }}" required>
                            @error('dob')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Time of Birth -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="time_of_birth" class="d-block text-18 fw-bold pb-2">Time of birth (AM/PM)</label>
                            <input type="time" placeholder="Time of birth (AM/PM)" class="w-100 text-16 textdark px-4 py-3" name="time_of_birth" id="time_of_birth" value="{{ old('time_of_birth', ($user->time_of_birth ? date("H:i", strtotime($user->time_of_birth)) : null)) }}">
                            @error('time_of_birth')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Place of Birth -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="place_of_birth" class="d-block text-18 fw-bold pb-2">Place of birth</label>
                            <input type="text" placeholder="Place of birth" class="w-100 text-16 textdark px-4 py-3" maxlength="100" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth', $user->place_of_birth) }}">
                            @error('place_of_birth')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mobile No. 1 -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="mobile_number_1" class="d-block text-18 fw-bold pb-2">Mobile No. 1<span class="text-danger">*</span></label>
                            <input type="tel" placeholder="Mobile No. 1" class="w-100 text-16 textdark py-3" name="mobile_number_1" id="mobile_number_1" value="{{ old('mobile_number_1', $user->mobile_number_1) }}" pattern="[0-9]+" required>
                            <input type="hidden" id="dial_code_1" name="dial_code_1" value="{{ old('dial_code_1', $user->dial_code_1) }}">
                            @error('mobile_number_1')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mobile No. 2 -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="mobile_number_2" class="d-block text-18 fw-bold pb-2">Mobile No. 2</label>
                            <input type="tel" placeholder="Mobile No. 2" class="w-100 text-16 textdark py-3" name="mobile_number_2" id="mobile_number_2" value="{{ old('mobile_number_2', $user->mobile_number_2) }}" pattern="[0-9]+">
                            <input type="hidden" id="dial_code_2" name="dial_code_2" value="{{ old('dial_code_2', $user->dial_code_2) }}">
                            @error('mobile_number_2')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="email" class="d-block text-18 fw-bold pb-2">Email<span class="text-danger">*</span></label>
                            <input type="email" placeholder="Email" class="w-100 text-16 textdark px-4 py-3" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        @if(auth()->guard('web')->user()->role_id != 5)
                            <div class="form-group porfile-form col-lg-6 col-md-12 mb-4">
                                <label for="role_id" class="d-block text-18 fw-bold pb-2">Role<span class="text-danger">*</span></label>
                                <select name="role_id" id="role_id" class="w-100 text-16 textdark px-4" aria-label="Default select example" required>
                                    <option selected disabled>--Select Role--</option>
                                    @foreach($roles as $role)
                                        @if($role->id != 1 || ($role->id == 1 && auth()->user()->role_id == 1))
                                            <option value="{{ $role->id }}" {{ $role->id == old('role_id', $user->role_id) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Password -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Password<span class="text-danger">*</span></label>
                            <div class="d-flex position-relative">
                                 <input type="password" placeholder="Password" class="w-100 text-16 textdark px-4 py-3" name="password" minlength="6" id="password" value="{{ old('password') }}">
                                 <i class="fas fa-eye admin_icon_pass" id="new_Password"></i>
                            </div>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                             @enderror
                        </div>
                        <!-- Confirm Password -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Confirm Password<span class="text-danger">*</span></label>
                            <div  class="d-flex position-relative">
                                <input type="password" placeholder="Confirm Password" class="w-100 text-16 textdark px-4 py-3" minlength="6" name="conpassword" id="conpassword" value="{{ old('conpassword') }}">
                                 <i class="fas fa-eye admin_icon_pass" id="confirmePassword"></i>
                            </div>
                            @error('conpassword')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discomfort -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="discomfort" class="d-block text-18 fw-bold pb-2">Your discomfort</label>
                            <input type="text" placeholder="Your discomfort" maxlength="150" class="w-100 text-16 textdark px-4 py-3" name="discomfort" id="discomfort" value="{{ old('discomfort', $user->discomfort) }}">
                            @error('discomfort')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Image -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Your photo with white background<span class="text-danger">*</span></label>
                            <input type="file" class="ss_help" name="image" id="image" accept="image/png,image/jpeg,image/jpg,image/webp">
                                 @if ($user->image)
                                    <!-- Display the current image if it exists -->
                                    <div class="mt-2">
                                        <img src="{{ $user->image }}" id="image_preview_img" alt="Current Image" class="rounded-3" height="100px" width="100px"/>
                                    </div>
                                @else
                                    <!-- Image Preview Section (for newly uploaded image) -->
                                    <div id="image_preview" class="form-group col-lg-12 col-md-12 mb-4" style="display: none;">
                                        <img id="image_preview_img" src="" alt="Image Preview" class="img-fluid rounded-3" style="max-width: 100%;  width:100px; height:100px"/>
                                    </div>
                                @endif
                                @error('image')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>

                        {{-- Select sub categories to assign --}}
                        <div class="form-group porfile-form col-lg-12 col-md-12 mb-4 user_limit {{ $user->role_id != 5 ? 'hidden' : '' }}">
                            <label for="frequency" class="d-block text-18 fw-bold pb-2">Assign Frequencies<span class="text-danger">*</span></label>
                            <select name="frequency[]" id="frequency_1" class="w-100 text-16 textdark px-4" required multiple>
                                @php $frequency = isset($user->frequency) && $user->frequency != null ? json_decode($user->frequency) : [] @endphp
                                <option value="all" {{ in_array('all', $frequency) ? 'selected' : '' }}>All</option>
                                @foreach($super_category as $cat)
                                    <option value="{{ $cat->id }}" {{ in_array($cat->id, $frequency) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('frequency')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Select sub categories to assign --}}
                        <div class="form-group porfile-form col-lg-12 col-md-12 mb-4 custom_user {{ $user->role_id != 4 ? 'hidden' : '' }}">
                            <label for="frequency" class="d-block text-18 fw-bold pb-2">Assign Frequencies<span class="text-danger">*</span></label>
                            <select name="frequency[]" id="frequency" class="w-100 text-16 textdark px-4" required multiple>
                                @php $frequency = isset($user->frequency) && $user->frequency != null ? json_decode($user->frequency) : [] @endphp
                                <option value="all" {{ in_array('all', $frequency) ? 'selected' : '' }}>All</option>
                                @foreach($sub_category as $sub_cat)
                                    <option value="{{ $sub_cat->id }}" {{ in_array($sub_cat->id, $frequency) ? 'selected' : '' }}>{{ $sub_cat->name .' ('.$sub_cat->main_category->name.')' }}</option>
                                @endforeach
                            </select>
                            @error('frequency')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div class="form-group col-lg-6 col-md-12 mb-4 custom_user user_limit {{ $user->role_id == 4 || $user->role_id == 5 ? '' : 'hidden' }}">
                            <label for="" class="d-block text-18 fw-bold pb-2">Start Date<span class="text-danger">*</span></label>
                            <div class="d-flex position-relative">
                                <input type="text" placeholder="Start Date" class="w-100 text-16 textdark px-4 py-3" name="start_date" id="start_date" minlength="6" value="{{ old('start_date', $user->start_date ? date('d-m-Y', strtotime($user->start_date)) : date('d-m-Y')) }}" required>
                            </div>
                            @error('start_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="form-group col-lg-6 col-md-12 mb-4 custom_user user_limit {{ $user->role_id == 4 || $user->role_id == 5 ? '' : 'hidden' }}">
                            <label for="" class="d-block text-18 fw-bold pb-2">End Date<span class="text-danger">*</span></label>
                            <div class="d-flex position-relative">
                                <input type="text" placeholder="End Date" class="w-100 text-16 textdark px-4 py-3" name="end_date" id="end_date" minlength="6" value="{{ old('end_date', $user->end_date ? date('d-m-Y', strtotime($user->end_date)) : '') }}" required>
                            </div>
                            @error('end_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- User Limit --}}
                        <div class="form-group col-lg-6 col-md-6 mb-4 user_limit {{ $user->role_id != 5 ? 'hidden' : '' }}">
                            <label for="" class="d-block text-18 fw-bold pb-2">User Limit</label>
                            <input type="number" placeholder="User Limit" class="w-100 text-16 textdark px-4 py-3" name="user_limit" id="user_limit" min="1" max="999999999" value="{{ old('user_limit',$user->user_limit) }}">
                            @error('user_limit')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit & Cancel Buttons -->
                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Update</button>
                            <a href="{{ route('users.index') }}" class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#dob').flatpickr({
            dateFormat: 'd-m-Y',
            maxDate: new Date().fp_incr(-1),
            disableMobile:true
        });

        $('#start_date').flatpickr({
            dateFormat: 'd-m-Y',
            minDate: new Date(),
            disableMobile:true,
            onChange: function (selectedDates, dateStr) {
                // Update the minimum date for the end date picker
                endDatePicker.set("minDate", dateStr);
                endDatePicker.set("defaultDate", dateStr);
                // Optional: Clear the end date if it is earlier than the new min date

                endDatePicker.set("disable",[
                    function(date){
                        return dateStr === flatpickr.formatDate(date,'d-m-Y');
                    }
                ]);
            }
        });
        var endDatePicker = $('#end_date').flatpickr({
            dateFormat: 'd-m-Y',
            minDate: new Date(),
            disableMobile:true,
            onReady:function() {
                var startDateValue = $('#start_date').val();
                if(startDateValue) {
                    this.set("minDate", startDateValue);
                    this.set("disable",[
                        function(date){
                            return startDateValue === flatpickr.formatDate(date,'d-m-Y');
                        }
                    ]);
                }
            }
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

            $('#edit_user_form').validate({
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
                                }else {
                                        return 'true';
                                    }
                            }
                        },
                    },
                    'image': {
                        filesize: 2097152
                    },
                    'password': {
                        required: function(element){
                            return $("#conpassword").val()!="";
                        }
                    },
                    'conpassword': {
                        required: function(element){
                            return $("#password").val()!="";
                        },
                        equalTo: "#password"
                    }
                },
                messages: {
                    'email': {
                        email: "Please enter a valid email address.",
                    },

                },
                errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
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
                    $('#current_image_section').hide();
                };

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    $('#image_preview').hide();
                }
            });

            $('#name, #dob, #time_of_birth, #mobile_number_1, #mobile_number_2, #email, #password, #conpassword').on('keyup blur', function() {
                $(this).valid();
            });

            $("#mobile_number_1, #mobile_number_2").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
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

            $('#frequency').select2({
                placeholder: 'Select frequencies to assign...'
            });
            $('#frequency_1').select2({
                placeholder: 'Select frequencies to assign...'
            });
            $(document).on('change', '#role_id', function (e) {
                var val = $(this).val();
                if(val == 4){
                    $('.user_limit').addClass('hidden');
                    $('.custom_user').removeClass('hidden');
                } else if(val == 5){
                    $('.custom_user').addClass('hidden');
                    $('.user_limit').removeClass('hidden');
                } else{
                    $('.user_limit').addClass('hidden');
                    $('.custom_user').addClass('hidden');
                }
            });
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
