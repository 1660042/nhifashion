@php
    $disReadOrNot = [];
@endphp
<div class="modal fade" id="my-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tạo thể loại mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="row" id="form-modal">
                    <input type="hidden" name="type_modal" value="{{ $type_modal }}">
                    <input type="hidden" name="id" value="{{ optional($data)->id }}">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="ten">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="ten" name="ten"
                                value="{{ optional($data)->ten }}" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="the_loai_id">Thể loại</label>
                            <select class="form-control select2" name="the_loai_id" id="the_loai_id"
                                style="width: 100%;">
                                <option value="">Không</option>
                                @foreach ($dsTheLoai as $key => $theLoai)
                                    <option value="{{ $theLoai->id }}"
                                        {{ $theLoai->id == optional($data)->id ? 'selected' : '' }}>
                                        {{ $theLoai->ten }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="gioi_thieu">Giới thiệu</label>
                            <textarea class="form-control" id="gioi_thieu" name="gioi_thieu" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 sanpham-detail">
                        <div class="row sanpham-item">
                            <div class="form-group col-md-3">
                                <label for="the_loai_id">Màu sắc</label>
                                <select class="form-control select2" name="mau_sac" id="mau_sac_0" style="width: 100%;">
                                    <option value="">Chọn màu</option>
                                    @foreach ($dsMauSac as $key => $mauSac)
                                        <option value="{{ $theLoai->id }}"
                                            {{ $mauSac->id == optional($data)->id ? 'selected' : '' }}>
                                            {{ $mauSac->ten }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="ten">Size</label>
                                <input type="text" class="form-control" id="size" name="size"
                                    value="" />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ten">Giá tiền</label>
                                <input type="text" class="form-control" id="gia" name="gia"
                                    value="" />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="trang_thai">Trạng thái</label>
                                <select class="form-control select2" name="trang_thai" id="trang_thai_0"
                                    style="width: 100%;">
                                    <option value="">Sử dụng</option>
                                    <option value="">Tạm dừng</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1 remove-row">
                                <button class="btn btn-danger btn-remove-row"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
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
