@extends('backend.layouts.default')
@section('title', 'Thể loại')
@section('content')
    <div id="sanpham-page">
        <div id="search-area" class="" style=" padding-top: 10px">
            @include('backend.sanpham.search')
        </div>
        <div id="list-area">
            @include('backend.sanpham.data')
        </div>
        <div id="modal-box" class="modal-box">
        </div>
    </div>

@endsection

@section('js_custom')
    <script src="{{ asset('admin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/sanpham.js') }}"></script>
@endsection
