@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Change Password</h2>
        <div class="profile px-0">
            <div class="content-box">
                <form id="change_password" method="post" action="{{ route('reset.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row porfile-form pt-2">
                        <div class="form-group col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Current Password <span
                                    class="error">*<span></label>
                             <div class="position-relative d-flex">     
                                <input type="password" placeholder="Enter Current Password" name="password"
                                class="w-100 text-16 textdark px-4 py-3" id="password" required>
                                <i class="fas fa-eye admin_icon_pass" id="current_Password"></i>
                            </div>  
                        </div>
                        <div class="form-group col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">New Password <span class="error">*<span></label>
                            <div class="position-relative d-flex">
                                <input type="password" class="w-100 text-16 textdark px-4 py-3" name="new_password"
                                id="new_password" placeholder="Enter New Password" required>
                                <i class="fas fa-eye admin_icon_pass" id="new_Password"></i>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Confirm Password <span
                                    class="error">*<span></label>
                            <div class="position-relative d-flex">
                              <input type="password" class="w-100 text-16 textdark px-4 py-3" name="confirm_password"
                                id="confirm_password" placeholder="Enter Confirm Password" required>
                                <i class="fas fa-eye admin_icon_pass" id="confirmePassword"></i>
                             </div>
                        </div>
                        <div class="cetificate-btns col-12">
                            <button type="submit"class="save-btn text-22 my-md-3 mx-1 anim mb-3">Save</button></a>
                            <a href="{{route('admin.dashboard')}}"class="save-btn text-22 my-3 mx-1 anim mb-3">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {

    $.validator.addMethod('differentPassword', function(value, element) {
            return value !== $('#password').val();
        }, 'New password must be different from the current password');

            $('#change_password').validate({
                rules: {
                    password: {
                        required: true,
                        remote: {
                            type: 'GET',
                            url: "{{ route('resetpasswordvalidation') }}",
                            data: {
                                'password': function() {
                                    return $('#password').val();
                                },
                            },
                            dataFilter: function(data) {
                                var json = JSON.parse(data);
                                if (json.status == 0) {
                                    return "\"" + json.message + "\"";
                                } else {
                                    return true;
                                }
                            }
                        }
                    },
                    new_password: {
                        required: true,
                        differentPassword: true,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password",
                    }
                },
                messages: {
                    confirm_password: {
                        equalTo: "Passwords do not match",
                    }
                },

                errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');  // Make sure you have CSS for this class
                element.closest('.form-group').append(error);  // Append error below the input field
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    $('#SubmitBtn').prop('disabled', true);
                    form.submit();
                }
            });

            $('#current_Password , #new_Password, #confirmePassword').click(function () {
                const passwordField = $(this).siblings('input'); // Select the sibling input field
                const passwordFieldType = passwordField.attr('type');
                
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text'); // Show password
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash'); // Change icon to 'eye-slash'
                } else {
                    passwordField.attr('type', 'password'); // Hide password
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye'); // Change icon to 'eye'
                }
            });
        });
    </script>
@endsection
