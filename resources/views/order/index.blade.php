@extends('layouts.default')
@section('title', 'Giỏ hàng')
@section('content')
    <div id="order-page">
        <div class="row">
            <div id="cart-area" class="col-md-7">
                @include('order.cart', ['data' => $data])
            </div>
            <div id="customer-area" class="col-md-4">
                @include('order.customer', ['data' => $data])
            </div>
        </div>
    </div>

@endsection

@section('js_custom')
    <script src="{{ asset('js/order.js') }}"></script>
@endsection
