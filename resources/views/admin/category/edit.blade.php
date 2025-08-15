@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Super Edit Category</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="edit_category_form" method="post" action="{{ route('category.update',$category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row porfile-form pt-4">
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Category Name<span class="error">*<span></label>
                                <input type="text" placeholder="Category Name" class="w-100 text-16 textdark px-4 py-3" name="name" maxlength="150" id="name" value="{{ old('name',$category->name ?? '') }}" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Title</label>
                            <input type="text" placeholder="Title" class="w-100 text-16 textdark px-4 py-3" name="meta_title" maxlength="250" id="meta_title" value="{{ old('meta_title',$category->meta_title ?? '') }}">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Keywords</label>
                            <input type="text" placeholder="Keyword" class="w-100 text-16 textdark px-4 py-3" name="keyword" maxlength="250" id="keyword" value="{{ old('keyword',$category->keyword ?? '') }}">
                            @error('keyword')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Description</label>
                            <input type="text" placeholder="Description" class="w-100 text-16 textdark px-4 py-3" name="description" id="description" value="{{ old('description',$category->description ?? '') }}">
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Canonical</label>
                            <input type="url" placeholder="Canonical" class="w-100 text-16 textdark px-4 py-3" name="canonical" id="canonical" value="{{ old('canonical',$category->canonical ?? '') }}">
                            @error('canonical')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Order</label>
                            <input type="number" placeholder="Order" class="w-100 text-16 textdark px-4 py-3" name="order_by" id="order_by" min="1" max="9999" value="{{ old('order_by',($category->order_by ? $category->order_by : '')) }}">
                            @error('order_by')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <h5 class="mb-3">Add Package Details</h5>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Package Name<span class="text-danger">*</span></label>
                            <input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="package_name" id="package_name" value="{{ old('package_name',(isset($category->packages->name) ? $category->packages->name : '' )) }}" maxlength="50" required>
                            @error('package_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Times/Day<span class="text-danger">*</span></label>
                            <input type="number" placeholder="Times/Day" class="w-100 text-16 textdark px-4 py-3" name="times_day" id="times_day" value="{{ "1", (isset($category->packages->times_day) ? $category->packages->times_day : '' ) }}" readonly required>
                            @error('times_day')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Days<span class="text-danger">*</span></label>
                            <input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days" id="days" value="{{ "30",(isset($category->packages->days) ? $category->packages->days : '' ) }}" readonly required>
                            @error('days')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 mb-3">
                            <label for="" class="d-block text-18 fw-bold pb-2">Cost (Rs)<span class="text-danger">*</span></label>
                            <input type="number" placeholder="Cost (Rs)" class="w-100 text-16 textdark px-4 py-3" name="cost" id="cost" value="{{ old('cost',(isset($category->packages->cost) ? $category->packages->cost : '' )) }}" required>
                            @error('cost')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <div class="cetificate-btns col-12">
                            <button type="submit"class="save-btn text-22 my-md-3 mx-1 anim">Update</button></a>
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
            $('#edit_category_form').validate({
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

            });
        });
    </script>
@endsection
