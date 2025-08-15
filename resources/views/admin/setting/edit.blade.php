@extends('FrontDashboard.master')

@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit Setting</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_setting_form" method="post" action="{{ route('setting.update', $setting->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- This ensures the form sends a PUT request to update -->
                    <div class="row porfile-form pt-4">
                         <!-- Title -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="title" class="d-block text-18 fw-bold pb-2">Title<span class="text-danger">*</span></label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="title" maxlength="50" id="title" value="{{ old('title', $setting->title) }}" required>
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                         <!-- Image -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <input type="hidden" name="type" value="{{ $setting->type }}">

                            @if ($setting->type == 'File')
                                <div class="form-group col-lg-12 col-12 mb-4">
                                    <label for="title" class="d-block text-18 fw-bold pb-2">Value<span class="text-danger">*</span></label>
                                    <input type="file" id="value" name="value" class="img_css_design ss_help"
                                        accept="image/png,image/jpeg,image/jpg,image/webp" />
                                    <input type="hidden" name="old_value" value="{{ $setting->value }}">
                                    <input type="hidden" name="old_value" value="{{ $setting->original_image }}">
                                </div>
                                 @if ($setting->type == 'File')
                                <!-- Display the current image if it exists -->
                                <div class="mt-2">
                                    <img src="{{ $setting->image}}" id="image_preview_img" alt="Current Image" class="rounded-3" height="100px" width="100px" />
                                </div>
                                @else
                                    <!-- Image Preview Section for newly uploaded image -->
                                    <div id="image_preview" class="form-group col-lg-12 col-md-12 mb-4" style="display: none;">
                                        <img id="image_preview_img" src="" alt="Image Preview" class="img-fluid rounded-3" style="max-width: 100%; width: 100px; height: 100px" />
                                    </div>
                                @endif
                            @endif

                            @if ($setting->type == 'Text')
                                <div class="form-group col-lg-12 col-12">
                                    <label for="title" class="d-block text-18 fw-bold pb-2">Value<span class="text-danger">*</span></label>
                                    <input type="text" id="value" name="value" placeholder="Value"
                                        value="{{ old('value', $setting->value) }}"  />
                                </div>
                            @endif

                            @error('value')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                                                    </div>

                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Update</button>
                            <a href="{{ route('setting.index') }}" class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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
                var fileType = '{{ $setting->type }}';
                var maxSize = param * 1024 * 1024;
                if (fileType === 'File' && element.files && element.files.length > 0) {
                    var fileSize = element.files[0].size;
                    if (fileSize > maxSize) {
                        return false;
                    }
                }
                return true;
            }, 'File must be less than 2 MB');

            $.validator.addMethod("fileType", function(value, element) {
                var fileType = '{{ $setting->type }}';
                if (fileType === 'File' && element.files && element.files.length > 0){
                    var allowedTypes = ["jpg", "jpeg", "png", "webp"];
                    return new RegExp('\\.(' + allowedTypes.join('|') + ')$', 'i').test(value);
                }
                return true;
            }, "The image must be a file of type: jpg, png, jpeg, webp!");

            $('#edit_setting_form').validate({
                rules: {
                    'title': {
                        // noSpace: true,
                        required: true,
                        remote: {
                            type: 'get',
                            url: "{{ route('title_edit_unique_name') }}",
                            data: {
                                'title': function() {
                                    return $('#title').val();
                                },
                                'id': function() {
                                    return "{{ $setting->id }}";
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
                        noSpace: true,
                        filesize: [2],
                        fileType:true
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                }
            });

            $('#value').on('change', function(event) {
                var file = event.target.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Show the image preview and display the image
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
        });
        // $(document).ready(function() {
        //     $('.ckeditor').ckeditor();
        // });
    </script>
@endsection
