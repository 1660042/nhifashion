<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">{{ __('Tìm kiếm') }}</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="form-search" action="">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="form-group col-md-4 row my-0">
                    <label for="ten_khach_hang_search" class="col-md-4 col-form-label">Tên khách hàng</label>
                    <div class="col-md-8">
                        <input type="text" value="" class="form-control" id="ten_khach_hang_search"
                            name="ten_khach_hang_search">
                    </div>
                </div>
                <div class="form-group col-md-4 row my-0">
                    <label for="so_dien_thoai_search" class="col-md-4 col-form-label">Số điện thoại</label>
                    <div class="col-md-8">
                        <input type="text" value="" class="form-control" id="so_dien_thoai_search"
                            name="so_dien_thoai_search">
                    </div>
                </div>
                <div class="form-group col-md-4 row my-0">
                    <label for="trang_thai_search" class="col-md-3 col-form-label">Trạng thái</label>
                    <div class="col-md-9">
                        <select class="form-control select2" name="trang_thai_search" id="trang_thai_search"
                            style="width: 100%;">
                            <option value="">Không</option>
                            @foreach (config('constant.trang_thai.hoa_don') as $key => $trangThai)
                                <option value="{{ $key }}">
                                    {{ $trangThai }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.row -->
    </div>
    <!-- /.card-body -->
    <div class="custom-search-footer card-footer d-flex justify-content-end">
        <button class="btn btn-xs btn-default mx-1 button-custom button-clear">{{ __('Làm mới') }}</button>
        <button class="btn btn-xs btn-success mx-1 button-custom button-search">{{ __('Tìm kiếm') }}</button>
    </div>
</div>
