@extends('FrontDashboard.master')
@section('content')
<div class="container px-0">
    <div class="Business-profile">
        <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-4 mx-1">
            <h2 class="d-block text-21 fw-bold offer-title text-capitalize">Sub Category Management</h2>
             @can('subcategory-create')
             <a href="{{ route('subcategory.index') }}" class="save-btn text-22 my-3 mx-1 anim">Cancel</a>
            @endcan
        </div>
        <div class="main_addproduct_form">
                        <div class="row">
                            <div class="col-5   col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Main Category Name :</label>
                            </div>
                            <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4 text-break">
                                {{ $subcategory->main_category->name ?? 'N/A' }}
                            </div>
                            <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Sub Category Name :</label>
                            </div>
                            <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                                {{ $subcategory->name }}
                            </div>
                            <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Type :</label>
                            </div>
                            <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                                {{ $subcategory->payment_type }}
                            </div>
                            <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Description : </label>
                            </div>
                            <div class="col-7 c ol-md-6 col-sm-6 mt-3 col-lg-4">
                                {!! $subcategory->description !!}
                            </div>
                            <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Audio :</label>
                            </div>
                            <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                                @if($subcategory->audio)
                                    <audio controls controlsList="nodownload">
                                        <source src="{{ Storage::disk('s3')->temporaryUrl('audio/'.$subcategory->audio,\Carbon\Carbon::now()->addSeconds(30)) }}" type="audio/mp3" class="source_audio">
                                    </audio>
                                @else
                                    <span>No Audio Available</span>
                                 @endif
                            </div>
                            <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Audio Duration :</label>
                            </div>
                            <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                                {{ $subcategory->audio_duration ?? '-' }}
                            </div>
                            <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Image :</label>
                            </div>
                            <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                                <img src="{{ $subcategory->image }}" width="auto" height="100" class="rounded-3"/>
                            </div>
                            <div class="col-5 col-md-6 col-sm-6 col-lg-2 mt-3">
                                <label class="mb-2 fw-bold">Video :</label>
                            </div>
                            <div class="col-7 col-md-6 col-sm-6 mt-3 col-lg-4">
                                @if($subcategory->video)
                                    <video width="320" height="240" controls class="view_video_box rounded-3" oncontextmenu="return false" controlsList="nodownload">
                                        <source src="{{ Storage::disk('s3')->temporaryUrl('video/'.$subcategory->video,\Carbon\Carbon::now()->addSeconds(30)) }}" type="video/mp4" >
                                    </video>
                                @else
                                    <span>No Video Available</span>
                                @endif
                            </div>
                        </div>
        </div>
    </div>
</div>

@endsection
