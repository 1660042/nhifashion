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
                    <label for="ten_search" class="col-md-3 col-form-label">{{ 'Tên sản phẩm' }}</label>
                    <div class="col-md-9">
                        <input type="text" value="" class="form-control" id="ten_search" name="ten_search">
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
