@extends('frontend.layouts.default')
{{-- @section('title', 'Thể loại') --}}
@section('content')
    <div id="single-page">
        <div class="container single_product_container">
            <div class="row">
                <div class="info col-md-7 my-5">
                    <h3 class="text-center">Thông tin thanh toán</h3>
                </div>
                <div class="cart col-md-5 my-5">
                    <h3 class="text-center">Giỏ hàng</h3>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/single_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('coloshop/styles/single_responsive.css') }}">
@endsection
@section('js_custom')
    <script src="{{ asset('coloshop/js/single_custom.js') }}"></script>
    {{-- <script src="{{ asset('frontend/js/index.js') }}"></script> --}}
@endsection
