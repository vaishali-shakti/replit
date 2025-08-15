<div class="col-12 px-0">
    <div class="d-flex justify-content-between flex-wrap">
        <h4 class="content_title d-inline-block w-auto mx-auto mx-sm-0">support</h4>
        <div class="d-flex gap-3 flex-wrap justify-content-center mb-3 mb-md-0 support_btn_div">
            <div class="go_back_btn">
                <svg width="50" height="50" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <defs><linearGradient id="fillGradient" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#4c46e6"/><stop offset="25%" stop-color="#6d68fe"/><stop offset="50%" stop-color="#b446ff"/><stop offset="100%" stop-color="rgb(151, 0, 255)"/></linearGradient></defs>
                    <path d="M18.2 25.4L14.0728 21.2728C13.3698 20.5698 13.3698 19.4302 14.0728 18.7272L18.2 14.6M14.6 20H27.2M20 38C10.0589 38 2 29.9411 2 20C2 10.0589 10.0589 2 20 2C29.9411 2 38 10.0589 38 20C38 29.9411 29.9411 38 20 38Z" fill="url(#fillGradient)" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
            @if(!isset($support_data) ||(isset($support_data) && $support_data->msg_status != 1))
                <a class="hidden close_query">
                    <button type="button" class="close_query_btn add-btn"> Close Query</button>
                </a>
            @endif
        </div>
    </div>
</div>
<div class="col-xl-12 col-lg-12 col-md-12 px-0">
    <div class="main_list_box mb-3 main_list_box2">
        <div class="message_list_box">
            @if(isset($message) && $message != '[]' && $message != null )
                @php
                    $oneUnreadMsgShow = false;
                @endphp
                @foreach($message as $msg)
                    @if($msg->action_by != Auth::guard('auth')->user()->id && !$msg->is_read && !$oneUnreadMsgShow)
                        <div class="Divider_message">
                            <div class="Divider-text">Unread Messages</div>
                        </div>
                        @php
                            $oneUnreadMsgShow = true;
                        @endphp
                    @endif

                    <div class="{{ $msg->action_by == Auth::guard('auth')->user()->id ? 'chat_right' : 'chat_left' }}">
                        <div class="receiver_message">
                            <p class="mess_txt">{{ $msg->message }}</p>
                            <span class="mess_title"> <b>{{ $msg->action_by == Auth::guard('auth')->user()->id ? 'Sent :' : 'Received :' }}</b>{{ convert_timezone($msg->created_at) }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    @if(!isset($support_data) || (isset($support_data) && $support_data->msg_status != 1))
        <div class="position-relative bottom-0 mb-2">
            <form id="send_sms_form" action="{{ route('send_message') }}" method="POST" class="send_message_form col-12" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->guard('auth')->user() ? auth()->guard('auth')->user()->id : '' }}">
                <input type="hidden" name="support_id" id="support_id" value="{{ (isset($support_data) ? $support_data->id : '') }}">
                <input type="text" name="message" id="message" placeholder="Start typing here..." class="" autocomplete="off" value="{{ old('message') }}" required>
                @error('message')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button type="submit" class="send_icon" id="sendBtn">
                    <svg width="28px" height="28px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M234.69409,219.61572a15.86649,15.86649,0,0,1-12.15625,5.69141,16.171,16.171,0,0,1-5.44531-.95117l-81.21094-29.00391V120a8,8,0,1,0-16,0v75.352L38.67065,224.356a16.00042,16.00042,0,0,1-19.3418-22.88575l94.5918-168.91455a16.00119,16.00119,0,0,1,27.92188,0l94.59179,168.915A15.87045,15.87045,0,0,1,234.69409,219.61572Z"></path> </g></svg>
                </button>
            </form>
        </div>
    @endif
</div>
