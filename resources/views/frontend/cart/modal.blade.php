<div class="modal fade" id="cart-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Giỏ hàng ({{ $carts ? count($carts) : '0' }} sản phẩm)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($carts != null)
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Hình ảnh</th>
                                <th class="text-center">Sản phẩm</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Giảm giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Thành tiền</th>
                            </tr>
                        </thead>
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
                                @endphp
                                <tr>
                                    <td class="text-left" style="vertical-align: middle;"><img
                                            src="{{ asset('storage/images/' . $hinhAnh) }}"
                                            style="max-height: 200px; width: 100px" />
                                    </td>
                                    <td class="text-left" style="vertical-align: middle;">
                                        <a class="font-weight-bold" target="_bank"
                                            href="{{ route('frontend.san_pham.index', $slug) }}">{{ $tenSanPham }}</a></br>
                                        <small>{{ 'Phân loại: Size ' . $size . ' / ' . $mauSac }}</small>
                                    </td>
                                    <td class="text-center font-weight-bold" style="vertical-align: middle;">
                                        {{ number_format($gia, 0, '', ',') . ' VND' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        {{ $giamGia . ' %' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div style="width: 100px; text-align:center; margin: auto;">
                                            <i class="fa fa-caret-left"></i>
                                            <i class="fa fa-caret-right"></i>
                                            <input type="text" class="form-control" name="so_luong"
                                                id="so_luong_{{ $key }}"
                                                style="width: 100px; text-align:center; margin: auto;"
                                                value="{{ $soLuong }}" />
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        {{ number_format($thanhTien, 0, '', ',') . ' VND' }}</td>
                                    <td class="text-center" style="vertical-align: middle; cursor: pointer"><i
                                            class="fa fa-trash" aria-hidden="true" title="Xóa"></i>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        <img src="https://media.istockphoto.com/id/861576608/vector/empty-shopping-bag-icon-online-business-vector-icon-template.jpg?s=612x612&w=0&k=20&c=I7MbHHcjhRH4Dy0NVpf4ZN4gn8FVDnwn99YdRW2x5k0="
                            alt="">
                        <h4 class="text-danger">Bạn chưa có sản phẩm nào trong giỏ hàng.</h4>
                    </div>
                @endif
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-info" id="update-cart" data-dismiss="modal">Cập nhật giỏ
                    hàng</button>
                <a href="{{ route('frontend.cart.mua_hang') }}" class="btn btn-primary" id="checkout">Tiến hành thành
                    toán</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
