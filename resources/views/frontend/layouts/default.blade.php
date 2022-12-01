<!DOCTYPE html>
<html lang="en">

<head>
    <title>Colo Shop</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Colo Shop Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/bootstrap4/bootstrap.min.css') }}">
    <link href="{{ asset('coloshop/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('coloshop/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/plugins/OwlCarousel2-2.2.1/animate.css') }}">

    @yield('css_custom')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">
</head>

<body>

    <div class="super_container">

        <!-- Header -->

        @include('frontend.layouts.header')

        @yield('content')

        <!-- Newsletter -->

        @include('frontend.layouts.benefit')

        <!-- Footer -->

        @include('frontend.layouts.footer')

    </div>

    {{-- <script src="{{ asset('coloshop/js/jquery-3.2.1.min.js') }}"></script> --}}
    <script src="{{ asset('adminlte3-1-0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte3-1-0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('coloshop/styles/bootstrap4/popper.js') }}"></script>
    <script src="{{ asset('coloshop/styles/bootstrap4/bootstrap.min.js') }}"></script>
    <script src="{{ asset('coloshop/plugins/Isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('coloshop/plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
    <script src="{{ asset('coloshop/plugins/easing/easing.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('frontend/js/common.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    @yield('js_custom')
    <script src="{{ asset('frontend/js/frontend.js') }}"></script>

</body>

</html>
