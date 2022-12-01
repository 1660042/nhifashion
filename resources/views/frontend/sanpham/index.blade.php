@extends('frontend.layouts.default')
{{-- @section('title', 'Thể loại') --}}
@section('content')
    <div id="single-page">
        <div class="container single_product_container">
            <div class="row">
                <div class="col">

                    <!-- Breadcrumbs -->

                    <div class="breadcrumbs d-flex flex-row align-items-center">
                        <ul>
                            <li><a href="{{ route('frontend.index.index') }}">Home</a></li>
                            <li><a href="{{ route('frontend.the_loai.index', $sanPham->theLoaiSlug) }}"><i
                                        class="fa fa-angle-right" aria-hidden="true"></i>{{ $sanPham->tenTheLoai }}</a></li>
                            <li class="active"><a href="{{ $sanPham->san_pham_slug }}">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>{{ $sanPham->ten }}</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-7">
                    <div class="single_product_pics">
                        <div class="row">
                            <div class="col-lg-3 thumbnails_col order-lg-1 order-2">
                                <div class="single_product_thumbnails">
                                    <ul>
                                        @foreach ($dsHinhAnh as $key => $hinhAnh)
                                            <li {{ $key == 0 ? 'class=active' : '' }}><img
                                                    src="{{ asset('storage/images/' . $hinhAnh->ten_anh) }}" alt=""
                                                    data-image="{{ asset('storage/images/' . $hinhAnh->ten_anh) }}"></li>
                                        @endforeach
                                        {{-- <li class="active"><img src="images/single_2_thumb.jpg" alt=""
                                                data-image="images/single_2.jpg"></li>
                                        <li><img src="images/single_3_thumb.jpg" alt=""
                                                data-image="images/single_3.jpg"></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-9 image_col order-lg-2 order-1">
                                <div class="single_product_image">
                                    <div class="single_product_image_background"
                                        style="background-image:url({{ asset('storage/images/' . $dsHinhAnh[0]->ten_anh) }})">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="product_details">
                        <input type="hidden" name="san_pham_slug" value="{{ $sanPham->san_pham_slug }}" />
                        <div class="product_details_title">
                            <h2>{{ $sanPham->ten }}</h2>
                        </div>
                        @if ($sanPham->giaThapNhat == $sanPham->giaCaoNhat)
                            @php
                                $tiLeGiam = $sanPham->giam_gia == null || $sanPham->giam_gia == 0 ? $sanPham->giam_gia : $sanPham->giam_gia / 100;
                                $giaTien = $sanPham->giaCaoNhat - $sanPham->giaCaoNhat * $tiLeGiam;
                            @endphp
                            @if ($sanPham->giam_gia != null)
                                <div class="original_price">{{ number_format($sanPham->giaCaoNhat, 0, '', ',') . ' VND' }}
                                </div>
                            @endif
                            <div class="product_price"> {{ number_format($giaTien, 0, '', ',') . ' VND' }}</div>
                        @else
                            @php
                                $tiLeGiam = $sanPham->giam_gia == null || $sanPham->giam_gia == 0 ? $sanPham->giam_gia : $sanPham->giam_gia / 100;
                                $giaTienMin = $sanPham->giaThapNhat - $sanPham->giaThapNhat * $tiLeGiam;
                                $giaTienMax = $sanPham->giaCaoNhat - $sanPham->giaCaoNhat * $tiLeGiam;
                            @endphp
                            @if ($sanPham->giam_gia != null)
                                <div class="original_price">
                                    {{ number_format($sanPham->giaThapNhat, 0, '', ',') . ' ~ ' . number_format($sanPham->giaCaoNhat, 0, '', ',') . ' VND' }}
                                </div>
                            @endif

                            <div class="product_price">
                                {{ number_format($giaTienMin, 0, '', ',') . ' ~ ' . number_format($giaTienMax, 0, '', ',') . ' VND' }}
                            </div>
                        @endif
                        <div class="product_color">
                            <span>Chọn màu:</span>
                            <ul>
                                @foreach ($dsMauSac as $mauSac)
                                    <li data-color="{{ $mauSac->id }}"
                                        style="background: {{ $mauSac->code }}; position: relative;">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="product_size">
                            <span>Chọn size:</span>
                            <ul>
                                @foreach ($dsSize as $size)
                                    <li data-color="{{ $size->list_mau }}">{{ $size->size }}
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="quantity d-flex flex-column flex-sm-row align-items-sm-center">
                            <span style="width: 80px">Số lượng:</span>
                            <div class="quantity_selector">
                                <span class="minus"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                <span id="quantity_value">1</span>
                                <span class="plus"><i class="fa fa-plus" aria-hidden="true"></i></span>
                            </div>
                            <div class="red_button add_to_cart_button"><a href="#">Thêm vào giỏ hàng</a></div>
                            {{-- <div class="product_favorite d-flex flex-column align-items-center justify-content-center"> --}}
                        </div>
                        <div class="pro-short-desc my-5">
                            {!! $sanPham->gioi_thieu !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabs -->

    {{-- <div class="tabs_section_container">

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="tabs_container">
                        <ul
                            class="tabs d-flex flex-sm-row flex-column align-items-left align-items-md-center justify-content-center">
                            <li class="tab active" data-active-tab="tab_1"><span>Giới thiệu</span></li>
                            <li class="tab" data-active-tab="tab_2"><span>Thông tin chi tiết</span></li>
                            <li class="tab" data-active-tab="tab_3"><span>Đánh giá</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <!-- Tab Description -->

                    <div id="tab_1" class="tab_container active">
                        <div class="row">
                            <div class="col-lg-5 desc_col">
                                <div class="tab_title">
                                    <h4>Giới thiệu</h4>
                                </div>
                                <div class="tab_text_block">
                                    <h2>Pocket cotton sweatshirt</h2>
                                    <p>Nam tempus turpis at metus scelerisque placerat nulla deumantos solicitud felis.
                                        Pellentesque diam dolor, elementum etos lobortis des mollis ut...</p>
                                </div>
                                <div class="tab_image">
                                    <img src="images/desc_1.jpg" alt="">
                                </div>
                                <div class="tab_text_block">
                                    <h2>Pocket cotton sweatshirt</h2>
                                    <p>Nam tempus turpis at metus scelerisque placerat nulla deumantos solicitud felis.
                                        Pellentesque diam dolor, elementum etos lobortis des mollis ut...</p>
                                </div>
                            </div>
                            <div class="col-lg-5 offset-lg-2 desc_col">
                                <div class="tab_image">
                                    <img src="images/desc_2.jpg" alt="">
                                </div>
                                <div class="tab_text_block">
                                    <h2>Pocket cotton sweatshirt</h2>
                                    <p>Nam tempus turpis at metus scelerisque placerat nulla deumantos solicitud felis.
                                        Pellentesque diam dolor, elementum etos lobortis des mollis ut...</p>
                                </div>
                                <div class="tab_image desc_last">
                                    <img src="images/desc_3.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Additional Info -->

                    <div id="tab_2" class="tab_container">
                        <div class="row">
                            <div class="col additional_info_col">
                                <div class="tab_title additional_info_title">
                                    <h4>Chi tiết sản phẩm</h4>
                                </div>
                                <p>COLOR:<span>Gold, Red</span></p>
                                <p>SIZE:<span>L,M,XL</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Reviews -->

                    <div id="tab_3" class="tab_container">
                        <div class="row">

                            <!-- User Reviews -->

                            <div class="col-lg-6 reviews_col">
                                <div class="tab_title reviews_title">
                                    <h4>Đánh giá</h4>
                                </div>

                                <!-- User Review -->

                                <div class="user_review_container d-flex flex-column flex-sm-row">
                                    <div class="user">
                                        <div class="user_pic"></div>
                                        <div class="user_rating">
                                            <ul class="star_rating">
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="review">
                                        <div class="review_date">27 Aug 2016</div>
                                        <div class="user_name">Brandon William</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>

                                <!-- User Review -->

                                <div class="user_review_container d-flex flex-column flex-sm-row">
                                    <div class="user">
                                        <div class="user_pic"></div>
                                        <div class="user_rating">
                                            <ul class="star_rating">
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="review">
                                        <div class="review_date">27 Aug 2016</div>
                                        <div class="user_name">Brandon William</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Review -->

                            <div class="col-lg-6 add_review_col">

                                <div class="add_review">
                                    <form id="review_form" action="post">
                                        <div>
                                            <h1>Add Review</h1>
                                            <input id="review_name" class="form_input input_name" type="text"
                                                name="name" placeholder="Name*" required="required"
                                                data-error="Name is required.">
                                            <input id="review_email" class="form_input input_email" type="email"
                                                name="email" placeholder="Email*" required="required"
                                                data-error="Valid email is required.">
                                        </div>
                                        <div>
                                            <h1>Your Rating:</h1>
                                            <ul class="user_star_rating">
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            </ul>
                                            <textarea id="review_message" class="input_review" name="message" placeholder="Your Review" rows="4" required
                                                data-error="Please, leave us a review."></textarea>
                                        </div>
                                        <div class="text-left text-sm-right">
                                            <button id="review_submit" type="submit"
                                                class="red_button review_submit_btn trans_300"
                                                value="Submit">submit</button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div> --}}
    {{-- </div> --}}
@endsection

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/single_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/single_responsive.css') }}">
@endsection
@section('js_custom')
    <script src="{{ asset('coloshop/js/single_custom.js') }}"></script>
    {{-- <script src="{{ asset('frontend/js/index.js') }}"></script> --}}
@endsection
