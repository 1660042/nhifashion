@extends('frontend.layouts.default')
{{-- @section('title', 'Thể loại') --}}
@section('content')
    <div id="index-page">
        <!-- Slider -->
        <div class="container product_section_container">
            <div class="row">
                <div class="col product_section clearfix">

                    <!-- Breadcrumbs -->

                    <div class="breadcrumbs d-flex flex-row align-items-center">
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li class="active"><a href="index.html"><i class="fa fa-angle-right"
                                        aria-hidden="true"></i>Men's</a></li>
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
                                    <li {!! $theLoaiCha->slug == $theLoaiSlug ? 'class="active"' : '' !!}>
                                        <a href="{{ route('frontend.the_loai.index', $theLoaiCha->slug) }}">{!! $theLoaiCha->slug == $theLoaiSlug
                                            ? '<i class="fa fa-angle-double-right" aria-hidden="true"></i></span>'
                                            : '' !!}
                                            {{ $theLoaiCha->ten }}
                                        </a>
                                    </li>
                                    @foreach ($theLoaiCha->theLoaiCon as $tlCon)
                                        <li {!! $tlCon->slug == $theLoaiSlug ? 'class="active"' : '' !!}>
                                            <a href="{{ route('frontend.the_loai.index', $tlCon->slug) }}">{!! str_repeat('&nbsp;', 3) !!}{!! $tlCon->slug == $theLoaiSlug ? '<i class="fa fa-angle-double-right" aria-hidden="true"></i></span>' : '' !!}
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

                        <!-- Price Range Filtering -->
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
                        </div>

                        <!-- Sizes -->
                        <div class="sidebar_section">
                            <div class="sidebar_title">
                                <h5>Sizes</h5>
                            </div>
                            <ul class="checkboxes">
                                @foreach ($dsSize as $size)
                                    <li><i class="fa fa-square-o" aria-hidden="true"></i><span>{{ $size->size }}</span>
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
                                    <li><i class="fa fa-square-o" aria-hidden="true"></i><span>{{ $mauSac->ten }}</span>
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
                                                        data-isotope-option='{ "sortBy": "original-order" }'>
                                                        <span>Sắp xếp mặc định</span>
                                                    </li>
                                                    <li class="type_sorting_btn"
                                                        data-isotope-option='{ "sortBy": "price" }'><span>Giá cả</span></li>
                                                    <li class="type_sorting_btn" data-isotope-option='{ "sortBy": "name" }'>
                                                        <span>Tên sản phẩm</span>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <span>Hiển thị</span>
                                                <span class="num_sorting_text">6</span>
                                                <i class="fa fa-angle-down"></i>
                                                <ul class="sorting_num">
                                                    <li class="num_sorting_btn"><span>6</span></li>
                                                    <li class="num_sorting_btn"><span>12</span></li>
                                                    <li class="num_sorting_btn"><span>24</span></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <div class="pages d-flex flex-row align-items-center">
                                            <div class="page_current">
                                                <span>1</span>
                                                <ul class="page_selection">
                                                    <li><a href="#">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                </ul>
                                            </div>
                                            <div class="page_total"><span>of</span> 3</div>
                                            <div id="next_page" class="page_next"><a href="#"><i
                                                        class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
                                        </div>

                                    </div>

                                    <!-- Product Grid -->

                                    <div class="product-grid">

                                        <!-- Product 1 -->

                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($dsSanPham as $sp)
                                            <div class="product-item men">
                                                <div class="product discount product_filter">
                                                    <div class="product_image">
                                                        <img src="{{ asset('coloshop/images/product_1.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="favorite favorite_left"></div>
                                                    <div
                                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                                        <span>-$20</span>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a
                                                                href="single.html">{{ $sp->ten }}</a></h6>
                                                        @if ($sp->giaThapNhat == $sp->giaCaoNhat)
                                                            @php
                                                                $tiLeGiam = $sp->giam_gia == null || $sp->giam_gia == 0 ? $sp->giam_gia : $sp->giam_gia / 100;
                                                                $giaTien = $sp->giaCaoNhat - $sp->giaCaoNhat * $tiLeGiam;
                                                            @endphp
                                                            <div class="product_price">
                                                                {{ number_format($giaTien, 0, '', ',') . ' VND' }}<span>{{ number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product_price">
                                                                {{ number_format($sp->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sp->giaCaoNhat, 0, '', ',') . ' VND' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="red_button add_to_cart_button"><a href="#">add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Product Sorting -->

                                    <div class="product_sorting_container product_sorting_container_bottom clearfix">
                                        <ul class="product_sorting">
                                            <li>
                                                <span>Hiển thị:</span>
                                                <span class="num_sorting_text">04</span>
                                                <i class="fa fa-angle-down"></i>
                                                <ul class="sorting_num">
                                                    <li class="num_sorting_btn"><span>01</span></li>
                                                    <li class="num_sorting_btn"><span>02</span></li>
                                                    <li class="num_sorting_btn"><span>03</span></li>
                                                    <li class="num_sorting_btn"><span>04</span></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <span class="showing_results">Showing 1–3 of 12 results</span>
                                        <div class="pages d-flex flex-row align-items-center">
                                            <div class="page_current">
                                                <span>1</span>
                                                <ul class="page_selection">
                                                    <li><a href="#">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                </ul>
                                            </div>
                                            <div class="page_total"><span>of</span> 3</div>
                                            <div id="next_page_1" class="page_next"><a href="#"><i
                                                        class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
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
