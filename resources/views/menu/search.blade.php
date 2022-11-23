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
                    <label for="nameSearch" class="col-md-3 col-form-label">{{ __('Tên món ăn') }}</label>
                    <div class="col-md-9">
                        <input type="text" value="" class="form-control" id="nameSearch" name="nameSearch">
                    </div>
                </div>
                <div class="form-group col-md-4 row my-0">
                    <label for="categorySearch" class="col-md-2 col-form-label">{{ __('Thể loại') }}</label>
                    <div class="col-md-10">
                        <select name="categorySearch" id="categorySearch" class="form-control">
                            <option value="">{{ __('Tất cả') }}</option>
                            @foreach ($dsTheLoai as $item)
                                <option value="{{ $item->id }}"> {{ $item->ten }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-4 row my-0">
                    <label for="brandSearch" class="col-md-3 col-form-label">{{ __('Thương hiệu') }}</label>
                    <div class="col-md-9">
                        <select name="brandSearch" id="brandSearch" class="form-control">
                            <option value="">{{ __('Tất cả') }}</option>
                            @foreach ($dsThuongHieu as $item)
                                <option value="{{ $item->id }}"> {{ $item->ten }}</option>
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
