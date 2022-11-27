<div class="container">
    <div class="row">
        <div class="col text-center">
            <div class="section_title new_arrivals_title">
                <h2>Hàng bán chạy</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="product_slider_container">
                <div class="owl-carousel owl-theme product_slider">

                    <!-- Slide 1 -->

                    @foreach ($dsHangHot as $sp)
                        <div class="owl-item product_slider_item">
                            <div class="product-item">
                                <div class="product discount">
                                    <div class="product_image">
                                        <img src="{{ asset('coloshop/images/product_1.png') }}" alt="">
                                    </div>
                                    <div class="favorite favorite_left"></div>
                                    <div
                                        class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                                        <span>-$20</span>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_name"><a href="single.html">{{ $sp->ten }}</a>
                                        </h6>
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
                            </div>
                        </div>
                    @endforeach


                </div>

                <!-- Slider Navigation -->

                <div
                    class="product_slider_nav_left product_slider_nav d-flex align-items-center justify-content-center flex-column">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </div>
                <div
                    class="product_slider_nav_right product_slider_nav d-flex align-items-center justify-content-center flex-column">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</div>
