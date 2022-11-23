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
                    <div class="form-group col-md-12">
                        <label for="ten">Tên thể loại</label>
                        <input type="text" class="form-control" id="ten" name="ten"
                            value="{{ optional($data)->ten }}" />
                    </div>
                    <div class="form-group col-md-12">
                        <label for="the_loai_cha_id">Thể loại cha</label>
                        <select class="form-control select2" name="the_loai_cha_id" id="the_loai_cha_id"
                            style="width: 100%;">
                            <option value="">Không</option>
                            @foreach ($dsTheLoaiCha as $key => $theLoai)
                                <option value="{{ $theLoai->id }}"
                                    {{ $theLoai->id == optional($data)->id ? 'selected' : '' }}>
                                    {{ $theLoai->ten }}
                                </option>
                            @endforeach
                        </select>
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
