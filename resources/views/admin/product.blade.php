@extends('layouts.default')
@section('title', 'Danh sách món ăn')
@section('content')
    <div id="product-admin-page">
        <div id="search-area" class="" style=" padding-top: 10px">
            @include('admin.search', ['search' => $search = null])
        </div>
        <div id="product-area">
            @include('admin.data-product')
        </div>

        <div class="pagination-custom d-flex justify-content-end my-3">
            @include('common.pagination', ['paginator' => $data])
        </div>
        <div id="modal-box" class="modal-box">
        </div>
    </div>
@endsection

@section('js_custom')
    <script src="{{ asset('js/product-admin.js') }}"></script>
@endsection
