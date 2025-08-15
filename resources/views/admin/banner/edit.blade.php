@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit Banner</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_banner_form" method="post" action="{{ route('banner.update',$banners->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row porfile-form pt-4">
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Title</label>
                                <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="title" maxlength ="100" id="title" value="{{ old('title',$banners->title) }}">
                                @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                         <!-- Image -->
                         <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Image<span class="text-danger">*</span></label>
                            <input type="file" class="ss_help" name="image" id="image" accept="image/png,image/jpeg,image/jpg,image/webp">
                                @if ($banners ->image)
                                    <!-- Display the current image if it exists -->
                                    <div class="mt-2">
                                        <img src="{{ $banners->image }}" id="image_preview_img" alt="Current Image" class="rounded-3" height="100px" width="100px"/>
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
                        <div class="cetificate-btns col-12">
                            <button type="submit"class="save-btn text-22 my-md-3 mx-1 anim">Update</button></a>
                            <a href="{{route('banner.index')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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

            $('#edit_banner_form').validate({
                rules: {
                    image: {
                        required: function() {
                            return $('#image').val() !== "";
                        },
                        filesize: 2097152
                    }
                },
                messages: {
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
    </script>
@endsection
