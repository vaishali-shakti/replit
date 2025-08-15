@extends('FrontDashboard.master')
@section('content')
<div class="pageLoader" id="pageLoader"></div>
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit Sub Category</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_subcategory_form" method="POST" action="{{ route('subcategory.update', $subcategory->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') <!-- Use PATCH method for update -->

                    <div class="row porfile-form pt-4">
                        <!-- Category Dropdown -->
                        <div class="form-group col-lg-6 col-md-12 mb-4">
                            <label for="category_id" class="d-block text-18 fw-bold pb-2">Category<span class="text-danger">*<span></label>
                            <select name="cat_id" id="cat_id" class="w-100 text-16 textdark px-4" aria-label="Default select example" required>
                                <option selected disabled>--Select Category--</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $subcategory->cat_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
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
                                <option value="free" {{ old('type', $subcategory->payment_type) == 'free' ? 'selected' : '' }}>Free</option>
                                <option value="premium" {{ old('type', $subcategory->payment_type) == 'premium' ? 'selected' : '' }}>Premium</option>
                            </select>
                            @error('type')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategory Name -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="name" class="d-block text-18 fw-bold pb-2">Subcategory Name<span class="text-danger">*<span></label>
                            <input type="text" name="name" id="name" class="w-100 text-16 textdark px-4 py-3" maxlength ="150" placeholder="Subcategory Name" value="{{ old('name', $subcategory->name) }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                       <!-- Image -->
                       <div class="form-group col-lg-12 col-md-12 mb-4">
                        <label class="d-block text-18 fw-bold pb-2">Image<span class="text-danger">*</span></label>
                        <input type="file" class="ss_help" name="image" id="image" accept="image/png,image/jpeg,image/jpg,image/webp">
                            @if ($subcategory ->image)
                                <!-- Display the current image if it exists -->
                                <div class="mt-2">
                                    <img src="{{ $subcategory->image }}" id="image_preview_img" alt="Current Image" class="rounded" height="100px" width="100px"/>
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


                        <!-- Audio Upload (existing audio file displayed) -->
                        <div class="form-group col-12 col-lg-6 col-md-6 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Audio<span class="text-danger">*</span></label>
                            <input type="file" name="audio" id="audio" class="w-100 text-16 textdark px-4 py-2" accept="audio/mp3, audio/wav, audio/m4a"  @if(empty($subcategory->audio)) required @endif>
                            @if($subcategory->audio)
                                <div class="mt-2">
                                    <audio controls controlsList="nodownload">
                                        <source src="{{ Storage::disk('s3')->temporaryUrl('audio/'.$subcategory->audio,\Carbon\Carbon::now()->addMinutes(5)) }}" type="audio/mp3">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @endif
                            @error('audio')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Audio duration -->
                        <div class="form-group col-12 col-lg-6 col-md-6 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Audio Duration</label>
                            <input type="text" name="audio_duration" id="audio" placeholder="e.g.(HH:MM:SS)" class="w-100 text-16 textdark px-4 py-2" value="{{ old('audio_duration', $subcategory->audio_duration) }}">
                            @error('audio_duration')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Video Upload (existing video file displayed) -->
                        <div class="form-group col-12 col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Video</label>
                            <input type="file" name="video" id="video" class="w-100 text-16 textdark px-4 py-2" accept="video/mp4, video/mkv, video/avi, video/webm">
                            @if($subcategory->video)
                                <div class="mt-2">
                                    <video width="320" height="100%" controls class="rounded-3" oncontextmenu="return false;" controlsList="nodownload">
                                        <source src="{{ Storage::disk('s3')->temporaryUrl('video/'.$subcategory->video,\Carbon\Carbon::now()->addMinutes(5)) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endif
                            @error('video')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="description" class="d-block text-18 fw-bold pb-2">Description<span class="text-danger">*<span></label>
                            <textarea name="description" id="description" class="w-100 text-16 textdark px-4 py-3 ckeditor" placeholder="Description" required>{{ old('description', $subcategory->description) }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                         <!-- Meta Data -->
                         <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Title</label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="meta_title" maxlength ="250" id="meta_title" value="{{ old('meta_title', $subcategory->meta_title ?? '') }}">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Keywords</label>
                            <input type="text" placeholder="Keyword" class="w-100 text-16 textdark px-4 py-3" name="keyword" maxlength ="250" id="keyword" value="{{ old('keyword', $subcategory->keyword ?? '') }}">
                            @error('keyword')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Meta Description</label>
                            <input type="text" placeholder="Meta Description" class="w-100 text-16 textdark px-4 py-3" name="meta_description" id="meta_description" value="{{ old('meta_description',$subcategory->meta_description ?? '') }}">
                            @error('meta_description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Canonical</label>
                            <input type="url" placeholder="Canonical" class="w-100 text-16 textdark px-4 py-3" name="canonical" id="canonical" value="{{ old('canonical',$subcategory->canonical ?? '') }}">
                            @error('canonical')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Order</label>
                            <input type="number" placeholder="Order" class="w-100 text-16 textdark px-4 py-3" name="order_by" id="order_by" min="1" max="9999" value="{{ old('order_by',($subcategory->order_by ? $subcategory->order_by : '')) }}">
                            @error('order_by')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Packages --}}
                        {{-- <div class="row package_details {{ $subcategory->payment_type == 'free' ? 'hidden' : ''}}">
                            <h5 class="mb-3">Add Package Details</h5>
                            <input type="hidden" id="package_module" value="{{ count($subcategory->packages) }}">
                            @foreach($subcategory->packages as $key => $package)
                                <div class="row mb-3 mx-auto px-0">
                                    <input type="hidden" name="package_id[{{ $key }}]" id="package_id_{{ $key }}" value="{{ $package->id }}"/>
                                    <div class="form-group col-xl-3 col-lg-3 col-md-5 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Package Name<span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name[{{ $key }}]" id="name_{{ $key }}" value="{{ isset($package->name) ? $package->name : '' }}" maxlength="150" {{ $package->status == 0 ? 'disabled' : '' }} required>
                                        @error('package_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-2 col-md-3 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Days<span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days[{{ $key }}]" id="days_{{ $key }}" min="1" value="{{ isset($package->days) ? $package->days : '' }}" {{ $package->status == 0 ? 'disabled' : '' }} required>
                                        @error('days')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (INR)<span class="text-danger">*</span></label>
                                        <input type="number" placeholder="₹" class="w-100 text-16 textdark px-4 py-3" name="cost[{{ $key }}]" id="cost_{{ $key }}" min="1" value="{{ isset($package->cost) ? $package->cost : '' }}" {{ $package->status == 0 ? 'disabled' : '' }} required>
                                        @error('cost')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-3 col-md-4 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (USD)<span class="text-danger">*</span></label>
                                        <input type="number" placeholder="$" class="w-100 text-16 textdark px-4 py-3" name="dollar_cost[{{ $key }}]" id="dollar_cost_{{ $key }}" min="1" value="{{ isset($package->cost_usd) ? $package->cost_usd : '' }}" {{ $package->status == 0 ? 'disabled': '' }}>
                                        @error('dollar_cost')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-3 col-md-4 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (EURO)<span class="text-danger">*</span></label>
                                        <input type="number" placeholder="€" class="w-100 text-16 textdark px-4 py-3" name="cost_euro[{{ $key }}]" id="cost_euro_{{ $key }}" min="1" value="{{ isset($package->cost_euro) ? $package->cost_euro : '' }}" {{ $package->status == 0 ? 'disabled': '' }}>
                                        @error('cost_euro')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-1 col-lg-1 col-md-4 align-self-center switch-toggle">
                                        <label class="switch" for="status_{{ $key }}">
                                            <input type="checkbox" class="form-check-input float-none toggle_status" id="status_{{ $key }}" name="status[{{ $key }}]" value="{{ $package->id }}" data-href="{{ route('main_category.status_change',$package->id) }}" {{ $package->status == 1 ? 'checked' : '' }} data-key="{{ $key }}">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <div id="plans_records" class="px-0"></div>
                            <div class="form-group col-auto align-self-center">
                                <a id="add-plan" class="text-primary fw-bold">+ Add More</a>
                            </div>
                        </div> --}}
                        <!-- Submit Button -->
                        <div class="cetificate-btns col-12">
                            <button type="submit" class="save-btn text-22 my-md-3 mx-1 anim">Update</button>
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
            }, 'File size must be less than 50 MB');

            $.validator.addMethod('imagesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'File size must be less than 2 MB');


            $.validator.addMethod("fileType", function(value, element) {
                var allowedTypes = ["jpg", "jpeg", "png", "webp"];
                return new RegExp('\\.(' + allowedTypes.join('|') + ')$', 'i').test(value);
            }, "The image must be a file of type: jpg, png, jpeg, webp!");

            $.validator.addMethod("noDecimal", function(value, element) {
                return this.optional(element) || !value.includes(".");
            }, "Decimal points are not allowed.");

            $.validator.addMethod("nonNegative", function(value, element) {
                return this.optional(element) || parseFloat(value) >= 0;
            }, "Negative numbers are not allowed.");

            // var i = $('#package_module').val();
            // $(document).on('click', '#add-plan', function(e) {
            //     var html =
            //         '<div class="row mb-3 px-0 mx-auto plan-row">' +
            //             '<div class="form-group col-xl-3 col-lg-3 col-md-3 mb-3">' +
            //                 '<label for="" class="d-block text-18 fw-bold pb-2">Package Name <span class="text-danger">*</span></label>' +
            //                 '<input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name[' + i + ']" id="name_' + i + '" maxlength="150" required>' +
            //             '</div>' +
            //             '<div class="form-group col-xl-2 col-lg-2 col-md-2 mb-3">' +
            //                 '<label for="" class="d-block text-18 fw-bold pb-2">Days <span class="text-danger">*</span></label>' +
            //                 '<input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days[' + i + ']" id="days_' + i + '" min="1" required>' +
            //             '</div>' +
            //             '<div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">' +
            //                 '<label for="" class="d-block text-18 fw-bold pb-2">Cost (INR) <span class="text-danger">*</span></label>' +
            //                 '<input type="number" placeholder="₹" class="w-100 text-16 textdark px-4 py-3" name="cost[' + i + ']" id="cost_' + i + '" min="1" required>' +
            //             '</div>' +
            //             '<div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">' +
            //                 '<label for="" class="d-block text-18 fw-bold pb-2">Cost (USD)<span class="text-danger">*</span></label>' +
            //                 '<input type="number" placeholder="$" class="w-100 text-16 textdark px-4 py-3" name="dollar_cost[' + i + ']" id="dollar_cost_' + i + '" min="1" required>' +
            //             '</div>' +
            //             '<div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">' +
            //                 '<label for="" class="d-block text-18 fw-bold pb-2">Cost (EURO)<span class="text-danger">*</span></label>' +
            //                 '<input type="number" placeholder="€" class="w-100 text-16 textdark px-4 py-3" name="cost_euro[' + i + ']" id="cost_euro_' + i + '" min="1" required>' +
            //             '</div>' +
            //             '<div class="form-group col-xl-1 col-lg-1 col-md-1 align-self-center">' +
            //             ' <a class="cancel_icon remove-plan"><i class="fa-regular fa-circle-xmark"></i></a>' +
            //             '</div>' +
            //         '</div>';
            //     $('#plans_records').append(html);

            //     $(`#name_`+i).rules("add", {
            //         required: true,
            //         maxlength: 150,
            //         messages: {
            //             maxlength: "Maximum 150 characters allowed.",
            //         },
            //     });
            //     $(`#days_`+i).rules("add", {
            //         required: true,
            //         max: 999999,
            //         nonNegative: true,
            //         messages: {
            //              max: "Maximum 6 digits allowed."
            //         },
            //     });
            //     $(`#cost_`+i).rules("add", {
            //         required: true,
            //         max: 999999,
            //         nonNegative: true,
            //         messages: {
            //             max: "Maximum 6 digits allowed."
            //         },
            //     });
            //     $(`#dollar_cost_`+i).rules("add", {
            //         required:true,
            //         max: 999999,
            //         nonNegative: true,
            //         messages: {
            //             max: "Maximum 6 digits allowed."
            //         },
            //     });
            //     $(`#cost_euro_`+i).rules("add", {
            //         required:true,
            //         max: 999999,
            //         nonNegative: true,
            //         messages: {
            //             max: "Maximum 6 digits allowed."
            //         },
            //     });

            //     i++;
            // });
            // $(document).on('click','.remove-plan',function(){
            //     if($('.plan-row').length > 0){
            //         $(this).closest('.plan-row').remove();
            //     }else{
            //         alert('not display alert record');
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
            $(document).on('click','.toggle_status',function(){
                var mode = $(this).prop('checked');
                var url = $(this).data('href');
                var key = $(this).data('key');
                var $this = $(this);
                var package_data = $(`#name_${key},#days_${key},#cost_${key},#dollar_cost_${key},#cost_euro_${key}`);
                package_data.prop('disabled',!mode);
                $.ajax({
                    url: url,
                    type:'GET',
                    data:{
                        status: mode ? 1 : 0,
                    },
                    success:function(data){
                        if(data.status == 1){
                            toastr_success('Status changed successfully.');
                        }else if(data.status == 2){
                            $this.prop('checked',!mode);
                            toastr_error('At least one package must remain active.');
                        }else{
                            toastr_error('something went wrong');
                        }
                    }
                });
            })
            $('#edit_subcategory_form').validate({
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
                        required: false,
                        imagesize: 2097152
                    },
                    audio: {
                        filesize: 50000000
                    },
                    video: {
                        required: false,
                        filesize: 50000000
                    },
                    description: {
                        required: function(textarea) {
                            CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    },
                    type: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        maxlength: "Subcategory name cannot be longer than 255 characters"
                    },
                    image: {
                        extension: "Please upload a valid image (jpg, jpeg, png, webp)",
                    },
                    audio: {
                        extension: "Please upload a valid audio file (mp3, wav, m4a)",
                    },
                    video: {
                        extension: "Please upload a valid video file (mp4, mkv, avi, webm)",
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
                    $('#pageLoader').show(1);
                    form.submit();
                }
            });
            $('[name^="package_name"], [name^="days"], [name^="cost"], [name^="dollar_cost"], [name^="cost_euro"]').each(function() {
                // Add validation for each packages
                var name = $(this).attr('name');
                console.log(name,"name");
                if (name.startsWith('package_name')) {
                    $(this).rules('add', {
                        required: true,
                        maxlength: 150,
                        messages: {
                            maxlength: `Maximum 150 characters allowed.`
                        }
                    });
                } else if (name.startsWith('days')) {
                    $(this).rules('add', {
                        required: true,
                        max: 999999,
                        noDecimal: true,
                        nonNegative:true,
                        messages: {
                            max:`Maximum 6 digits allowed.`
                        }
                    });
                }
                else if (name.startsWith('cost')) {
                    $(this).rules('add', {
                        required: true,
                        max: 999999,
                        noDecimal: true,
                        nonNegative:true,
                        messages: {
                            max:`Maximum 6 digits allowed.`

                        }
                    });
                }
                else if (name.startsWith('dollar_cost')) {
                    $(this).rules('add', {
                        required:true,
                        max: 999999,
                        noDecimal: true,
                        nonNegative:true,
                        messages: {
                            max:`Maximum 6 digits allowed.`
                        }
                    });
                }
                else if (name.startsWith('cost_euro')) {
                    $(this).rules('add', {
                        required:true,
                        max: 999999,
                        noDecimal: true,
                        nonNegative:true,
                        messages: {
                            max:`Maximum 6 digits allowed.`
                        }
                    });
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
    //    $(document).ready(function() {
    //         $('.ckeditor').ckeditor();
    //     });
    </script>
@endsection
