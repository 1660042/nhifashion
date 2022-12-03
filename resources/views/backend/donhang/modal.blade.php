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
                    @method('PUT')
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
                                    <select class="form-control select2" name="phuong_thuc" id="phuong_thuc"
                                        style="width: 100%;">
                                        <option value="">Không</option>
                                        @foreach (config('constant.trang_thai.hoa_don') as $key => $phuongThuc)
                                            <option value="{{ $phuongThuc }}"
                                                {{ $key == optional($donHang)->phuong_thuc ? 'selected' : '' }}>
                                                {{ $phuongThuc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="anh">Dịa chỉ</label>
                            <input type="text" class="form-control" id="dia_Chi"
                                value="{{ optional($donHang)->dia_chi . ', ' . optional($donHang)->tinh . ', ' . optional($donHang)->huyen . ', ' . optional($donHang)->xa }}"
                                name="dia_Chi" />
                        </div>

                    </div>
                    <div class="col-md-6 sanpham-detail">
                        {{-- @foreach ($dsSanPhamChiTiet as $line => $item)
                            <div class="row sanpham-item">
                                <div class="form-group col-md-3">
                                    <label for="the_loai_id">Màu sắc</label>
                                    <select class="form-control select2" name="mau_sac[]"
                                        id="mau_sac_{{ $line }}" style="width: 100%;">
                                        <option value="">Chọn màu</option>
                                        @foreach ($dsMauSac as $key => $mauSac)
                                            <option value="{{ $mauSac->id }}"
                                                {{ $mauSac->id == optional($item)->id_mau_sac ? 'selected' : '' }}>
                                                {{ $mauSac->ten }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ten">Size</label>
                                    <input type="text" class="form-control" id="size_{{ $line }}"
                                        name="size[]" value="{{ optional($item)->size }}" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ten">Giá tiền</label>
                                    <input type="text" class="form-control" id="gia_{{ $line }}"
                                        name="gia[]" value="{{ optional($item)->gia }}" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="trang_thai">Trạng thái</label>
                                    <select class="form-control select2" name="trang_thai[]"
                                        id="trang_thai_{{ $line }}"
                                        style="width:
                                        100%;">
                                        <option>
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1 remove-row">
                                    <button class="btn btn-danger btn-remove-row"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach --}}
                        <div class="row mt-2 px-3 d-flex justify-content-center">
                            <button class="btn btn-primary btn-add-row" style="width: 50%;">Thêm dòng</button>
                        </div>
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
