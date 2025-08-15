@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit Role</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_roles_form" method="post" action="{{ route('roles.update',$role->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row porfile-form pt-4">
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Name <span class="error">*<span></label>
                                <input type="text" placeholder="Party Name" class="w-100 text-16 textdark px-4 py-3" name="name" maxlength ="50" id="name" value="{{ old('name',$role->name) }}" required>
                        </div>
                        <div class="col-12 create_role_input">
                            <div class="d-flex align-items-center mb-3">
                                <label class="mb-2">Permission <span>*<span></label>
                                <input type="checkbox"  id="permission_checkbox"  class="role select_all_role">Select All
                            </div> 
                            <div class="form-group col-md-12">
                                <div class="row">
                                @foreach($permission as $item)
                                @if($item->name != "setting-create" && $item->name != "setting-delete")
                                <div class="col-lg-3 col-md-4 main_role_checkbox main_role_edit">
                                    <label class="edit_control_inline">
                                        <input type="checkbox" name="permission[]" value="{{ $item->id }}" class="permission_checkbox" {{ in_array($item->id, old('permission', $role->permissions->pluck('id')->toArray()) ?: []) ? 'checked' : '' }} required>
                                           <span> {{ $item->name }}</span>
                                    </label>
                                </div>
                                @endif
                                @endforeach
                                <div id="permission_checkbox_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="cetificate-btns col-12">
                            <button type="submit"class="save-btn text-22 my-md-3 mx-1 anim">Save</button></a>
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
                return this.optional(element) || /<.*?>/g.test(value) === false;
            }, "HTML tags are not allowed.");

            $.validator.addMethod("onlyCharacters", function(value, element) {
                var re = new RegExp("^[a-zA-Z ]+$");
                return this.optional(element) || re.test(value);
            }, "Please enter only characters.");

            $('#edit_roles_form').validate({
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
                if (permission.length == count) {
                    $('#permission_checkbox').prop('checked', true);
                }
                else{
                    $('#permission_checkbox').prop('checked', false);
                }
            });
        });
    </script>
@endsection
