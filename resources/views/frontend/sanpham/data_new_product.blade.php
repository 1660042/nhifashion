<div class="col">
    <div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>
        @foreach ($dsHangMoiVe as $sp)
            <div class="product-item men">
                <div class="product discount product_filter">
                    <div class="product_image">
                        <a href="{{ route('frontend.san_pham.index', $sp->san_pham_slug) }}">
                            <img src="{{ asset('coloshop/images/product_1.png') }}" alt="">
                        </a>
                    </div>
                    {{-- <div class="favorite favorite_left"></div> --}}
                    @if ($sp->giam_gia && $sp->giam_gia > 0)
                        <div
                            class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center">
                            <span>-{{ $sp->giam_gia }}%</span>
                        </div>
                    @endif
                    <div class="product_info">
                        <h6 class="product_name"><a
                                href="{{ route('frontend.san_pham.index', $sp->san_pham_slug) }}">{{ $sp->ten }}</a>
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
                <div class="red_button add_to_cart_button"><a
                        href="{{ route('frontend.san_pham.index', $sp->san_pham_slug) }}">Chi tiết</a></div>

            </div>
        @endforeach
    </div>
</div>
