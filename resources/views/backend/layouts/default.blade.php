<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nhi Fashion | @yield('title', 'Trang chủ')</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte3-1-0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte3-1-0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte3-1-0/dist/css/adminlte.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte3-1-0/plugins/daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('adminlte3-1-0/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte3-1-0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('adminlte3-1-0/dist/img/AdminLTELogo.png') }}"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                @if (auth()->user()->chuc_vu == 1)
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('backend.admin.index') }}" class="nav-link">Trang quản trị Admin</a>
                    </li>
                @endif
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('backend.menu.index') }}" class="nav-link">Thực đơn</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown my-cart">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-shopping-bag"></i>
                        <span
                            class="badge badge-danger navbar-badge qty-product-in-cart">{{ session('cart.product') != null ? count(session('cart.product')) : 0 }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right list-product-in-cart">
                        @if (session('cart.product') != null)
                            @foreach (session('cart.product') as $key => $item)
                                <a href="#" class="dropdown-item cart-item" data-id={{ $item['id'] }}>
                                    <!-- Message Start -->
                                    <div class="media">
                                        <img src="{{ $item['anh'] }}" alt="Image product"
                                            class="img-size-50 mr-3 img-circle">
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title text-wrap">
                                                {{ $item['tenmon'] }}
                                            </h3>
                                            <p class="text-sm">Số lượng: {{ $item['qty'] }}</p>
                                            <p class="text-sm text-muted"><i class="fas fa-dollar-sign"></i> Giá:
                                                {{ $item['gia'] }} VND
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Message End -->
                                </a>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        @else
                            <div class="dropdown-item text-center">Giỏ hàng trống</div>
                        @endif
                        <a href="{{ route('backend.order.index') }}" class="dropdown-item dropdown-footer">Tới trang
                            giỏ
                            hàng</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" alt="Đăng xuất" title="Đăng xuất">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        @include('backend.layouts.sidebar')

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="{{ route('backend.home') }}">Nhi Fashion</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte3-1-0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte3-1-0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte3-1-0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <!-- daterangepicker -->
    <script src="{{ asset('adminlte3-1-0/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte3-1-0/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte3-1-0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <script src="{{ asset('adminlte3-1-0/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('adminlte3-1-0/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('#search-area').on('collapsed.lte.cardwidget', function() {
            $(".custom-search-footer").attr('style', 'display:none !important');
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    @yield('js_custom')
</body>

</html>
