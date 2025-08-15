@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Create CMS</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="create_cms_form" method="post" action="{{ route('cms.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row porfile-form pt-4">
                         <!-- Name -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Title<span class="text-danger">*<span></label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="title" maxlength ="50" id="title" value="" required>
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                         <!-- Image -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Image<span class="text-danger">*<span></label>
                            <input type="file" class="ss_help" name="image" id="image"
                                accept="image/png,image/jpeg,image/jpg,image/webp" rows="3" placeholder="Image" required>
                        </div>
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                         <!-- Description -->
                         <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="description" class="d-block text-18 fw-bold pb-2">Description<span class="text-danger">*<span></label>
                            <textarea name="description" id="description" class="w-100 text-16 textdark px-4 py-3 textarea ckeditor" placeholder="Description" required>{{ old('description') }}</textarea> 
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Save</button>
                            <a href="{{route('cms.index')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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

            $('#create_cms_form').validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                        remote: {
                            type: 'get',
                            url: "{{ route('title_unique_name') }}",
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
                    image: {
                        required: true,
                        filesize:2097152
                    },
                    description: {
                        required: function(textarea) {
                            CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    },
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
        });


    </script>
@endsection
