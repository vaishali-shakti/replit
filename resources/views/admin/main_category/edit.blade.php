@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Edit Main Category</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_subcategory_form" method="POST" action="{{ route('main_category.update', $main_category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') <!-- Use PATCH method for update -->

                    <div class="row porfile-form pt-4">
                        <!-- Category Dropdown -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="category_id" class="d-block text-18 fw-bold pb-2">Category<span class="text-danger">*<span></label>
                            <select name="cat_id" id="cat_id" class="w-100 text-16 textdark px-4" aria-label="Default select example" required>
                                <option selected disabled>--Select Category--</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $main_category->super_cat_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cat_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategory Name -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="name" class="d-block text-18 fw-bold pb-2">Main Category Name<span class="text-danger">*<span></label>
                            <input type="text" name="name" id="name" class="w-100 text-16 textdark px-4 py-3" placeholder="Main Category Name" value="{{ old('name', $main_category->name) }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Image -->
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label class="d-block text-18 fw-bold pb-2">Image<span class="text-danger">*</span></label>
                            <input type="file" class="ss_help" name="image" id="image" accept="image/png,image/jpeg,image/jpg,image/webp">
                                @if ($main_category ->image)
                                    <!-- Display the current image if it exists -->
                                    <div class="mt-2">
                                        <img src="{{ $main_category->image }}" id="image_preview_img" alt="Current Image" class="rounded" height="100px" width="100px"/>
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
                            <label for="description" class="d-block text-18 fw-bold pb-2">Description<span class="text-danger">*<span></label>
                            <textarea name="description" id="description" class="w-100 text-16 textdark px-4 py-3 ckeditor"  placeholder="Description" required>{{ old('description', $main_category->description) }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                         <!-- Meta Data -->
                         <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Title</label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="meta_title" maxlength ="250" id="meta_title" value="{{ old('meta_title', $main_category->meta_title ?? '') }}">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Keywords</label>
                            <input type="text" placeholder="Keyword" class="w-100 text-16 textdark px-4 py-3" name="keyword" maxlength ="250" id="keyword" value="{{ old('keyword', $main_category->keyword ?? '') }}">
                            @error('keyword')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Meta Description</label>
                            <input type="text" placeholder="Meta Description" class="w-100 text-16 textdark px-4 py-3" name="meta_description" id="meta_description"  value="{{ old('meta_description',$main_category->meta_description ?? '') }}">
                            @error('meta_description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Canonical</label>
                            <input type="url" placeholder="Canonical" class="w-100 text-16 textdark px-4 py-3" name="canonical" id="canonical" value="{{ old('canonical',$main_category->canonical ?? '') }}">
                            @error('canonical')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Order</label>
                            <input type="number" placeholder="Order" class="w-100 text-16 textdark px-4 py-3" name="order_by" id="order_by" min="1" max="9999" value="{{ old('order_by',($main_category->order_by ? $main_category->order_by : '')) }}">
                            @error('order_by')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- special music -->
                        <div class="form-group col-lg-6 col-md-12 mb-4 d-flex align-items-center special_music_col p-0">
                            <div class="form-check d-flex gap-2 align-items-center ps-0" style="padding-inline:12px !important">
                                <!-- Corrected 'old()' to match the checkbox name -->
                                <input type="checkbox" name="specialmusic" id="specialmusic" class="selectbox" value="1" {{ old('specialmusic', $main_category->special_music ?? 0) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label text-18 fw-bold d-flex align-items-center" for="specialmusic">
                                    Special music
                                </label>
                                @error('specialmusic')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        {{-- Packages --}}
                        <h5 class="mb-3">Add Package Details</h5>
                        <input type="hidden" id="package_module" value="{{ count($main_category->packages) }}">
                            @foreach($main_category->packages as $key => $package)
                                <div class="row mb-3 px-0 mx-auto align-items-start">
                                    <input type="hidden" name="package_id[{{ $key }}]" id="package_id_{{ $key }}" value="{{ $package->id }}"/>
                                    <div class="form-group col-xl-2 col-lg-3 col-md-5 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Package Name<span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name[{{ $key }}]" id="name_{{ $key }}" value="{{ isset($package->name) ? $package->name : '' }}" data-index="{{ $key }}" maxlength="150" {{ $package->status == 0 ? 'disabled' : '' }} required>
                                        @error('times_day')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-2 col-md-4 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Days<span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days[{{ $key }}]" id="days_{{ $key }}" min="1" value="{{ isset($package->days) ? $package->days : '' }}" {{ $package->status == 0 ? 'disabled' : '' }} required>
                                        @error('days')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-3 col-md-4 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (INR)<span class="text-danger">*</span></label>
                                        <input type="number" placeholder="₹" class="w-100 text-16 textdark px-4 py-3" name="cost[{{ $key }}]" id="cost_{{ $key }}" min="1" value="{{ isset($package->cost) ? $package->cost : '' }}" {{ $package->status == 0 ? 'disabled' : '' }} required>
                                        @error('cost')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (USD)<span class="text-danger">*</span></label>
                                        <input type="number" placeholder="$" class="w-100 text-16 textdark px-4 py-3" name="dollar_cost[{{ $key }}]" id="dollar_cost_{{ $key }}" min="1" value="{{ isset($package->cost_usd) ? $package->cost_usd : '' }}" {{ $package->status == 0 ? 'disabled': '' }} required>
                                        @error('cost_usd')
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
                                    <div class="form-group col-xl-1 col-lg-2 col-md-4 mb-4">
                                        <label for="" class="d-block text-18 fw-bold pb-2">Order</label>
                                        <input type="number" placeholder="Order" class="w-100 text-16 textdark px-4 py-3" name="package_order_by[{{ $key }}]" id="order_by_{{ $key }}" min="1" max="9999" value = "{{ isset($package->packages_order_by) ? $package->packages_order_by : '' }}" {{ $package->status == 0 ? 'disabled': ''}}>
                                        @error('order_by')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-1 col-lg-1 col-md-3 switch-toggle create-addmore-text">
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

                            <!-- Submit Button -->
                            <div class="cetificate-btns col-12">
                                <button type="submit" class="save-btn text-22 my-md-3 mx-1 anim">Update</button>
                                <a href="{{ route('main_category.index') }}" class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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

            var i = $('#package_module').val();
            $(document).on('click','#add-plan',function(){
                var html =
                    '<div class="row mb-3 px-0 mx-auto plan-row">' +
                        '<div class="form-group col-xl-3 col-lg-3 col-md-3 mb-3">' +
                            '<label for="" class="d-block text-18 fw-bold pb-2">Package Name <span class="text-danger">*</span></label>' +
                            '<input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name[' + i + ']" id="name_' + i + '" maxlength="150" required>' +
                        '</div>' +
                        '<div class="form-group col-xl-2 col-lg-2 col-md-2 mb-3">' +
                            '<label for="" class="d-block text-18 fw-bold pb-2">Days <span class="text-danger">*</span></label>' +
                            '<input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days[' + i + ']" id="days_' + i + '" min="1" required>' +
                        '</div>' +
                        '<div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">' +
                            '<label for="" class="d-block text-18 fw-bold pb-2">Cost (INR) <span class="text-danger">*</span></label>' +
                            '<input type="number" placeholder="₹" class="w-100 text-16 textdark px-4 py-3" name="cost[' + i + ']" id="cost_' + i + '" min="1" required>' +
                        '</div>' +
                        '<div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">' +
                            '<label for="" class="d-block text-18 fw-bold pb-2">Cost (USD)<span class="text-danger">*</span></label>' +
                            '<input type="number" placeholder="$" class="w-100 text-16 textdark px-4 py-3" name="dollar_cost[' + i + ']" id="dollar_cost_' + i + '" min="1" required>' +
                        '</div>' +
                        '<div class="form-group col-xl-2 col-lg-3 col-md-3 mb-3">' +
                            '<label for="" class="d-block text-18 fw-bold pb-2">Cost (EURO)<span class="text-danger">*</span></label>' +
                            '<input type="number" placeholder="€" class="w-100 text-16 textdark px-4 py-3" name="cost_euro[' + i + ']" id="cost_euro_' + i + '" min="1" required>' +
                        '</div>' +
                        '<div class="form-group col-xl-1 col-lg-2 col-md-2 mb-3">' +
                                '<label for="" class="d-block text-18 fw-bold pb-2">Order</label>' +
                                '<input type="number" placeholder="Order" class="w-100 text-16 textdark px-4 py-3" name="package_order_by[' + i + ']" id="order_by_' + i + '" value="'  + '" >' +
                            '</div>' +
                        '<div class="form-group col-xl-1 col-lg-1 col-md-1 align-self-center">' +
                           ' <a class="cancel_icon remove-plan"><i class="fa-regular fa-circle-xmark"></i></a>' +
                        '</div>' +
                    '</div>';
                $('#plans_records').append(html);

                $(`#name_`+i).rules("add", {
                    required: true,
                    maxlength: 150,
                    messages: {
                        maxlength: "Maximum 150 characters allowed.",
                    },
                });
                $(`#days_`+i).rules("add", {
                    required: true,
                    max: 999999,
                    nonNegative: true,
                    messages: {
                         max: "Maximum 6 digits allowed."
                    },
                });
                $(`#cost_`+i).rules("add", {
                    required: true,
                    max: 999999,
                    nonNegative: true,
                    messages: {
                        max: "Maximum 6 digits allowed."
                    },
                });
                $(`#dollar_cost_`+i).rules("add", {
                    required: true,
                    max: 999999,
                    nonNegative: true,
                    messages: {
                        max: "Maximum 6 digits allowed."
                    },
                });

                // Increment the index
                i++;
            });

            $(document).on('click', '.remove-plan', function () {
                if ($('.plan-row').length > 0) {
                    $(this).closest('.plan-row').remove();
                } else {
                    alert('not display add more record');
                }
            });

            $(document).on('click','.toggle_status',function(){
                var mode= $(this).prop('checked');
                var url = $(this).data('href');
                var key = $(this).data('key');
                var $this = $(this);

                var package_data = $(`#name_${key}, #days_${key}, #cost_${key}, #dollar_cost_${key}`);
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
            });
            $('#edit_subcategory_form').validate({
                ignore: [],
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
                        filesize: 2097152
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
                    form.submit();
                }
            });
            $('[name^="package_name"], [name^="days"], [name^="cost"], [name^="dollar_cost"]').each(function() {
                // Add validation for each packages
                var name = $(this).attr('name');
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
                        required: true,
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
    </script>
@endsection
