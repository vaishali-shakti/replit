@extends('front.layouts.master')
@section('content')

<section>
    <div class="dashboard-wraaper">
        <div class="container user_dashboard_conatiner">
            <div class="row">
                <div class="col-xl-3 col-lg-3">
                    <div class="nav_wrapper">
                        <nav class="user_nav_box">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link {{ Request::segment(2) == null ? 'active' : ''}}" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">update profile</button>
                                <button class="nav-link {{ Request::segment(2) == "pur-frequency" ? 'active' : '' }}" id="nav-purchase-tab" data-bs-toggle="tab" data-bs-target="#nav-purchase" type="button" role="tab" aria-controls="nav-purchase" aria-selected="false">Subscriptions</button>
                                <button class="nav-link {{ Request::segment(2) == "support" ? 'active' : ''}}" id="nav-supporter-tab" data-bs-toggle="tab" data-bs-target="#nav-supporter" type="button" role="tab" aria-controls="nav-supporter" aria-selected="false">support</button>
                                <button class="nav-link {{ Request::segment(2) == "change-pass" ? 'active' : '' }}" id="nav-password-tab" data-bs-toggle="tab" data-bs-target="#nav-password" type="button" role="tab" aria-controls="nav-password" aria-selected="false">change password</button>
                                <a href="{{ route('front.logout') }}" class="nav-link text-center">Logout</a>
                            </div>
                        </nav>
                      </div>
                </div>

                <div class="col-xl-9 col-lg-9">
                    <div class="dashboard-content">
                        <div class="tab-content" id="nav-tabContent">

                             <!-- ---------------- Update Profile       ---------------- -->
                            <div class="tab-pane fade show {{ Request::segment(2) == null ? 'active' : ''  }}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                     <div>
                                        <form id="edit_user_form" action="{{ route('front_update_profile',['id' => isset($user) ? $user->id : '']) }}" method="Post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row porfile-form pt-2">
                                                <div class="col-12">
                                                    <h4 class="content_title">update profile</h4>
                                                </div>
                                                <!-- Name Field -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="name" class="login_label fw-bold">Name<span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="Name" class="form-control" name="name" maxlength="50" id="name" value="{{ old('name',$user->name ?? '') }}" required>
                                                </div>
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                                <!-- DOB Field -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="dob" class="login_label fw-bold">DOB<span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="YYYY/MM/DD" class="form-control" name="dob" id="dob" value="{{ old('dob', $user->dob ? date('d-m-Y', strtotime($user->dob)) : '') }}" autocomplete="off" required>
                                                </div>
                                                @error('dob')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                                <!-- Time of Birth -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="time_of_birth" class="login_label fw-bold">Time of birth (AM/PM)</label>
                                                    <input type="time" placeholder="Time of birth (AM/PM)" class="form-control" name="time_of_birth" id="time_of_birth" value="{{ old('time_of_birth', ($user->time_of_birth ? date("H:i", strtotime($user->time_of_birth)) : null)) }}">
                                                    @error('time_of_birth')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- Place of Birth -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="place_of_birth" class="login_label  fw-bold">Place of birth</label>
                                                    <input type="text" placeholder="Place of birth" class="form-control" maxlength="100" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth',$user->place_of_birth ?? '') }}">
                                                </div>
                                                @error('place_of_birth')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                                <!-- Mobile No. 1 -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="mobile_number_1" class="login_label mb-2  fw-bold">Mobile No. 1<span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="Mobile No. 1" class="form-control" name="mobile_number_1" id="mobile_number_1" value="{{ old('mobile_number_1',$user->mobile_number_1 ?? '') }}" pattern="[0-9]+" required>
                                                </div>
                                                @error('mobile_number_1')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                                <!-- Mobile No. 2 -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="mobile_number_2" class="login_label mb-2  fw-bold">Mobile No. 2</label>
                                                    <input type="text" placeholder="Mobile No. 2" class="form-control" name="mobile_number_2" id="mobile_number_2" value="{{ old('mobile_number_2',$user->mobile_number_2 ?? '') }}" pattern="[0-9]+">
                                                </div>
                                                @error('mobile_number_2')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                                <!-- Email -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="email" class="login_label fw-bold">Email<span class="text-danger">*</span></label>
                                                    <input type="email" placeholder="Email" class="form-control" name="email" id="email" value="{{ old('email',$user->email ?? '') }}" required readonly>
                                                </div>
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <!-- Discomfort -->
                                                <div class="form-group col-lg-6 col-md-12 mb-4">
                                                    <label for="discomfort" class="login_label fw-bold">Your discomfort</label>
                                                    <input type="text" placeholder="Your discomfort" class="form-control" maxlength="150" name="discomfort" id="discomfort" value="{{ old('discomfort',$user->discomfort ?? '') }}">
                                                </div>
                                                @error('discomfort')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                    <!-- Photo Upload -->
                                                    <div class="form-group col-lg-12 col-md-12 mb-4">
                                                        <label class="login_label fw-bold">Your photo with white background<span class="text-danger">*</span></label>
                                                        <input type="file" class="ss_help form-control" name="image" id="image" accept="image/png,image/jpeg,image/jpg,image/webp">
                                                        @if ($user->image)
                                                        <!-- Display the current image if it exists -->
                                                        <div class="mt-2">
                                                            <img src="{{ $user->image }}" id="image_preview_img" alt="Current Image" class="rounded-3" height="100px" width="100px" loading="lazy"/>
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


                                                <!-- Submit & Cancel Buttons -->
                                                <div class="d-flex gap-3 align-items-center col-12 flex-wrap">
                                                    <button type="submit" id="update_btn" class="btn">Update</button>
                                                    <a href="{{ route('home') }}">
                                                       <button type="button" id="Cancelbtn" class="btn  profile_cancel">Cancel</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                     </div>
                            </div>

                            <!-- --------------- change password tab  ------------ -->
                            <div class="tab-pane fade {{ Request::segment(2) == "change-pass" ? 'show active' : '' }}" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab" tabindex="0">
                                <div>
                                    <form id="change_password_form" method="POST" action="{{ route('front_change_password') }}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row pt-2">
                                            <div class="col-12">
                                                <h4 class="content_title">change password</h4>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group input-field pass_field">
                                                    <label class="login_label mb-2 fw-bold">Current Password <span class="error">*</span></label>
                                                    <div class="position-relative d-flex align-items-center">
                                                        <input type="password" class="text form-control mt-0" name="password" id="password" placeholder="Enter Current Password" required>
                                                        <i class="fas fa-eye user_change_icon" id="togglePassword1"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group input-field pass_field">
                                                    <label class="login_label mb-2 fw-bold">New Password <span class="error">*</span></label>
                                                    <div class="position-relative d-flex">
                                                      <input type="password" class="password form-control mt-0" name="new_password" id="new_password" placeholder="Enter New Password" required>
                                                      <i class="fas fa-eye user_change_icon" id="togglePassword2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-4">
                                                <div class="form-group input-field pass_field">
                                                    <label  class="login_label mb-2 fw-bold">Confirm Password <span class="error">*</span></label>
                                                    <div class="position-relative d-flex">
                                                        <input type="password" class="password form-control mt-0" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password" required>
                                                        <i class="fas fa-eye user_change_icon" id="togglePassword3" ></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-field button login_btn_design mt-3">
                                                <button type="submit" class="btn btn-sm btn-block change_pass_btn mb-2">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- --------------- purchase_category tab  ------------ -->
                            <div class="tab-pane fade {{ Request::segment(2) == "pur-frequency" ? 'show active' : '' }}" id="nav-purchase" role="tabpanel" aria-labelledby="nav-purchase-tab" tabindex="0">
                                <div class="w-100">
                                    <div class="row w-100 px-2 mx-auto pt-2">
                                        <div class="col-12 px-0">
                                            <h4 class="content_title">Subscriptions</h4>
                                        </div>
                                        @if((request()->get('page') == null) || (request()->get('page') != null && request()->get('page') == 1))
                                            @foreach($pur_payment as $key => $payment)
                                                @if($payment->type == 1)
                                                    <div class="col-12 px-0 mb-3">
                                                        <a href="{{ route('home') }}">
                                                            <div class="purchase_card row align-content-center justify-content-md-start justify-content-center mx-sm-0 mx-auto">
                                                                    <div class="pur_img_box col-xl-2 col-lg-2 col-md-2 col-12">
                                                                        <img src="{{ getSetting('logo') != null ? url('storage/setting', getSetting('logo')) : asset('assets/front/image/logo.png') }}" alt="img" loading="lazy">
                                                                    </div>
                                                                    <div class="pur_content {{ (active_until_active($payment->id) == true) ? 'col-xl-7 col-lg-7 col-md-9 col-12' : 'col-xl-10 col-lg-10 col-md-9 col-12'}}">
                                                                        <h4 class="pur_title">All-Inclusive Deal</h4>
                                                                        <p class="pur_price" title="{{ str_pad($payment->plan->days, 2, "0", STR_PAD_LEFT) }} day ({{ ($payment->currency == "EUR" ? '€' : ($payment->currency == "USD" ? '$' : 'RS/')).$payment->amount }})"><span class="mb-0">{{ str_pad($payment->plan->days, 2, "0", STR_PAD_LEFT) }} day ({{ ($payment->currency == "EUR" ? '€' : ($payment->currency == "USD" ? '$' : 'RS/')).$payment->amount }})  </span></p>
                                                                    </div>
                                                                    @if(active_until_active($payment->id) == true)
                                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-8 my-auto ms-md-auto mx-auto mx-sm-0 text-end">
                                                                            <button type="button" class="btn activate_btn ms-0">Active</button>
                                                                        </div>
                                                                    @endif
                                                            </div>
                                                        </a>
                                                    </div>
                                                @elseif($payment->type == 2)
                                                    <div class="col-12 px-0 mb-3">
                                                        <a href="{{ $payment->package->sub_cat_id != null ? route('sub_categories',['slug' => $payment->package->sub_category->main_category->super_category->slug_name ,'slug1' => $payment->package->sub_category->main_category->slug_name, 'slug2' => $payment->package->sub_category->slug_name]) : route('main_categories',['slug' => $payment->package->main_category->super_category->slug_name, 'slug1' => $payment->package->main_category->slug_name]) }}">
                                                            <div class="purchase_card row align-content-center justify-content-md-start justify-content-center mx-sm-0 mx-auto">
                                                                    <div class="pur_img_box col-xl-2 col-lg-2 col-md-2 col-12">
                                                                        @if($payment->package->cat_id != null)
                                                                            <img src="{{ $payment->package->main_category->image }}" alt="img" loading="lazy">
                                                                        @elseif($payment->package->sub_cat_id != null)
                                                                            <img src="{{ $payment->package->sub_category->image }}" alt="img" loading="lazy">
                                                                        @endif
                                                                    </div>
                                                                    <div class="{{ (active_until_active($payment->id) == true) ? 'pur_content col-xl-7 col-lg-7 col-md-9 col-12' : 'pur_content col-xl-10 col-lg-10 col-md-9 col-12'}}">
                                                                        @if($payment->package->cat_id != null)
                                                                            <h4 class="pur_title">{{ $payment->package->main_category->name }}</h4>
                                                                        @elseif($payment->package->sub_cat_id != null)
                                                                            <h4 class="pur_title">{{ $payment->package->sub_category->name }}</h4>
                                                                        @endif
                                                                        @if($payment->package->cat_id != null)
                                                                            <div class="pur_description" title="{{ strip_tags($payment->package->main_category->description) }}">
                                                                                {!! nl2br(e(\Str::limit(html_entity_decode(strip_tags($payment->package->main_category->description)), 200))) !!}
                                                                            </div>
                                                                        @elseif($payment->package->sub_cat_id != null)
                                                                            <div class="pur_description" title="{{ strip_tags($payment->package->sub_category->description) }}">
                                                                                {!! nl2br(e(\Str::limit(html_entity_decode(strip_tags($payment->package->sub_category->description)), 200))) !!}
                                                                            </div>
                                                                        @endif

                                                                        <p class="pur_price" title="{{ str_pad($payment->package->days, 2, "0", STR_PAD_LEFT) }} day ({{ ($payment->currency == "EUR" ? '€' : ($payment->currency == "USD" ? '$' : 'RS/')).$payment->amount }})"><span class=" mb-0">{{ str_pad($payment->package->days, 2, "0", STR_PAD_LEFT) }} day ({{ ($payment->currency == "EUR" ? '€' : ($payment->currency == "USD" ? '$' : 'RS/')).$payment->amount }})</span></p>
                                                                    </div>
                                                                    @if(active_until_active($payment->id) == true)
                                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-8 my-auto ms-md-auto mx-auto mx-sm-0 text-end">
                                                                            <button type="button" class="btn activate_btn ms-0">Active</button>
                                                                        </div>
                                                                    @endif
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if(auth()->guard('auth')->user()->role_id == 4)
                                            @foreach($customized as $key => $info)
                                                <div class="col-12 px-0 mb-3">
                                                    <a href="{{ route('sub_categories',['slug' => $info->main_category->super_category->slug_name ,'slug1' => $info->main_category->slug_name, 'slug2' => $info->slug_name]) }}">
                                                        <div class="purchase_card row align-content-center justify-content-md-start justify-content-center mx-sm-0 mx-auto">
                                                                <div class="pur_img_box col-xl-2 col-lg-2 col-md-2 col-12">
                                                                    <img src="{{ $info->image }}" alt="img" loading="lazy">
                                                                </div>
                                                                <div class="{{ (customise_active_plan() == true) ? 'pur_content col-xl-7 col-lg-7 col-md-9 col-12' : 'pur_content col-xl-10 col-lg-10 col-md-9 col-12'}}">
                                                                    <h4 class="pur_title">{{ $info->name }}</h4>
                                                                    <div class="pur_description" title="{{ strip_tags($info->description) }}">{!! nl2br(e(\Str::limit(html_entity_decode(strip_tags($info->description)), 200))) !!}</div>
                                                                    <p class="pur_price" title="{{ date('d-m-Y', strtotime(auth()->guard('auth')->user()->start_date)).' / '.date('d-m-Y', strtotime(auth()->guard('auth')->user()->end_date)) }}"><span class="mb-0">{{ date('d-m-Y', strtotime(auth()->guard('auth')->user()->start_date)).' / '.date('d-m-Y', strtotime(auth()->guard('auth')->user()->end_date)) }}</span></p>
                                                                </div>
                                                                @if(customise_active_plan() == true)
                                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-8 my-auto ms-md-auto mx-auto mx-sm-0 text-end">
                                                                        <button type="button" class="btn activate_btn ms-0">Active</button>
                                                                    </div>
                                                                @endif
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                            <div class="notNeper">
                                                {{ $customized->links('vendor.pagination.default') }}
                                            </div>
                                        @endif
                                        @if(auth()->guard('auth')->user()->parent_id != "")
                                            @foreach($organization as $key => $info)
                                                <div class="col-12 px-0 mb-3">
                                                    <a href="{{ route('category',$info->slug_name) }}">
                                                        <div class="purchase_card row align-content-center justify-content-md-start justify-content-center mx-sm-0 mx-auto">
                                                            <div class="pur_img_box col-xl-2 col-lg-2 col-md-2 col-12">
                                                                <img src="{{ getSetting('logo') != null ? url('storage/setting', getSetting('logo')) : asset('assets/front/image/logo.png') }}" alt="img" loading="lazy">
                                                            </div>
                                                            <div class="{{ (org_active_plan() == true) ? 'pur_content col-xl-7 col-lg-7 col-md-9 col-12' : 'pur_content col-xl-10 col-lg-10 col-md-9 col-12'}}">
                                                                <h4 class="pur_title">{{ $info->name }}</h4>
                                                                <div class="pur_description" title="{{ strip_tags($info->description) }}">{!! nl2br(e(\Str::limit(html_entity_decode(strip_tags($info->description)), 200))) !!}</div>
                                                                <p class="pur_price" title="{{ date('d-m-Y', strtotime(auth()->guard('auth')->user()->parentUser?->start_date)).' / '.date('d-m-Y', strtotime(auth()->guard('auth')->user()->parentUser?->end_date)) }}"><span class="mb-0">{{ date('d-m-Y', strtotime(auth()->guard('auth')->user()->parentUser?->start_date)).' / '.date('d-m-Y', strtotime(auth()->guard('auth')->user()->parentUser?->end_date)) }}</span></p>
                                                            </div>
                                                            @if(org_active_plan() == true)
                                                                <div class="col-xl-3 col-lg-3 col-md-3 col-8 my-auto ms-md-auto mx-auto mx-sm-0 text-end">
                                                                    <button type="button" class="btn activate_btn ms-0">Active</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if($pur_payment == '[]' && ($customized == '[]' || $customized == "") && ($organization == '[]' || $organization == ""))
                                            <h4 class="no_frequencies_found">No Subscriptions Found</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- ---------------supporter tab  ------------ -->
                            <div class="tab-pane fade {{ Request::segment(2) == "support" ? 'show active' : '' }}" id="nav-supporter" role="tabpanel" aria-labelledby="nav-supporter-tab" tabindex="0">
                                <div class="w-100">
                                    <div class="row w-100 px-2 mx-auto pt-2">
                                        <div class="support_ticket_list">
                                            @include('front.ticket_list')
                                        </div>
                                        <div class="main_message_box hidden">
                                            @include('front.support_msg_list')
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
@section('script')
<script>
    $('#dob').flatpickr({
        dateFormat: 'd-m-Y',
        maxDate: new Date().setDate(new Date().getDate() - 1),
        disableMobile:true
    });
    flatpickr("#time_of_birth", {
        disableMobile: true,
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K", // 12-hour format with AM/PM
        time_24hr: false // Ensures AM/PM is displayed
    });
    $(document).ready(function(){
        $.validator.addMethod("noSpace", function(value, element) {
            return value == '' || value.trim().length != 0;
        }, "Space not allowed.");

        $.validator.addMethod("noHTML", function(value, element) {
            return !/<[^>]*>/g.test(value); // No HTML tags allowed
        }, "HTML tags are not allowed.");

        $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param);
            }, 'File size must be less than 2 MB');

        $.validator.addMethod("onlyCharacters", function(value, element) {
                return /^[a-zA-Z\s]*$/.test(value); // Only characters and spaces allowed
        }, "Only alphabetic characters are allowed.");

        $("#mobile_number_1, #mobile_number_2").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $(document).on('click','.go_back_btn',function (){
            var token = '<?php echo csrf_token(); ?>';
            $.ajax({
                type:"POST",
                url: "{{ route('close_chat') }}",
                headers:{
                    'X-CSRF-TOKEN': token
                },
                dataType:'json',
                success:function(data){
                    if(data.status == 0){
                        $('.support_ticket_list').show().empty().append(data.html);
                        $('.main_message_box').addClass('hidden');
                    }else{
                        return false;
                    }
                }
            });
        });

        $(document).on('click','#open_ticket',function(){
            var id = $(this).attr('data-id');
            var token = '<?php echo csrf_token(); ?>';

            $.ajax({
                type:"POST",
                url: "{{ route('chat_message_list') }}",
                data: {
                    id: id
                },
                headers:{
                    'X-CSRF-TOKEN': token
                },
                success:function(data){
                    if(data.status == 0){
                        $('.support_ticket_list').hide();
                        $('.main_message_box').empty().removeClass('hidden').append(data.html);
                        $('.message_list_box').scrollTop($('.message_list_box')[0].scrollHeight);
                        $('.close_query').removeClass('hidden');

                        if ($('.Divider_message').length) {
                            setTimeout(function () {
                                $('.Divider_message').fadeOut();
                            }, 2000);
                        }
                        $('#send_sms_form').validate({
                            rules:{
                                message: {
                                    required: true,
                                    noHTML:true,
                                    noSpace: true
                                },
                            },
                            submitHandler: function (form,event){
                                event.preventDefault();
                                if($('#send_sms_form').valid()){
                                    var formData = new FormData($('#send_sms_form')[0]);
                                    var token = '<?php echo csrf_token(); ?>';
                                    $('#sendBtn').prop('disabled', true);
                                    $.ajax({
                                        type:"POST",
                                        url: $("#send_sms_form").attr("action"),
                                        enctype: 'multipart/form-data',
                                        headers: {
                                            'X-CSRF-TOKEN': token
                                        },
                                        data: formData,
                                        processData:false,
                                        dataType:'json',
                                        contentType:false,
                                        catch:false,
                                        timeout:600000,
                                        success: function(data){
                                            if(data.status == 0){
                                                var html =
                                                '<div class="chat_right">' +
                                                    '<div class="receiver_message">' +
                                                        '<p class="mess_txt">' + data.msg_data.message + '</p>' +
                                                        '<span class="mess_title"> <b>Sent :</b> ' + data.sent_time + '</span>' +
                                                    '</div>' +
                                                '</div>';
                                                $('.message_list_box').append(html).attr('data-support_id',data.msg_data.support_id);

                                                $('#support_id').val(data.msg_data.support_id); // Set the value
                                                toastr_success("Message sent successfully.");
                                                $('.message_list_box').scrollTop($('.message_list_box')[0].scrollHeight);
                                                $('#send_sms_form')[0].reset();
                                                $('.close_query').attr('data-support_id',data.msg_data.support_id).removeClass('hidden');
                                                $('.new_ticket_btn').attr('data-support_id',data.msg_data.support_id);
                                            } else if(data.status == 1){
                                                toastr_error(data.msg);
                                                $('.go_back_btn').trigger('click');
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            toastr_error("An error occurred. Please try again.");
                                            $('#sendBtn').prop('disabled',false);
                                        },
                                        complete: function() {
                                            $('#sendBtn').prop('disabled', false);
                                        }
                                    });
                                } else{
                                    return false;
                                }
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click','#raise_new_ticket',function(){
            $('.support_ticket_list').hide();
            token = '<?php echo csrf_token(); ?>';
            $.ajax({
                type:"Post",
                url: "{{ route('update_ticket') }}",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                dataType: 'json',
                success: function(data){
                    if(data.status == 0){
                        $('.main_message_box').removeClass('hidden').empty().append(data.html);
                        $('.message_list_box').show().empty();

                        $('#send_sms_form').validate({
                            rules:{
                                message: {
                                    required: true,
                                    noHTML:true,
                                    noSpace:true
                                },
                            },
                            submitHandler: function (form){
                                if($('#send_sms_form').valid()){
                                    var formData = new FormData($('#send_sms_form')[0]);
                                    var token = '<?php echo csrf_token(); ?>';
                                    $('#sendBtn').prop('disabled', true);
                                    $.ajax({
                                        type:"POST",
                                        url: $("#send_sms_form").attr("action"),
                                        enctype: 'multipart/form-data',
                                        headers: {
                                            'X-CSRF-TOKEN': token
                                        },
                                        data: formData,
                                        processData:false,
                                        dataType:'json',
                                        contentType:false,
                                        catch:false,
                                        timeout:600000,
                                        success: function(data){
                                            if(data.status == 0){
                                                var html =
                                                '<div class="chat_right">' +
                                                    '<div class="receiver_message">' +
                                                        '<p class="mess_txt">' + data.msg_data.message + '</p>' +
                                                        '<span class="mess_title"> <b>Sent :</b> ' + data.sent_time + '</span>' +
                                                    '</div>' +
                                                '</div>';
                                                $('.message_list_box').append(html).attr('data-support_id',data.msg_data.support_id);

                                                if (!$('#support_id').val()) {
                                                    $('#support_id').val(data.msg_data.support_id); // Set the value
                                                }
                                                toastr_success("Message sent successfully.");
                                                $('.message_list_box').scrollTop($('.message_list_box')[0].scrollHeight);
                                                $('#send_sms_form')[0].reset();
                                                $('.close_query').attr('data-support_id',data.msg_data.support_id).removeClass('hidden');
                                                $('.new_ticket_btn').attr('data-support_id',data.msg_data.support_id);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            toastr_error("An error occurred. Please try again.");
                                            $('#sendBtn').prop('disabled',false);
                                        },
                                        complete: function() {
                                            $('#sendBtn').prop('disabled', false);
                                        }
                                    });
                                } else{
                                    return false;
                                }
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click','.close_query',function(){
            var token = '<?php echo csrf_token(); ?>';
            $.ajax({
                type:"Post",
                url: "{{ route('close_chat',['slug' => 'close-query']) }}",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                dataType: 'json',
                success: function(data){
                    if(data.status == 0){
                        $('.close_query').addClass('hidden');
                        $('.message_list_box').hide();
                        $('.main_message_box').addClass('hidden');

                        $('.support_ticket_list').show().empty();
                        $('.support_ticket_list').append(data.html);
                        toastr_success("Query closed successfully.");
                    }else{
                        toastr_error("An error occurred. Please try again.");
                    }
                }
            });
        });
        (function($) {
            var phoneInput1 = document.querySelector('input[name="mobile_number_1"]');
            if (phoneInput1 !== null) {
                intlTelInput(phoneInput1, {
                    geoIpLookup: function(success, failure) {
                        $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "IN";
                            success(countryCode);
                        });
                    },
                    preferredCountries: ['IN'],
                    hiddenInput: "mobile_number_1",
                    separateDialCode: true,
                    utilsScript: "{{ url('adminassets/js-county/utils.js') }}",
                });

                phoneInput1.addEventListener('input', function() {
                    phoneInput1.value = phoneInput1.value.replace(/\D/g, '');
                });
            }

            var phoneInput2 = document.querySelector('input[name="mobile_number_2"]');
            if (phoneInput2 !== null) {
                intlTelInput(phoneInput2, {
                    geoIpLookup: function(success, failure) {
                        $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "IN";
                            success(countryCode);
                        });
                    },
                    preferredCountries: ['IN'],
                    hiddenInput: "mobile_number_2",
                    separateDialCode: true,
                    utilsScript: "{{ url('adminassets/js-county/utils.js') }}",
                });

                phoneInput2.addEventListener('input', function() {
                    phoneInput2.value = phoneInput2.value.replace(/\D/g, '');
                });
            }
        })(jQuery);

        $('#edit_user_form').validate({
            rules: {
                    'name': {
                        required: true,
                        maxlength: 50,
                        noHTML: true,
                        onlyCharacters: true,
                    },
                    'dob': {
                        required: true,
                        // date: true,
                    },
                    'mobile_number_1': {
                        required: true,
                        digits: true,
                    },
                    'mobile_number_2': {
                        digits: true,
                    },
                    'discomfort': {
                        noHTML: true,
                    },
                    'image': {
                        filesize: 2097152
                    },
                    'email': {
                        required: true,
                        email: true,
                        remote: {
                            type: 'get',
                            url: "{{ route('front.check.email.edit') }}",
                            data: {
                                'email': function() {
                                    return $('#email').val();
                                },
                                'id': function() {
                                    return "{{ $user->id }}";
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
                        },
                    }
                },
                messages: {
                    'email': {
                        email: "Please enter a valid email address.",
                    },
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
        $('#togglePassword1').click(function() {
            const passwordField = $('#password');
            const passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        $('#togglePassword2').click(function() {
            const passwordField = $('#new_password');
            const passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        $('#togglePassword3').click(function() {
            const passwordField = $('#confirm_password');
            const passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
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

        $('#name, #dob, #time_of_birth, #mobile_number_1, #mobile_number_2, #email, #password, #conpassword').on('keyup blur', function() {
            $(this).valid();
        });

        $.validator.addMethod("differentPassword", function(value, element) {
            return value !== $("#password").val();
        }, "New password must be different from the current password.");

        $("#change_password_form").validate({
            rules: {
                password: {
                    required: true,
                    noSpace: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    noSpace: true,
                    minlength: 6,
                    differentPassword: true
                },
                confirm_password: {
                    noSpace: true,
                    required: true,
                    minlength: 6,
                    equalTo: "#new_password"
                }
            },
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');  // Make sure you have CSS for this class
                element.closest('.form-group').append(error);  // Append error below the input field
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $('#SubmitBtn').prop('disabled', true);
                form.submit();
            }
        });

        $("#mobile_number_1").on("countrychange", function (e) {
            mobile1_length();
        });
        $("#mobile_number_2").on("countrychange", function (e) {
            mobile2_length();
        });
        mobile1_length();
        mobile2_length();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');

        tabLinks.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // Adds smooth scrolling
                });
            });
        });
    });
    function mobile1_length(){
        var phoneinput = document.querySelector('input[name="mobile_number_1"]');
        var iti = window.intlTelInputGlobals.getInstance(phoneinput);
        var countrycode = iti.getSelectedCountryData().dialCode;
        var countryname = iti.getSelectedCountryData().name;
        $('#country').val(countryname);
        if(countrycode != "" && countrycode != "91"){
            $("#mobile_number_1").attr('maxlength','15');
            $("#mobile_number_1").attr('minlength','6');
        } else{
            $("#mobile_number_1").attr('maxlength','10');
            $("#mobile_number_1").attr('minlength','10');
        }
    }
    function mobile2_length(){
        var phoneinput = document.querySelector('input[name="mobile_number_2"]');
        var iti = window.intlTelInputGlobals.getInstance(phoneinput);
        var countrycode = iti.getSelectedCountryData().dialCode;
        var countryname = iti.getSelectedCountryData().name;
        $('#country').val(countryname);
        if(countrycode != "" && countrycode != "91"){
            $("#mobile_number_2").attr('maxlength','15');
            $("#mobile_number_2").attr('minlength','6');
        } else{
            $("#mobile_number_2").attr('maxlength','10');
            $("#mobile_number_2").attr('minlength','10');
        }
    }
</script>
@endsection
