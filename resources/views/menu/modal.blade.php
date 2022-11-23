<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $data->tenmon }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img d-flex justify-content-center my-2" style="height: 300px;">
                    <img src="{{ $data->anh }}" style="height: 100%" alt="">
                </div>
                <div class="infomation m-2">
                    <div class="category">Thể loại: {{ $data->idtheloai }}</div>
                    <div class="brand">Thương hiệu: {{ $data->idth }}</div>
                    <div class="description">Mô tả: {{ $data->mota }}</div>
                    <div class="description">Giá: {{ $data->gia }}</div>
                </div>

                <form id="form-product" action="#" method="post">
                    <input type="hidden" name="id-product" value="{{ $data->id }}">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Đóng') }}</button>
                <div class="qty-product d-flex align-items-center">
                    <span><i class="fas fa-minus-circle decrease-qty"></i></span>
                    <input name="qty" type="text" class="form-control m-2" value="1">
                    <span><i class="fas fa-plus-circle increase-qty"></i></span>
                </div>
                <button type="button" id="add-cart" class="btn btn-primary">{{ __('Thêm vào giỏ hàng') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
