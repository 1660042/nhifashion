<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="{{ $type == 'add' ? 'form-add' : 'form-update' }}">
                    @if ($type == 'edit')
                        <input type="hidden" name="id" value="{{ optional($data)->id }}">
                    @endif
                    <div class="form-group">
                        <label for="tenmon">Tên món ăn</label>
                        <input type="text" class="form-control" id="tenmon" value="{{ optional($data)->tenmon }}" name="tenmon"
                            placeholder="Nhập tên món" {{ $type == 'view' ? 'disabled' : '' }}>
                    </div>
                    <div class="form-group">
                        <label for="anh">Ảnh món ăn</label>
                        @if ($type == 'view')
                            <img src="{{ optional($data)->anh }}" class="form-control-file" style="width: 80px" alt="">
                        @else
                            <input type="file" class="form-control-file" id="anh" name="anh">
                        @endif
                      </div>
                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea class="form-control" id="mota" name="mota" rows="3" placeholder="Nhập mô tả"
                            {{ $type == 'view' ? 'disabled' : '' }}>{{ optional($data)->mota }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="gia">Giá</label>
                        <input type="text" class="form-control" id="gia" name="gia" value="{{ optional($data)->gia }}"
                            placeholder="Nhập giá bạn" {{ $type == 'view' ? 'disabled' : '' }}>
                    </div>
                    <div class="form-group">
                        <label for="idtheloai">Thể loại</label>
                        <select name="idtheloai" class="form-control" id="idtheloai"
                            {{ $type == 'view' ? 'disabled' : '' }}>
                            <option value="">Chọn thể loại</option>
                            @foreach ($dsTheLoai as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == optional($data)->idtheloai ? 'selected' : '' }}>{{ $item->ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idtheloai">Thương hiệu</label>
                        <select name="idth" class="form-control" id="idth" {{ $type == 'view' ? 'disabled' : '' }}>
                            <option value="">Chọn thương hiệu</option>
                            @foreach ($dsThuongHieu as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == optional($data)->idth ? 'selected' : '' }}>{{ $item->ten }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Đóng') }}</button>
                @if ($type != 'view')
                    <button type="button" id="{{ $type == 'add' ? 'btn-store-product' : 'btn-update-product' }}"
                        class="btn btn-primary">{{ __('Lưu thông tin') }}</button>
                @endif
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
