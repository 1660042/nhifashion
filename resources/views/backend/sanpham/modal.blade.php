@php
    $title = 'Tạo mới sản phẩm';
    $cfTypeModal = config('constant.type_modal');
    if ($type_modal == $cfTypeModal['edit']) {
        $title = 'Cập nhật sản phẩm';
    }
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
                <form class="row" id="form-modal" enctype="multipart/form-data">
                    <input type="hidden" name="type_modal" value="{{ $type_modal }}">
                    @if ($type_modal == $cfTypeModal['edit'])
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ optional($data)->id }}">
                    @endif
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="ten">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="ten" name="ten"
                                value="{{ optional($data)->ten }}" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="anh">Hình ảnh</label>
                            @if ($type_modal == $cfTypeModal['edit'] && isset($dsHinhAnh))
                                <div class="preview">
                                    @foreach ($dsHinhAnh as $hinhAnh)
                                        <img src="{{ asset('storage/images/' . $hinhAnh->ten_anh) }}"
                                            class="form-control-file" style="width: 80px" alt="">
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" class="form-control-file" id="anh" name="anh" multiple>
                        </div>

                        <div class="d-flex">
                            <div class="form-group col-md-6">
                                <label for="the_loai_id">Thể loại</label>
                                <select class="form-control select2" name="the_loai_id" id="the_loai_id"
                                    style="width: 100%;">
                                    <option value="">Không</option>
                                    @foreach ($dsTheLoai as $key => $theLoai)
                                        <option value="{{ $theLoai->id }}"
                                            {{ $theLoai->id == optional($data)->idTheLoai ? 'selected' : '' }}>
                                            {{ $theLoai->ten }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ten">Giảm giá (%)</label>
                                <input type="text" class="form-control" id="giam_gia" name="giam_gia"
                                    value="{{ optional($data)->giam_gia }}" />
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="gioi_thieu">Giới thiệu</label>
                            <textarea class="form-control" id="gioi_thieu" name="gioi_thieu" rows="3"></textarea>
                        </div>
                        <div class="form-check col-md-12" style="padding-left: 1.75rem">
                            <input type="checkbox" class="form-check-input" id="hot" name="hot" value="1"
                                {{ optional($data)->hot == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hot">Sản phẩm bán chạy</label>

                        </div>
                    </div>
                    <div class="col-md-6 sanpham-detail">
                        @foreach ($dsSanPhamChiTiet as $line => $item)
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
                                        <option value="1"
                                            {{ $type_modal == $cfTypeModal['create'] ? 'selected' : '' }}
                                            {{ $type_modal == $cfTypeModal['edit'] && optional($item)->trang_thai == 1 ? 'selected' : '' }}>
                                            Sử dụng
                                        </option>
                                        <option value="0"
                                            {{ $type_modal == $cfTypeModal['edit'] && optional($item)->trang_thai == 0 ? 'selected' : '' }}>
                                            Tạm dừng
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1 remove-row">
                                    <button class="btn btn-danger btn-remove-row"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
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
