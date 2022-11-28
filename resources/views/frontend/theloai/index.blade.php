@extends('frontend.layouts.default')
{{-- @section('title', 'Thể loại') --}}
@section('content')
    <div id="theloai-page">
        <!-- Slider -->
        <div class="container product_section_container">
            <div class="row">
                <div class="col product_section clearfix">

                    <!-- Breadcrumbs -->

                    <div class="breadcrumbs d-flex flex-row align-items-center">
                        <ul>
                            <li><a href="{{ route('frontend.index.index') }}">Trang chủ</a></li>
                            <li class="active"><a id="title-category"
                                    href="{{ route('frontend.the_loai.index', $theLoai->slug) }}"><i class="fa fa-angle-right"
                                        aria-hidden="true"></i>{{ $theLoai->ten }}</a></li>
                        </ul>
                    </div>

                    <!-- Sidebar -->

                    <div class="sidebar">
                        <div class="sidebar_section">
                            <div class="sidebar_title">
                                <h5>Thể loại</h5>
                            </div>
                            <ul class="sidebar_categories">
                                @foreach ($dsTheLoaiCha as $theLoaiCha)
                                    <li {!! $theLoaiCha->slug == $theLoai->slug ? 'class="active"' : '' !!}>
                                        <a class="btn-category" data-slug="{{ $theLoaiCha->slug }}"
                                            href="{{ route('frontend.the_loai.index', $theLoaiCha->slug) }}">{!! $theLoaiCha->slug == $theLoai->slug ? '</span>' : '' !!}
                                            {{ $theLoaiCha->ten }}
                                        </a>
                                    </li>
                                    @foreach ($theLoaiCha->theLoaiCon as $tlCon)
                                        <li {!! $tlCon->slug == $theLoai->slug ? 'class="active"' : '' !!}>
                                            <a class="btn-category" data-slug="{{ $tlCon->slug }}"
                                                href="{{ route('frontend.the_loai.index', $tlCon->slug) }}">{!! str_repeat('&nbsp;', 3) !!}{!! $tlCon->slug == $theLoai->slug ? '</span>' : '' !!}
                                                {{ $tlCon->ten }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endforeach
                                {{-- <li class="active"><a href="#"><span><i class="fa fa-angle-double-right"
                                                aria-hidden="true"></i></span>Women</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">New Arrivals</a></li>
                                <li><a href="#">Collection</a></li>
                                <li><a href="#">Shop</a></li> --}}
                            </ul>
                        </div>

                        {{-- <!-- Price Range Filtering -->
                        <div class="sidebar_section">
                            <div class="sidebar_title">
                                <h5>Khoảng giá</h5>
                            </div>
                            <p>
                                <input type="text" id="amount" readonly
                                    style="border:0; color:#f6931f; font-weight:bold;">
                            </p>
                            <div id="slider-range"></div>
                            <div class="filter_button"><span>Áp dụng</span></div>
                        </div> --}}

                        <!-- Sizes -->
                        <div class="sidebar_section">
                            <div class="sidebar_title">
                                <h5>Sizes</h5>
                            </div>
                            <ul class="checkboxes">
                                @foreach ($dsSize as $size)
                                    <li class="cb-size" data-cb-size="{{ $size->size }}"><i class="fa fa-square-o"
                                            aria-hidden="true"></i><span>{{ $size->size }}</span>
                                    </li>
                                @endforeach
                                {{-- <li class="active"><i class="fa fa-square" aria-hidden="true"></i><span>M</span></li>
                                <li><i class="fa fa-square-o" aria-hidden="true"></i><span>L</span></li>
                                <li><i class="fa fa-square-o" aria-hidden="true"></i><span>XL</span></li>
                                <li><i class="fa fa-square-o" aria-hidden="true"></i><span>XXL</span></li> --}}
                            </ul>
                        </div>

                        <!-- Color -->
                        <div class="sidebar_section">
                            <div class="sidebar_title">
                                <h5>Màu sắc</h5>
                            </div>
                            <ul class="checkboxes">
                                @foreach ($dsMauSac as $mauSac)
                                    <li class="cb-color" data-cb-color="{{ $mauSac->id }}"><i class="fa fa-square-o"
                                            aria-hidden="true"></i><span>{{ $mauSac->ten }}</span>
                                    </li>
                                @endforeach
                                {{-- <li><i class="fa fa-square-o" aria-hidden="true"></i><span>Black</span></li> --}}
                                {{-- <li class="active"><i class="fa fa-square" aria-hidden="true"></i><span>Pink</span></li> --}}
                            </ul>
                            {{-- <div class="show_more">
                                <span><span>+</span>Show More</span>
                            </div> --}}
                        </div>

                    </div>

                    <!-- Main Content -->

                    <div class="main_content">

                        <!-- Products -->
                        {{-- <input type="hidden" name="the_loai_slug" value="{{ $theLoai->slug }}" /> --}}
                        <div class="products_iso">
                            <div class="row">
                                <div class="col">

                                    <!-- Product Sorting -->

                                    <div class="product_sorting_container product_sorting_container_top">
                                        <ul class="product_sorting">
                                            <li>
                                                <span class="type_sorting_text">Sắp xếp mặc định</span>
                                                <i class="fa fa-angle-down"></i>
                                                <ul class="sorting_type">
                                                    <li class="type_sorting_btn"
                                                        data-isotope-option='{ "sortBy": "created_at", "typeSort" : "desc" }'>
                                                        <span>Sắp xếp mặc định</span>
                                                    </li>
                                                    <li class="type_sorting_btn"
                                                        data-isotope-option='{ "sortBy": "gia", "typeSort": "asc" }'>
                                                        <span>Giá tăng
                                                            dần</span>
                                                    </li>
                                                    <li class="type_sorting_btn"
                                                        data-isotope-option='{ "sortBy": "gia", "typeSort": "desc" }'>
                                                        <span>Giá giảm
                                                            dần</span>
                                                    </li>
                                                    <li class="type_sorting_btn"
                                                        data-isotope-option='{ "sortBy": "ten", "typeSort": "asc" }'>
                                                        <span>Tên sản phẩm</span>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <span>Hiển thị</span>
                                                <span class="num_sorting_text">8</span>
                                                <i class="fa fa-angle-down"></i>
                                                <ul class="sorting_num">
                                                    <li class="num_sorting_btn"><span>8</span></li>
                                                    <li class="num_sorting_btn"><span>16</span></li>
                                                    {{-- <li class="num_sorting_btn"><span>24</span></li> --}}
                                                </ul>
                                            </li>
                                        </ul>


                                    </div>

                                    <!-- Product Grid -->

                                    <div id="list-product">
                                        @include('frontend.theloai.data')
                                    </div>

                                    <!-- Product Sorting -->


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/categories_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/categories_responsive.css') }}">
@endsection

@section('js_custom')
    <script src="{{ asset('coloshop/js/categories_custom.js') }}"></script>
    <script src="{{ asset('frontend/js/index.js') }}"></script>
@endsection
