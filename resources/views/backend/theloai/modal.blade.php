@php
    $title = 'Tạo mới thể loại';
    $cfTypeModal = config('constant.type_modal');
    if ($type_modal == $cfTypeModal['edit']) {
        $title = 'Cập nhật thể loại';
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
                    @if ($type_modal == $cfTypeModal['edit'])
                        @method('PUT')
                    @endif
                    <input type="hidden" name="type_modal" value="{{ $type_modal }}">
                    <input type="hidden" name="id" value="{{ optional($data)->id }}">
                    <div class="form-group col-md-12">
                        <label for="ten">Tên thể loại</label>
                        <input type="text" class="form-control" id="ten" name="ten"
                            value="{{ optional($data)->ten }}" />
                    </div>
                    <div class="form-group col-md-12">
                        <label for="anh">Hình ảnh</label>
                        @if ($type_modal == $cfTypeModal['edit'] && optional($data)->ten_anh)
                            <div class="preview">
                                <img src="{{ asset('storage/images/the_loai/' . optional($data)->ten_anh) }}"
                                    class="form-control-file" style="width: 80px" alt="">
                            </div>
                        @endif
                        <input type="file" class="form-control-file" id="ten_anh" name="ten_anh">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="the_loai_cha_id">Thể loại cha</label>
                        <select class="form-control select2" name="the_loai_cha_id" id="the_loai_cha_id"
                            style="width: 100%;">
                            <option value="">Không</option>
                            @foreach ($dsTheLoaiCha as $key => $theLoai)
                                @if ($theLoai->id == optional($data)->id)
                                    @php
                                        continue;
                                    @endphp
                                @endif
                                <option value="{{ $theLoai->id }}"
                                    {{ $theLoai->id == optional($data)->the_loai_cha_id ? 'selected' : '' }}>
                                    {{ $theLoai->ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check col-md-12" style="padding-left: 1.75rem">
                        <input type="checkbox" class="form-check-input" id="is_show" name="is_show" value="1"
                            {{ optional($data)->is_show == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_show">Hiện thể loại ở trang chủ</label>

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
