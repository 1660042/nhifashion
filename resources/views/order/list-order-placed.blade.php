<div class="table-responsive-sm">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Tên</th>
                <th class="text-center" scope="col">Số điện thoại</th>
                <th class="text-center" scope="col">Địa chỉ</th>
                <th class="text-center" scope="col">Ngày tạo</th>
                <th class="text-center" scope="col">Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr style="" data-id="{{ $item->id }}">
                    <th class="text-center">
                        {{ $item->id }}
                    </th>
                    <th class="text-left">
                        {{ $item->ten }}
                    </th>
                    <th class="text-center">
                        {{ $item->khachHang->sdt }}
                    </th>
                    <th class="text-left">
                        {{ $item->diachi }}
                    </th>
                    <th class="text-center">
                        {{ $item->created_at }}
                    </th>
                    <th class="text-center">
                        <i class="fas fa-eye"></i>
                    </th>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
