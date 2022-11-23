<div class="col-md-12 text-right" style="padding-right: unset">
    <div class="btn btn-sm btn-success btn-add-product">
        <i class="far fa-plus-square"></i>&nbsp;Thêm món ăn
    </div>
</div>
<div class="table-responsive-sm">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Tên món ăn</th>
                <th class="text-center" scope="col">Ảnh</th>
                <th class="text-center" scope="col">Mô tả</th>
                <th class="text-center" scope="col">Giá</th>
                <th class="text-center" scope="col">Thể loại</th>
                <th class="text-center" scope="col">Thương hiệu</th>
                <th class="text-center" scope="col">Ngày tạo</th>
                <th class="text-center" scope="col">Ngày sửa</th>
                <th class="text-center" scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr style="" data-id="{{ $item->id }}">
                    <th class="text-center" style="width: 5%">
                        {{ $item->id }}
                    </th>
                    <th class="text-left" style="width: 10%">
                        {{ $item->tenmon }}
                    </th>
                    <th class="text-center" style="width: 10%">
                        <img src="{{ $item->anh }}" height="50px" alt="">
                    </th>
                    <th class="text-left" style="width: 15%">
                        {{ $item->mota }}
                    </th>
                    <th class="text-center" style="width: 10%">
                        {{ $item->gia }}
                    </th>
                    <th class="text-left" style="width: 10%">
                        {{ $item->getTheLoai->ten }}
                    </th>
                    <th class="text-left" style="width: 10%">
                        {{ $item->getThuongHieu->ten }}
                    </th>
                    <th class="text-center" style="width: 5%">
                        {{ $item->created_at }}
                    </th>
                    <th class="text-center" style="width: 5%">
                        {{ $item->updated_at }}
                    </th>
                    <th class="text-center" style="width: 10%">
                        <div class="product-view btn btn-xs btn-info" title="Xem chi tiết"><i class="fas fa-eye"></i></div>
                        <div class="product-edit btn btn-xs btn-primary" title="Sửa"><i class="far fa-edit"></i></div>
                        <div class="product-delete btn btn-xs btn-danger" title="Xóa"><i class="far fa-trash-alt"></i></div>
                    </th>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
