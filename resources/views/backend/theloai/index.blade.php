@extends('backend.layouts.default')
@section('title', 'Thể loại')
@section('content')
    <div id="theloai-page">
        <div id="search-area" class="" style=" padding-top: 10px">
            @include('backend.theloai.search')
        </div>
        <div id="list-area">
            @include('backend.theloai.data')
        </div>
        <div id="modal-box" class="modal-box">
        </div>
    </div>

@endsection

@section('js_custom')
    <script src="{{ asset('js/theloai.js') }}"></script>
@endsection
