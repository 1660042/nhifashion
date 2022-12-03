@php
    // dd($dsTheLoai);
@endphp
<header class="header trans_300">

    <!-- Main Navigation -->

    <div class="main_nav_container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <div class="logo_container">
                        <a href="{{ route('frontend.index.index') }}">Nhi<span>Fashion</span></a>
                    </div>
                    <nav class="navbar">
                        <ul class="navbar_menu">
                            <li><a href="{{ route('frontend.index.index') }}">Trang chủ</a></li>
                            @foreach ($dsTheLoai as $theLoaiCha)
                                @if ($theLoaiCha->the_loai_cha_id == null)
                                    <li>
                                        <a
                                            href="{{ route('frontend.the_loai.index', $theLoaiCha->slug) }}">{{ $theLoaiCha->ten }}</a>
                                        @if (count($theLoaiCha->theLoaiCon) > 0)
                                            <div class="submenu">
                                                @foreach ($theLoaiCha->theLoaiCon as $theLoai)
                                                    <a
                                                        href="{{ route('frontend.the_loai.index', $theLoai->slug) }}">{{ $theLoai->ten }}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                            <li><a href="contact.html">Liên hệ</a></li>
                        </ul>
                        <ul class="navbar_user">
                            <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                            <li class="checkout" id="gio_hang">
                                <a href="">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="checkout_items" class="checkout_items">{{ $numCart }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="hamburger_container">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</header>
