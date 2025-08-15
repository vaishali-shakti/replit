@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <h2 class="text-21 fw-bold mb-4">Create testimonial</h2>
        <div class="profile px-0 pt-0">
            <div class="content-box">
                <form id="create_testimonial_form" method="post" action="{{ route('testimonial.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row porfile-form pt-4">
                        <div class="form-group col-lg-12 col-md-12 mb-4">
                            <label for="" class="d-block text-18 fw-bold pb-2">Email<span class="text-danger">*<span></label>
                            <input type="text" placeholder="Email" class="w-100 text-16 textdark px-4 py-3" name="email" maxlength ="50" id="email" value="" required>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="cetificate-btns col-12">
                            <button type="submit" id="SubmitBtn" class="save-btn text-22 my-md-3 mx-1 anim">Save</button>
                            <a href="{{route('testimonial.index')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
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
       
            $('#create_testimonial_form').validate({
                rules: {
                    email: {
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
