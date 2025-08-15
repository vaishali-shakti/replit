@extends('front.layouts.master')
@section('content')

    <!-- --------------- banner slider start ------------ -->

    <section>
        <div class="main_banner_section">
                <div class="banner_box">
                    <div  class="banner_img_box">
                        <h3 class="main_heading_title">Frequently Used Frequency</h3>
                        <nav aria-label="breadcrumb" class="breadcrumb_nav">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Frequently Used Frequency</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- --------------- banner slider end ------------ -->


    <!-- ---------- General Discomfort FREE for all section start ---------- -->

    <section class="pad-top pad-bottom" style="background-color: #F6F6F6;">
        <div class="container">
            <div class="row">
                @forelse($pro_music as $music)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                        <div class="card_box">
                            <div class="card_box_img">
                                <img src="{{ $music->image }}" alt="" width="100%" height="100%" loading="lazy">
                            </div>
                            <div class="card_content">
                                <h4 title="{{ $music->name }}">{{ $music->name }}</h4>
                                <p title="{{ strip_tags(html_entity_decode($music->description)) }}">{{ strip_tags(html_entity_decode($music->description)) }}</p>
                                <a href="{{ route('main_categories', [$music->super_category->slug_name, $music->slug_name]) }}">
                                    <button type="button" class="btn view_btn">View More</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center h3 fw-bolder main_category_no_found">
                        <h3>No Frequently Used Frequency Found</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ---------- General Discomfort FREE for all section end ---------- -->
@endsection
