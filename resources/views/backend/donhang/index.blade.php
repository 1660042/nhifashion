@extends('backend.layouts.default')
@section('title', 'Đơn hàng')
@section('content')
    <div id="don-hang-page">
        <div id="search-area" class="" style=" padding-top: 10px">
            @include('backend.donhang.search')
        </div>
        <div id="list-area">
            @include('backend.donhang.data')
        </div>
        <div id="modal-box" class="modal-box">
        </div>
    </div>

@endsection

@section('js_custom')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/donhang.js') }}"></script>
@endsection
