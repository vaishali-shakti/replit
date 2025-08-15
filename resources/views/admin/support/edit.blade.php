
@extends('FrontDashboard.master')
@section('content')
<div class="pageLoader" id="pageLoader"></div>

    <div class="container px-0">
        <div class="Business-profile">
            <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-2 mx-1">
                <h2 class="d-block text-21 fw-bold offer-title text-capitalize">Support Management ({{ $support->ticket_no }})</h2>

                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    @if($support->msg_status != 1)
                        <a class="closed_query" data-href="{{ route('admin_close_query') }}" data-id="{{ $support->id }}">
                            <button type="button" class="close_query_btn add-btn"> Close Query</button>
                        </a>
                    @endif
                    <a href="{{ route('support.index') }}" class="add-btn new_ticket_btn">Cancel</a>
                </div>
            </div>
            <div class="dashboard-table pt-3">
                <div class="table_plan-holder">
                    <div class="col-xl-12 col-lg-12 col-md-12 main_message_box px-0">
                        <div class="main_list_box mb-3 main_list_box2">
                            <div class="message_list_box">
                                @php
                                    $oneUnreadMsgShow = false;
                                @endphp
                                @foreach($getMessage as $msg)
                                    @if($msg->action_by != Auth::guard('web')->user()->id && !$msg->is_read && !$oneUnreadMsgShow)
                                        <div class="Divider_message">
                                            <div class="Divider-text">unread messages</div>
                                        </div>
                                        @php
                                            $oneUnreadMsgShow = true;
                                        @endphp
                                    @endif
                                    <div class="{{ $msg->action_by == Auth::guard('web')->user()->id ? 'chat_right' : 'chat_left' }}">
                                        <div class="receiver_message">
                                            <p class="mess_txt">{{ $msg->message }}</p>
                                            <span class="mess_title"> <b>{{ $msg->action_by == Auth::guard('web')->user()->id ? 'Sent :' : 'Received :' }}</b> {{ convert_timezone($msg->created_at) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if($support->msg_status != 1)
                            <div class="position-relative bottom-0 mb-2">
                                <form id="admin_send_message" action="{{ route('admin_send_messages') }}" method="POST" class="send_message_form d-flex col-12">
                                    @csrf
                                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->guard('web')->user()->id }}">
                                    <input type="hidden" name="support_id" id="support_id" value="{{ $support->id }}">
                                    <input type="text" name="message" id="message" placeholder="Start typing here..." required autocomplete="off">
                                    <button type="submit" class="send_icon" id="sendBtn">
                                        <svg width="28px" height="28px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M234.69409,219.61572a15.86649,15.86649,0,0,1-12.15625,5.69141,16.171,16.171,0,0,1-5.44531-.95117l-81.21094-29.00391V120a8,8,0,1,0-16,0v75.352L38.67065,224.356a16.00042,16.00042,0,0,1-19.3418-22.88575l94.5918-168.91455a16.00119,16.00119,0,0,1,27.92188,0l94.59179,168.915A15.87045,15.87045,0,0,1,234.69409,219.61572Z"></path> </g></svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    </div>
@endsection
@section('js')
  <script>
    $(document).ready(function (){
        $.validator.addMethod("noSpace", function(value, element) {
            return value == '' || value.trim().length != 0;
        }, "Space not allowed.");

        $.validator.addMethod("noHTML", function(value, element) {
            return !/<[^>]*>/g.test(value); // No HTML tags allowed
        }, "HTML tags are not allowed.");

        if ($('.Divider_message').length) {
            setTimeout(function () {
                $('.Divider_message').fadeOut();
            }, 2000);
        }
        $('.message_list_box').scrollTop($('.message_list_box')[0].scrollHeight);

        $('#admin_send_message').validate({
            rules:{
                message: {
                    required: true,
                    noSpace:true,
                    noHTML:true,
                }
            },
            submitHandler: function (form){
                var formData = new FormData($('#admin_send_message')[0]);
                var token = '<?php echo csrf_token(); ?>';
                $('#sendBtn').prop('disabled', true);
                $.ajax({
                    type:"POST",
                    url: $("#admin_send_message").attr("action"),
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
                            $('.message_list_box').append(html);
                            toastr_success("Message sent successfully.");
                            $('.message_list_box').scrollTop($('.message_list_box')[0].scrollHeight);
                            $('#admin_send_message')[0].reset();
                        } else if(data.status == 1){
                            toastr_error(data.msg);
                            location.reload();
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
            }
        });

        $(document).on('click','.closed_query', function(){
            $("#pageLoader").show(1);
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-href');

            var token = '<?php echo csrf_token(); ?>';
            $.ajax({
                type:"POST",
                // beforeSend:function(){
                //     $("#pageLoader").show(1)
                // },
                url : url,
                headers:{
                    'X-CSRF-TOKEN': token
                },
                data:{
                    id:id
                },
                dataType:'json',
                success:function(data){
                    if(data.status == 'success'){
                        setTimeout(function() {
                            window.location.href = "{{ route('support.index') }}";
                        }, 300);
                    }else{
                        $("#pageLoader").fadeOut("slow");
                        toastr_error("An error occurred. Please try again.");
                    }
                },
                complete: function(){
                    $("#pageLoader").fadeOut("slow");
                }
            });
        });
    });
  </script>
@endsection
