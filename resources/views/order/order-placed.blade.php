@extends('layouts.default')
@section('title',  \Request::route()->getName() == 'admin.order-placed' ? 'Danh sách đơn hàng' : 'Đơn hàng đã đặt')
@section('content')
    <div id="order-placed-page">
        <div id="list-order-placed">
            @include('order.list-order-placed', ['data' => $data])
        </div>
        <div class="pagination-custom d-flex justify-content-end my-3">
            @include('common.pagination', ['paginator' => $data])
        </div>
        <div id="modal-box" class="modal-box">
        </div>
    </div>


@endsection

@section('js_custom')
    <script src="{{ asset('js/order-placed.js') }}"></script>
@endsection
