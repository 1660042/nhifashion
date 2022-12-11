@extends('frontend.layouts.default')
{{-- @section('title', 'Thể loại') --}}
@section('content')
    <div id="index-page">
        <!-- Slider -->
        <div class="main_slider" style="background-image:url({{ asset('coloshop/images/slider_1.jpg') }})">
            <div class="container fill_height">
                <div class="row align-items-center fill_height">
                    <div class="col">
                        <div class="main_slider_content">
                            <h6>Spring / Summer Collection 2017</h6>
                            <h1>Get up to 30% Off New Arrivals</h1>
                            <div class="red_button shop_now_button"><a href="#">shop now</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner -->

        <div class="banner">
            <div class="container">
                <div class="row">
                    @foreach ($dsTheLoaiTieuBieu as $theLoai)
                        <div class="col-md-4">
                            <div class="banner_item align-items-center"
                                style="background-image:url({{ asset('storage/images/the_loai/' . optional($theLoai)->ten_anh) }})">
                                <div class="banner_category">
                                    <a href="{{ route('frontend.the_loai.index', $theLoai->slug) }}">{{ $theLoai->ten }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- New Arrivals -->

        <div id="new-product" class="new_arrivals">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <div class="section_title new_arrivals_title">
                            <h2>Hàng mới về</h2>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col text-center">
                        <div class="new_arrivals_sorting">
                            <ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                                <li
                                    class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center active is-checked">
                                    Tất cả</li>
                                @foreach ($dsTheLoaiTieuBieu as $theLoai)
                                    <li data-id="{{ $theLoai->id }}"
                                        class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center">
                                        {{ $theLoai->ten }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="data-new-product" class="row">
                    @include('frontend.index.data_new_product')
                </div>
            </div>
        </div>

        <div class="best_sellers" id="best-product">
            @include('frontend.index.data_best_product')
        </div>
    </div>
@endsection

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/main_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/responsive.css') }}">
@endsection
@section('js_custom')
    <script src="{{ asset('coloshop/js/custom.js') }}"></script>
    {{-- <script src="{{ asset('frontend/js/index.js') }}"></script> --}}
@endsection
