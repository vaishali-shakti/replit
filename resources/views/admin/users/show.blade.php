@extends('FrontDashboard.master')
@section('content')
<div class="container px-0">
    <div class="Business-profile">
        <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-4 mx-1">
            <h2 class="d-block text-21 fw-bold offer-title text-capitalize">User Management</h2>
             <a href="{{ route('users.index') }}" class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
        </div>
        <div >
            <div class="main_addproduct_form">
                <div class="row">
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Name :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4 text-break">
                        {{ $user->name ?? '-' }}
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">DOB :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->dob ?? '-'}}
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Time Of Birth :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->time_of_birth ?? '-'}}
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Place Of Birth :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->place_of_birth ?? '-' }}
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Mobile No. 1 :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->mobile_number_1 ?? '-' }}
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Mobile No. 2 :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->mobile_number_2 ?? '-' }}
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Email :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        <p class="text-break">{{ $user->email ?? '-' }}</p>
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Role :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->role->name ?? '-' }}
                    </div>
                    {{-- <div class="col-6 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Password :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->password ?? '-' }}
                    </div> --}}
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Image :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        <img src="{{ $user->image }}" width="auto" height="100" class="rounded-3"/>
                    </div>
                    <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                        <label class="mb-2 fw-bold">Discomfort :</label>
                    </div>
                    <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                        {{ $user->discomfort ?? '-' }}
                    </div>
                    <div class="{{ ($pur_payment != '[]' && $pur_payment != '') ? 'col-12 mt-5' : 'col-5 col-md-6 col-sm-6 col-lg-2 mt-5' }}">
                        <label class="mb-2 fw-bold">User Subscriptions Details :</label>
                    </div>
                    <div class="{{ ($pur_payment != '[]' && $pur_payment != '') ? 'col-7 col-md-7 col-sm-7 mt-3 col-lg-11' : 'col-7 col-md-7 col-sm-7 mt-5 col-lg-10' }}">
                        @if(($pur_payment != '[]' && $pur_payment != ''))
                            <table class="table table-bordered purchase_plan">
                                <thead>
                                    <tr>
                                        <th scope="col">Plans name</th>
                                        <th scop="col">Plans Type</th>                                
                                        <th scope="col">Price</th>
                                        <th scope="col">Days</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>    
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach($pur_payment as $payment)
                                        <tr>
                                            @if($payment->type == 1)
                                                <td>All-Inclusive Deal</td>
                                            @elseif($payment->type == 2)
                                                @if($payment->package->cat_id != null)
                                                    <td>{{ $payment->package->main_category->name }}</td>
                                                @elseif($payment->package->sub_cat_id != null)
                                                    <td>{{ $payment->package->sub_category->name }}</td>
                                                @endif
                                            @endif
                                            @if($payment->type == 1)
                                                <td>Global Plan</td>
                                            @elseif($payment->type == 2)
                                                <td>Package Plan</td>
                                            @endif
                                                <td>{{ ($payment->currency == 'EUR' ? '€' : ($payment->currency == 'USD' ? '$' : '₹')).$payment->amount }}</td>
                                            @if($payment->type == 1) 
                                                <td>{{ str_pad($payment->plan->days, 2, "0", STR_PAD_LEFT) }}</td>
                                            @elseif($payment->type == 2)
                                                <td>{{ str_pad($payment->package->days, 2, "0", STR_PAD_LEFT) }}</td>
                                            @endif
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->active_until)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                    @if($user->role_id == 4)
                                        @foreach($customized as $key => $info)
                                            <tr>
                                                <td>{{ $info->name }}</td>
                                                <td>Customized</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>{{ \Carbon\Carbon::parse($user->start_date)->format('d-m-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->end_date)->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table> 
                        @else
                            @if($customized == '[]' || $customized == "") 
                                <p>-</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>       
        </div>
    </div>
</div>

@endsection
