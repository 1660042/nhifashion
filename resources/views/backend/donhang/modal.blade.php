@php
    $title = 'Đơn hàng';
@endphp
<div class="modal fade" id="my-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="row" id="form-modal">
                    <input type="hidden" name="id" value="{{ optional($donHang)->id }}">

                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="ten">Tên khách hàng</label>
                                    <input type="text" class="form-control" id="ten" name="ten"
                                        value="{{ optional($donHang)->ten }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="anh">Số điện thoại</label>
                                    <input type="text" class="form-control" id="sdt"
                                        value="{{ optional($donHang)->sdt }}" name="sdt" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="anh">Email</label>
                                    <input type="text" class="form-control" id="email"
                                        value="{{ optional($donHang)->email }}" name="email" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="anh">Phương thức thanh toán</label>
                                    <select class="form-control select2" name="phuong_thuc_thanh_toan"
                                        id="phuong_thuc_thanh_toan" style="width: 100%;">
                                        <option value="">Không</option>
                                        <option value="1"
                                            {{ optional($donHang)->phuong_thuc_thanh_toan == '1' ? 'selected' : '' }}>
                                            Tiền mặt</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="anh">Dịa chỉ</label>
                            <input type="text" class="form-control" id="dia_chi"
                                value="{{ optional($donHang)->dia_chi }}" name="dia_chi" />
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="anh">Phường/Xã</label>
                                    <input type="text" class="form-control" id="xa" name="xa"
                                        value="{{ optional($donHang)->xa }}" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="anh">Quận/Huyện</label>
                                    <input type="text" class="form-control" id="huyen"
                                        value="{{ optional($donHang)->huyen }}" name="huyen" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="anh">Tỉnh/Thành phố</label>
                                    <input type="text" class="form-control" id="tinh"
                                        value="{{ optional($donHang)->tinh }}" name="tinh" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="anh">Trạng thái đơn hàng</label>
                            <select class="form-control select2" name="trang_thai" id="trang_thai" style="width: 100%;">
                                <option value="">Không</option>
                                @foreach (config('constant.trang_thai.hoa_don') as $key => $trangThai)
                                    <option value="{{ $key }}"
                                        {{ $key == optional($donHang)->trang_thai ? 'selected' : '' }}>
                                        {{ $trangThai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 sanpham-detail">
                        <table class="table">
                            <tbody>
                                @foreach ($donHangSanPham as $key => $item)
                                    <tr>
                                        <td class="text-left" style="vertical-align: middle;"><img
                                                src="{{ asset('storage/images/' . $item->hinh_anh) }}"
                                                style="max-height: 100px; width: 50px" />
                                        </td>
                                        <td class="text-left" style="vertical-align: middle;">
                                            {{ $item->ten }}</br>
                                            <small>{{ 'Phân loại: Size ' . $item->size . ' / ' . $item->mau_sac }}</small>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            {{ $item->so_luong }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            {!! $item->gia > $item->thanh_tien
                                                ? '<span class="text-red" style="text-decoration: line-through;">' .
                                                    number_format($item->gia, 0, '', ',') .
                                                    ' VND' .
                                                    '</span></br>'
                                                : '' !!}
                                            {{ number_format($item->thanh_tien, 0, '', ',') . ' VND' }}
                                        </td>


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success" id="btn-save">Lưu</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
