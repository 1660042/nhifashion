@extends('layouts.default')
@section('title', 'Thực đơn')
@section('content')
    <div id="menu-page">
        <div id="search-area" class="" style=" padding-top: 10px">
            @include('menu.search', ['search' => $search = null])
        </div>
        <div id="list-area">
            @include('menu.data', ['data' => $data])
        </div>
        <div class="pagination-custom d-flex justify-content-end my-3">
            @include('common.pagination', ['paginator' => $data])
        </div>
        <div id="modal-box" class="modal-box">
        </div>
    </div>

@endsection

@section('js_custom')
    <script src="{{ asset('js/menu.js') }}"></script>
@endsection
