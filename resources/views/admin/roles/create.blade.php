@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Create Role</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="create_role_form" method="post" action="{{ route('roles.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row porfile-form  pt-4">
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Name<span class="text-danger">*<span></label>
                            <input type="text" placeholder="Name" class="w-100 text-16 textdark px-4 py-3" name="name" maxlength ="50" id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Contact Number<span class="text-danger"><span></label>
                            <input type="text" placeholder="Contact Number" class="w-100 text-16 textdark px-4 py-3" name="mobile" maxlength ="10" minlength="10" id="mobile" value="{{ old('mobile') }}" pattern="[0-9]+">
                        </div> --}}
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <br />
                                @foreach ($permission as $value)
                                    <label>
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name">
                                        {{ $value->name }}</label>
                                    <br />
                                @endforeach
                                    </div> --}}
                        <div class="form-group col-12 create_role_input">
                            <div class="d-flex align-items-center mb-3">
                                <label class="">Permission <span>*<span></label>
                                <input type="checkbox"  id="permission_checkbox" name="roles" value="{{ old('roles') }}"class="role select_all_role">Select All
                            </div>
                                <div class="form-group col-md-12">
                                <div class="row">
                                    @foreach ($permission as $value)
                                        <div class="col-lg-3 col-md-4 main_role_checkbox">
                                            <label class="custom-control custom-checkbox custom-control-inline" for="permission_{{ $value->id }}">
                                                <input type="checkbox" class="role_check permission_checkbox" id="permission_{{ $value->id }}" name="permission[]" {{ in_array($value->id, old('permission', []) ?: []) ? 'checked' : '' }} value="{{ $value->id }}" required>
                                               <span> {{ $value->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                    <div id="permission_checkbox_error"></div>
                                </div>
                            </div>
                        </div>
                        @error('permission')
                            <p class="text-danger" >{{ $message }}</p>
                        @enderror
                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Save</button>
                            <a href="{{route('roles.index')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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

            jQuery.validator.addMethod("noHTML", function(value, element) {
                // Check for HTML tags
                return this.optional(element) || /<.*?>/g.test(value) === false;
            }, "HTML tags are not allowed.");

            $.validator.addMethod("onlyCharacters", function(value, element) {
                var re = new RegExp("^[a-zA-Z ]+$"); // allow letters (a-z, A-Z) and spaces
                return this.optional(element) || re.test(value);
            }, "Please enter only characters.");

            $('#mobile').keypress(function(event) {
                if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
                    return false;
                }
            });

            $('#create_role_form').validate({
                ignore: [],
                rules: {
                    'name': {
                        noSpace: true,
                        required: true,
                        noHTML: true,
                        onlyCharacters:true,
                    },
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
            $("#permission_checkbox").change(function() {
                if ($(this).prop('checked') == true) {
                    $('.permission_checkbox').prop('checked', true);
                } else {
                    $('.permission_checkbox').prop('checked', false);
                }
            });

            $(".permission_checkbox").change(function() {
                var count = $('input.permission_checkbox:checked').length;
                console.log(count,"count");
                if ($('.permission_checkbox').length === count) {
                    $('#permission_checkbox').prop('checked', true);
                } else {
                    $('#permission_checkbox').prop('checked', false);
                }
            });
        });
    </script>
@endsection
