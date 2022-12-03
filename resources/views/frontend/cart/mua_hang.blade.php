@extends('frontend.layouts.default')
@php
    $tongTien = 0;
@endphp
@section('content')
    <div id="mua-hang-page">
        <div class="container single_product_container">
            <div class="row">
                <div class="info col-md-7 my-5">
                    <h3 class="text-center">Thông tin thanh toán</h3>
                    <form id="mua-hang-form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="hoTen" id="hoTen" placeholder="Họ và tên" />
                        </div>
                        <div class="form-group row">
                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email">
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="soDienThoai" id="soDienThoai"
                                    placeholder="Số điện thoại">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="diaChi" name="diaChi"
                                placeholder="Đỉa chỉ" />
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" id="tinh" name="tinh">
                                        <option value="">Chọn Tỉnh/Thành</option>
                                        @foreach ($dsTinh as $tinh)
                                            <option value="{{ $tinh->Id }}">{{ $tinh->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="huyen" name="huyen">
                                        <option value="">Chọn Quận/Huyện</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="xa" name="xa">
                                        <option value="">Chọn Phường/Xã</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="phuong_thuc" name="phuong_thuc">
                                <option value="">Chọn phương thức thanh toán</option>
                                <option value="1">Tiền mặt</option>
                            </select>
                        </div>
                        <div class="button-group d-flex justify-content-between">
                            <button type="submit" id="cap-nhat-gio-hang" class="btn btn-default mt-4 pull-right">Cập nhật
                                giỏ hàng</button>
                            <button type="submit" id="dat-hang" class="btn btn-primary mt-4 pull-right">Xác nhận đặt
                                hàng</button>
                        </div>
                    </form>
                </div>
                <div class="cart col-md-5 my-5">
                    <h3 class="text-center">Giỏ hàng</h3>
                    <div class="danh-sach-san-pham">
                        @if ($carts != null)
                            <table class="table">
                                <tbody>
                                    @foreach ($carts as $key => $item)
                                        @php
                                            
                                            $hinhAnh = isset($item['hinh_anh']) ? $item['hinh_anh'] : '';
                                            $tenSanPham = isset($item['ten_san_pham']) ? $item['ten_san_pham'] : '';
                                            $slug = isset($item['san_pham_slug']) ? $item['san_pham_slug'] : '';
                                            $size = isset($item['size']) ? $item['size'] : '';
                                            $mauSac = isset($item['mau_sac']) ? $item['mau_sac'] : '';
                                            $gia = isset($item['gia']) ? $item['gia'] : '';
                                            $giamGia = isset($item['giam_gia']) ? $item['giam_gia'] : '0';
                                            $soLuong = isset($item['so_luong']) ? $item['so_luong'] : '';
                                            $thanhTien = isset($item['thanh_tien']) ? $item['thanh_tien'] : '';
                                            
                                            $tiLeGiam = $giamGia == 0 ? $giamGia : $giamGia / 100;
                                            
                                            $thanhTien = $gia * $soLuong - $gia * $soLuong * $tiLeGiam;
                                            $tongTien += $thanhTien;
                                        @endphp
                                        <tr>
                                            <td class="text-left" style="vertical-align: middle;"><img
                                                    src="{{ asset('storage/images/' . $hinhAnh) }}"
                                                    style="max-height: 100px; width: 50px" />
                                            </td>
                                            <td class="text-left" style="vertical-align: middle;">
                                                <a class="font-weight-bold" target="_bank"
                                                    href="{{ route('frontend.san_pham.index', $slug) }}">{{ $tenSanPham }}</a></br>
                                                <small>{{ 'Phân loại: Size ' . $size . ' / ' . $mauSac }}</small>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                {{ $soLuong }}
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                {{ number_format($thanhTien, 0, '', ',') . ' VND' }}</td>


                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <div class="text-center">
                                <img width="200px"
                                    src="https://media.istockphoto.com/id/861576608/vector/empty-shopping-bag-icon-online-business-vector-icon-template.jpg?s=612x612&w=0&k=20&c=I7MbHHcjhRH4Dy0NVpf4ZN4gn8FVDnwn99YdRW2x5k0="
                                    alt="">
                                <h4 class="text-danger">Bạn chưa có sản phẩm nào trong giỏ hàng.</h4>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="tong-tien d-flex justify-content-between">
                        <p>Tổng tiền</p>
                        <p class="font-weight-bold">{{ number_format($tongTien, 0, '', ',') . ' VND' }}</p>
                    </div>
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
