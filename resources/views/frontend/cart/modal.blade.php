<div class="modal fade" id="cart-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Giỏ hàng (5 sản phẩm)</h4>
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
                            @foreach ($carts as $item)
                                <tr>
                                    <td class="text-left"><img src="{{ asset('storage/images/' . $item['hinh_anh']) }}"
                                            style="max-height: 200px; width: 100px" />
                                    </td>
                                    <td class="text-left" style="vertical-align: middle;">
                                        <a class="font-weight-bold" href="http://">{{ $item['ten_san_pham'] }}</a></br>
                                        <small>{{ 'Phiên bản: Size ' . $item['size'] . ' / ' . $item['mau_sac'] }}</small>
                                    </td>
                                    <td class="text-right font-weight-bold">{{ $item['gia'] }}</td>
                                    <td class="text-center">{{ $item['giam_gia'] . ' %' }}</td>
                                    <td class="text-center">{{ $item['qty'] }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @endif
                {{-- <form class="row" id="form-modal" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="ten">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="ten" name="ten" value="" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="anh">Hình ảnh</label>
                            <input type="file" class="form-control-file" id="anh" name="anh" multiple>
                        </div>

                        <div class="d-flex">
                            <div class="form-group col-md-6">
                                <label for="the_loai_id">Thể loại</label>
                                <select class="form-control select2" name="the_loai_id" id="the_loai_id"
                                    style="width: 100%;">
                                    <option value="">Không</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ten">Giảm giá (%)</label>
                                <input type="text" class="form-control" id="giam_gia" name="giam_gia"
                                    value="" />
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="gioi_thieu">Giới thiệu</label>
                            <textarea id="gioi_thieu" class="form-control" id="gioi_thieu" name="gioi_thieu" rows="3"></textarea>
                        </div>
                        <div class="form-check col-md-12" style="padding-left: 1.75rem">
                            <input type="checkbox" class="form-check-input" id="hot" name="hot"
                                value="1">
                            <label class="form-check-label" for="hot">Sản phẩm bán chạy</label>

                        </div>
                    </div>
                    <div class="col-md-6 sanpham-detail">

                        <div class="row mt-2 px-3 d-flex justify-content-center">
                            <button class="btn btn-primary btn-add-row" style="width: 50%;">Thêm dòng</button>
                        </div>
                    </div>
                </form> --}}
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
