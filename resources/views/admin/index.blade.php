@extends('layouts.default')
@section('title', 'Admin')
@section('content')
    <div class="admin-page">
        <div class="statistical">
            @include('admin.statistical', ['totalUser' => $totalUser, 'totalProduct' => $totalProduct, 'totalOrderPlaced' => $totalOrderPlaced])
        </div>
        {{-- <div class="order-placed">
            <div id="list-order-placed">
                @include('admin.list-order-placed', ['data' => $listOrderPlaced])
            </div>
        </div> --}}
        {{-- <div class="pagination-custom d-flex justify-content-end my-3">
            @include('common.pagination', ['paginator' => $listOrderPlaced])
        </div> --}}
        {{-- <div id="modal-box" class="modal-box">
        </div> --}}
    </div>
@endsection
