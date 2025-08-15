@extends('FrontDashboard.master')

@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit App Banner</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_app_banner_form" method="post" action="{{ route('app-banner.update', $appbanner->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- This ensures the form sends a PUT request to update -->
                    <div class="row porfile-form pt-4">
                         <!-- Title -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="title" class="d-block text-18 fw-bold pb-2">Title<span class="text-danger">*</span></label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="title" maxlength="50" id="title" value="{{ old('title', $appbanner->title) }}" required>
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                         <!-- Image -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Image<span class="text-danger">*</span></label>
                            <input type="file" class="ss_help" name="image" id="image" accept="image/png,image/jpeg,image/jpg,image/webp">
                                @if ($appbanner ->image)
                                    <!-- Display the current image if it exists -->
                                    <div class="mt-2">
                                        <img src="{{ $appbanner->image }}" id="image_preview_img" alt="Current Image" class="rounded-3" height="100px" width="100px"/>
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
                         <!-- Description -->
                         <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="description" class="d-block text-18 fw-bold pb-2">Description<span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="w-100 text-16 textdark px-4 py-3 textarea ckeditor" placeholder="Description" required>{{ old('description', $appbanner->description) }}</textarea>
                            @error('description')
                                 <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Update</button>
                            <a href="{{ route('app-banner.index') }}" class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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

            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'File size must be less than 2 MB');

            $('#edit_app_banner_form').validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                    },
                    image: {
                        required: false,
                        filesize: 2097152  
                    },
                    description: {
                        required: function(textarea) {
                            CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    } 
                },
                messages: {
                    image: {
                        extension: "Please upload a valid image (jpg, jpeg, png, webp)",
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
                submitHandler: function(form) {
                    $('#SubmitBtn').prop('disabled', true);
                    form.submit();
                }
            });
            $('#image').on('change', function(event) {
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
