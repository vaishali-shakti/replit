@extends('FrontDashboard.master')
@section('content')
<div class="pageLoader" id="pageLoader"></div>
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Create Sub Category</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="create_subcategory_form" method="POST" action="{{ route('subcategory.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row porfile-form pt-4">
                        <!-- Category Dropdown -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="category_id" class="d-block text-18 fw-bold pb-2">Category<span class="text-danger">*<span></label>
                            <select name="cat_id" id="cat_id" class="w-100 text-16 textdark px-4" aria-label="Default select example" required>
                                <option selected disabled>--Select Category--</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('cat_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                         <!-- Type (Free or Premium) -->
                         <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="type" class="d-block text-18 fw-bold pb-2">Type<span class="text-danger">*<span></label>
                            <select name="type" id="type" class="w-100 text-16 textdark px-4" required>
                                <option selected disabled>--Select Type--</option>
                                <option value="free" {{ old('type') == 'free' ? 'selected' : '' }}>Free</option>
                                <option value="premium" {{ old('type') == 'premium' ? 'selected' : '' }}>Premium</option>
                            </select>
                            @error('type')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategory Name -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Subcategory Name<span class="text-danger">*<span></label>
                            <input type="text" name="name" id="name" class="w-100 text-16 textdark px-4 py-3" maxlength ="150" placeholder="Subcategory Name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Image<span class="text-danger">*<span></label>
                            <input type="file" class="ss_help" name="image" id="image"
                                accept="image/png,image/jpeg,image/jpg,image/webp" rows="3" placeholder="Image" required>
                        </div>

                         <!-- Image Preview -->
                         <div id="image_preview" class="form-group col-lg-12 col-md-12 mb-4" style="display: none;">
                            <img id="image_preview_img" src="" alt="Image Preview" class="img-fluid rounded-3" style="max-width: 100%; width:100px; height:100px"/>
                        </div>
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <!-- Audio Upload -->
                        <div class="form-group col-12 col-lg-6 col-md-6 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Audio<span class="text-danger">*<span></label>
                            <input type="file" name="audio" id="audio" class="w-100 text-16 textdark px-4 py-2" accept="audio/mp3, audio/wav, audio/m4a" required>
                            @error('audio')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Audio duration -->
                        <div class="form-group col-12 col-lg-6 col-md-6 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Audio Duration</label>
                            <input type="text" name="audio_duration" id="audio" placeholder="e.g.(HH:MM:SS)" class="w-100 text-16 textdark px-4 py-2">
                            @error('audio_duration')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Video Upload -->
                        <div class="form-group col-12 col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Video</label>
                            <input type="file" name="video" id="video" class="w-100 text-16 textdark px-4 py-2" accept="video/mp4, video/mkv, video/avi, video/webm">
                            @error('video')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="description" class="d-block text-18 fw-bold pb-2">Description<span class="text-danger">*<span></label>
                            <textarea name="description" id="description" class="w-100 text-16 textdark px-4 py-3 textarea ckeditor" placeholder="Description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Data -->
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Title</label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="meta_title" maxlength ="250" id="meta_title" value="{{ old('meta_title') }}">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Keywords</label>
                            <input type="text" placeholder="Keyword" class="w-100 text-16 textdark px-4 py-3" name="keyword" maxlength ="250" id="keyword" value="{{ old('keyword') }}">
                            @error('keyword')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Meta Description</label>
                            <input type="text" placeholder="Meta Description" class="w-100 text-16 textdark px-4 py-3" name="meta_description" id="meta_description" value="{{ old('meta_description') }}">
                            @error('meta_description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Canonical</label>
                            <input type="url" placeholder="Canonical" class="w-100 text-16 textdark px-4 py-3" name="canonical" id="canonical" value="{{ old('canonical') }}">
                            @error('canonical')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Order</label>
                            <input type="number" placeholder="Order" class="w-100 text-16 textdark px-4 py-3" name="order_by" id="order_by" min="1" max="9999" value="{{ old('order_by') }}">
                            @error('order_by')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Packages --}}
                        {{-- <div class="row mb-3 px-0 mx-auto plans_records align-items-start package_details hidden">
                            <h5 class="mb-4">Add Package Details</h5>
                            <div class="form-group col-xl-3 col-lg-4 col-md-5 mb-4">
                                <label for="" class="d-block text-18 fw-bold pb-2">Package Name<span class="text-danger">*</span></label>
                                <input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name[0]" id="package_name_0" value="{{ old('package_name') }}" maxlength="150" required>
                                @error('package_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-xl-2 col-lg-2 col-md-3 mb-4">
                                <label for="" class="d-block text-18 fw-bold pb-2">Days<span class="text-danger">*</span></label>
                                <input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days[0]" id="days_0" min="1" value="{{ old('days') }}" required>
                                @error('days')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-xl-2 col-lg-2 col-md-3 mb-4">
                                <label for="" class="d-block text-18 fw-bold pb-2">Cost (INR)<span class="text-danger">*</span></label>
                                <input type="number" placeholder="₹" class="w-100 text-16 textdark px-4 py-3" name="cost[0]" id="cost_0" min="1" value="{{ old('cost') }}" required>
                                @error('cost')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-xl-2 col-lg-2 col-md-4 mb-4">
                                <label for="" class="d-block text-18 fw-bold pb-2">Cost (USD)<span class="text-danger">*</span></label>
                                <input type="number" placeholder="$" class="w-100 text-16 textdark px-4 py-3" name="cost_usd[0]" id="cost_usd_0" min="1" value="{{ old('cost_usd') }}" required >
                                @error('cost_usd')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-xl-2 col-lg-2 col-md-4 mb-4">
                                <label for="" class="d-block text-18 fw-bold pb-2">Cost (EURO)<span class="text-danger">*</span></label>
                                <input type="number" placeholder="€" class="w-100 text-16 textdark px-4 py-3" name="cost_euro[0]" id="cost_euro_0" min="1" value="{{ old('cost_euro') }}" required >
                                @error('cost_euro')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-xl-1 col-lg-2 col-md-4 create-addmore-text px-sm-0 mb-sm-0 mb-4">
                                <a id="add-plan" class="text-primary fw-bold">+ Add More</a>
                            </div>
                        </div> --}}

                        <!-- Submit Button -->
                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Save</button>
                            <a href="{{ route('subcategory.index') }}" class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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
            $('#pageLoader').hide(1);
            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'File size must be less than 50 MB');  // Updated to reflect 50MB

            $.validator.addMethod('imagesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'File size must be less than 2 MB');  // Updated to reflect 50MB

            $.validator.addMethod("fileType", function(value, element) {
                var allowedTypes = ["jpg", "jpeg", "png", "webp"];
                return new RegExp('\\.(' + allowedTypes.join('|') + ')$', 'i').test(value);
            }, "The image must be a file of type: jpg, png, jpeg, webp!");

            $.validator.addMethod("noDecimal", function(value, element) {
                return this.optional(element) || !value.includes(".");
            }, "Decimal points are not allowed.");

            $.validator.addMethod("nonNegative", function(value, element) {
                return this.optional(element) || parseFloat(value) >= 0; // Allow only non-negative numbers
            }, "Negative numbers are not allowed.");

            $.validator.addMethod("minSecFormat", function(value, element) {
                // Regular expression to validate MM:SS format, where MM is 1-3 digits and SS is 2 digits
                var regex = /^(([01]?[0-9]|2[0-3]):([0-5]?[0-9]):([0-5]?[0-9]))|24:00:00$/;
                return this.optional(element) || regex.test(value);
            }, "Please enter time in HH:MM:SS format with valid two digits for hours, minutes and seconds.");

            // var i = 0;
            // $(document).on('click','#add-plan',function(){
            //     i++;
            //     var html =
            //             '<div class="row mb-3 px-0 mx-auto plan-row" data-index="' + i + '">' +
            //                 '<div class="form-group col-xl-3 col-lg-4 col-md-4 mb-3">' +
            //                     '<label for="" class="d-block text-18 fw-bold pb-2">Package Name<span class="text-danger">*</span></label>' +
            //                     '<input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name[' + i + ']" id="package_name_' + i + '" maxlength="150" required>' +
            //                 '</div>' +
            //                 '<div class="form-group col-xl-2 col-lg-2 col-md-2 mb-3">' +
            //                     '<label for="" class="d-block text-18 fw-bold pb-2">Days<span class="text-danger">*</span></label>' +
            //                     '<input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days[' + i + ']" id="days_' + i + '" min="1" data-rule-required="true" data-rule-max=999999 data-rule-noDecimal="true" data-rule-nonNegative="Negative numbers are not allowed." data-msg-max="Maximum 6 digits allowed." required>' +
            //                 '</div>' +
            //                 '<div class="form-group col-xl-2 col-lg-2 col-md-2 mb-3">' +
            //                     '<label for="" class="d-block text-18 fw-bold pb-2">Cost (INR)<span class="text-danger">*</span></label>' +
            //                     '<input type="number" placeholder="₹" class="w-100 text-16 textdark px-4 py-3" name="cost[' + i + ']" id="cost_' + i + '" min="1" data-rule-required="true" data-rule-max=999999 data-rule-noDecimal="true" data-rule-nonNegative="Negative numbers are not allowed." data-msg-max="Maximum 6 digits allowed." required>' +
            //                 '</div>' +
            //                 '<div class="form-group col-xl-2 col-lg-2 col-md-2 mb-3">' +
            //                     '<label for="" class="d-block text-18 fw-bold pb-2">Cost (USD)<span class="text-danger">*</span></label>' +
            //                     '<input type="number" placeholder="$" class="w-100 text-16 textdark px-4 py-3" name="cost_usd[' + i + ']" id="cost_usd_' + i + '" min="1" data-rule-max=999999 data-rule-noDecimal="true" data-rule-nonNegative="Negative numbers are not allowed." data-msg-max="Maximum 6 digits allowed." required>' +
            //                 '</div>' +
            //                 '<div class="form-group col-xl-2 col-lg-2 col-md-2 mb-3">' +
            //                     '<label for="" class="d-block text-18 fw-bold pb-2">Cost (EURO)<span class="text-danger">*</span></label>' +
            //                     '<input type="number" placeholder="€" class="w-100 text-16 textdark px-4 py-3" name="cost_euro[' + i + ']" id="cost_euro_' + i + '" min="1" data-rule-max=999999 data-rule-noDecimal="true" data-rule-nonNegative="Negative numbers are not allowed." data-msg-max="Maximum 6 digits allowed." required>' +
            //                 '</div>' +
            //                 '<div class="form-group col-xl-1 col-lg-2 col-md-2 align-self-center">' +
            //                 ' <a class="cancel_icon remove-plan"><i class="fa-regular fa-circle-xmark"></i></a>' +
            //                 '</div>'+
            //             '</div>';
            //     $('.plans_records').append(html);
            // });

            // $(document).on('click', '.remove-plan', function () {
            //     if ($('.plan-row').length > 0) {
            //         $(this).closest('.plan-row').remove();
            //     } else {
            //         alert('not display ad more record');
            //     }
            // });

            // $(document).on('change','#type',function(){
            //     var select_type = $(this).val();
            //     if(select_type == "free"){
            //         $('.package_details').addClass('hidden');
            //     }else{
            //         $('.package_details').removeClass('hidden');
            //     }
            // });

            $('#create_subcategory_form').validate({
                ignore: ":hidden:not(.ckeditor)",
                rules: {
                    cat_id: {
                        required: true,
                    },
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    image: {
                        imagesize: 2097152,
                        required: true,
                        fileType: true,
                    },
                    audio: {
                        required: true,
                        filesize: 50000000
                    },
                    video: {
                        required: false,
                        filesize: 50000000
                    },
                    type: {
                        required: true,
                    },
                    // "cost[0]": {
                    //     required: true,
                    //     noDecimal: true,
                    //     max: 999999,
                    //     nonNegative:true
                    // },
                    // "cost_usd[0]": {
                    //     noDecimal: true,
                    //     max: 999999,
                    //     noDecimal: true,
                    //     nonNegative:true
                    // },
                    // "cost_euro[0]": {
                    //     noDecimal: true,
                    //     max: 999999,
                    //     noDecimal: true,
                    //     nonNegative:true
                    // },
                    // "days[0]":{
                    //     required: true,
                    //     max: 999999,
                    //     noDecimal: true,
                    //     nonNegative:true
                    // },
                    description: {
                        required: function(textarea) {
                            CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    },
                    audio_duration: {
                        nonNegative: true,
                        minSecFormat: true
                    }
                },
                messages: {
                    category_id: {
                        // required: "Please select a category"
                    },
                    name: {
                        // required: "Please enter a subcategory name",
                    },
                    image: {
                        extension: "Please upload a valid image (jpg, jpeg, png, webp)",
                    },
                    audio: {
                        extension: "Please upload a valid audio file (mp3, wav, m4a)",
                        // filesize: "Audio file size must be less than 10MB"
                    },
                    video: {
                        extension: "Please upload a valid video file (mp4, mkv, avi, webm)",
                    },
                    type: {
                        // required: "Please select a type (Free or Premium)"
                    }
                    // "days[0]": {
                    //     max:"Maximum 6 digits allowed."
                    // },
                    // "cost[0]": {
                    //     max:"Maximum 6 digits allowed."
                    // },
                    // "cost_csd[0]":{
                    //     max:"Maximum 6 digits allowed."
                    // }
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
                    $('#pageLoader').show(1);
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
