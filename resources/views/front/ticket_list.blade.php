<div class="col-12 px-0">
    <div class="d-flex justify-content-between flex-wrap">
        <h4 class="content_title d-inline-block w-auto mx-auto mx-sm-0">support</h4>
        <div class="d-flex gap-3 flex-wrap justify-content-center mb-3 mb-md-0 support_btn_div">
            <a>
                <button type="button" id="raise_new_ticket" class="add-btn new_ticket_btn">Raise New Ticket</button>
            </a>
        </div>
    </div>
</div>

@if(isset($support) && $support != '[]' && $support != null)
    @foreach($support as $key => $value)
        <div class="col-12 px-0 mb-3 mt-2">
            <div class="purchase_card row align-content-center justify-content-sm-start justify-content-center mx-auto">
                <div class="support_content col-xl-2 col-lg-2 col-md-8 d-flex align-items-center flex-xl-nowrap gap-2">
                    <h4 class="ticket_number">{{ $value->ticket_no }}</h4>
                    <span class="{{ $value->msg_status ==  1 ? 'close_status' : 'active_status' }} mb-2">{{ $value->msg_status ==  1 ? 'Close Query' : 'Active' }}</span>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-8 my-auto ms-sm-auto mx-auto mx-sm-0 text-end">
                    <button type="button" id="open_ticket" class="btn ms-0 activate_btn" data-id="{{ $value->id }}">View Ticket</button>
                </div>
            </div>
        </div>
    @endforeach
@endif