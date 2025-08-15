@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Create Setting</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="create_setting_form" method="post" action="{{ route('setting.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row porfile-form pt-4">
                         <!-- title -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Title<span class="text-danger">*<span></label>
                                <input name="title" id="title" rows="3" value="{{ old('title') }}" maxlength="50" placeholder="Title" required>
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                         <!-- Type -->
                         <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Type<span class="text-danger">*<span></label>
                                <select name="type" id="type" class="form-control select2"placeholder="Type" required>
                                    <option value="" disabled {{ old('type') ? '' : 'selected' }}>--Select type--</option>
                                    <option value="Text" {{ old('type') == 'Text' ? 'selected' : '' }}>Text</option>
                                    <option value="File" {{ old('type') == 'File' ? 'selected' : '' }}>File</option>
                                </select>
                        </div>
                        @error('type')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <!-- Value -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Value<span class="text-danger">*<span></label>
                                <input type="text" class="ss_help ps-3" id="value" name="value" placeholder="Value" value="{{ old('value') }}" required />
                                <div class="image_error upload_image_error " id="upload_image_error"></div>
                            @error('value')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                         </div>
                           <!-- Image Preview -->
                          <div id="image_preview" class="form-group col-lg-12 col-md-12 mb-4" style="display: none;">
                            <img id="image_preview_img" src="" alt="Image Preview" class="img-fluid rounded-3" style="max-width: 100%; width:100px; height:100px"/>
                        </div>

                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Save</button>
                            <a href="{{route('setting.index')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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

            $.validator.addMethod('filesize', function(value, element, param) {
                var maxSize = param * 1024 * 1024; // Convert MB to bytes
                return this.optional(element) || (element.files[0].size <= maxSize);
            }, 'File size must be less than 2 MB');

            $.validator.addMethod("fileType", function(value, element) {
                var fileType = $('#type').val();
                if (fileType === 'File') {
                    var allowedTypes = ["jpg", "jpeg", "png", "webp"];
                    return new RegExp('\\.(' + allowedTypes.join('|') + ')$', 'i').test(value);
                }
                return true;
            }, "The image must be a file of type: jpg, png, jpeg, webp!");
;

            $('#create_setting_form').validate({
                ignore: [],
                rules: {
                    'title': {
                        noSpace: true,
                        required: true,
                        remote: {
                            type: 'get',
                            url: "{{ route('title_unique_name_setting') }}",
                            data: {
                                'title': function() {
                                    return $('#title').val();
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
                        }
                    },
                    'key': {
                        noSpace: true,
                        required: true,
                        remote: {
                            type: 'get',
                            url: "{{ route('key_unique') }}",
                            data: {
                                'key': function() {
                                    return $('#key').val();
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
                        }
                    },
                    value: {
                        required: true,
                        noSpace: function(element) {
                            return $('#type').val() === 'Text';
                        },
                        fileType: function(element) {
                            return $('#type').val() === 'File';
                        },
                        filesize: function(element) {
                            return $('#type').val() === 'File';
                        },
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
            $('#value').on('change', function(event) {
                var file = event.target.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_preview').show();
                    $('#image_preview_img').attr('src', e.target.result);
                };

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    $('#image_preview').hide();
                }
            });

            $("#type").change(function(e) {
                var type = $("#type").val();
                if (type == "File") {
                    $("#value").attr("type", "file");
                } else {
                    $("#value").attr("type", "text");
                }
            });
        });
        // $(document).ready(function() {
        //     $('.ckeditor').ckeditor();
        // });


    </script>
@endsection
