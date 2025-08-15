@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Super Create Category</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="create_category_form" method="post" action="{{ route('category.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row porfile-form pt-4 p-2">
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Category Name<span class="text-danger">*</span></label>
                            <input type="text" placeholder="Category Name" class="w-100 text-16 textdark px-4 py-3" name="name" maxlength="150" id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Title</label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="meta_title" maxlength="250" id="meta_title" value="{{ old('meta_title') }}">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Keywords</label>
                            <input type="text" placeholder="Keyword" class="w-100 text-16 textdark px-4 py-3" name="keyword" maxlength="250" id="keyword" value="{{ old('keyword') }}">
                            @error('keyword')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Description</label>
                            <input type="text" placeholder="Description" class="w-100 text-16 textdark px-4 py-3" name="description" id="description"  value="{{ old('description') }}">
                            @error('description')
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
                        {{-- <h5 class="mb-3">Add Package Details</h5>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Package Name<span class="text-danger">*</span></label>
                            <input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name" id="package_name" value="{{ old('package_name') }}" maxlength="50" required>
                            @error('package_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Times/Day<span class="text-danger">*</span></label>
                            <input type="number" placeholder="Times/Day" class="w-100 text-16 textdark px-4 py-3" name="times_day" id="times_day" value="{{ "1" }}" readonly required>
                            @error('times_day')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Days<span class="text-danger">*</span></label>
                            <input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days" id="days" value="{{ "30" }}" readonly required>
                            @error('days')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Cost (Rs)<span class="text-danger">*</span></label>
                            <input type="number" placeholder="Cost (Rs)" class="w-100 text-16 textdark px-4 py-3" name="cost" id="cost" value="{{ old('cost') }}" required>
                            @error('cost')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Save</button>
                            <a href="{{route('category.index')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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

            $('#create_category_form').validate({
                rules: {
                    name: {
                        required: true,
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
