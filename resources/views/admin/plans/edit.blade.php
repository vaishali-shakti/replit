@extends('FrontDashboard.master')
@section('content')
<div class="container px-0">
    <h2 class="text-21 fw-bold mb-4">Edit Plans</h2>
    <div class="profile px-0 pt-0">
        <div class="content-box">
            <form id="edit_plan_form" method="post" action="{{ route('plans.update',$plans->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row porfile-form pt-4">
                    <div class="form-group col-lg-6 col-md-6 mb-4">
                        <label for="" class="d-block text-18 fw-bold pb-2">Package Name<span class="text-danger">*</span></label>
                        <input type="text" placeholder="Package Name" class="w-100 text-16 textdark px-4 py-3" name="name" id="name" value="{{ isset($plans->name) ? $plans->name : '' }}" maxlength="100" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-6 mb-4">
                        <label for="" class="d-block text-18 fw-bold pb-2">Days<span class="text-danger">*</span></label>
                        <input type="number" placeholder="Days" class="w-100 text-16 textdark px-4 py-3" name="days" id="days" min="1" value="{{ isset($plans->days) ? $plans->days : '' }}" required>
                        @error('days')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-6 mb-4">
                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (INR)<span class="text-danger">*</span></label>
                        <input type="number" placeholder="₹" class="w-100 text-16 textdark px-4 py-3" name="cost" id="cost" min="1" value="{{ isset($plans->cost) ? $plans->cost : '' }}" required>
                        @error('cost')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-6 mb-4">
                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (USD)<span class="text-danger">*</span></label>
                        <input type="number" placeholder="$" class="w-100 text-16 textdark px-4 py-3" name="cost_usd" id="cost_usd" min="1" value="{{ isset($plans->cost_usd) && $plans->cost_usd != null ? $plans->cost_usd : '' }}" required>
                        @error('cost_usd')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-6 mb-4">
                        <label for="" class="d-block text-18 fw-bold pb-2">Cost (EURO)<span class="text-danger">*</span></label>
                        <input type="number" placeholder="€" class="w-100 text-16 textdark px-4 py-3" name="cost_euro" id="cost_euro" min="1" value="{{ isset($plans->cost_euro) && $plans->cost_euro != null ? $plans->cost_euro : '' }}" required>
                        @error('cost_euro')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-6 mb-4">
                        <label for="" class="d-block text-18 fw-bold pb-2">Order</label>
                        <input type="number" placeholder="Order" class="w-100 text-16 textdark px-4 py-3" name="order_by" id="order_by" min="1" max="9999" value="{{ old('order_by',($plans->order_by ? $plans->order_by : '')) }}">
                        @error('order_by')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="cetificate-btns col-12">
                        <button type="submit"class="save-btn text-22 my-md-3 mx-1 anim">Update</button></a>
                        <a href="{{route('plans.index')}}"class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $.validator.addMethod("noDecimal", function(value, element) {
            return this.optional(element) || !value.includes(".");
        }, "Decimal points are not allowed.");

        $.validator.addMethod("nonNegative", function(value, element) {
            return this.optional(element) || parseFloat(value) >= 0; // Allow only non-negative numbers
        }, "Negative numbers are not allowed.");

        $('#edit_plan_form').validate({
            rules: {
                name: {
                    required: true,
                },
                days:{
                    required:true,
                    nonNegative: true,
                    noDecimal:true,
                    max:999999
                },
                cost: {
                    required: true,
                    noDecimal:true,
                    max:999999,
                    nonNegative:true
                },
                cost_usd:{
                    required:true,
                    noDecimal:true,
                    max:999999,
                    nonNegative:true
                },
                cost_euro:{
                    required:true,
                    noDecimal:true,
                    max:999999,
                    nonNegative:true
                }
            },
            messages: {
                days:{
                    max:"Maximum 6 digits allowed."
                },
                cost: {
                    max:"Maximum 6 digits allowed."
                },
                cost_usd: {
                    max:"Maximum 6 digits allowed."
                },
                cost_euro: {
                    max:"Maximum 6 digits allowed."
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



