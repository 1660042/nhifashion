<div class="d-flex justify-content-between">
    <div>
        {{-- <button class="btn btn-success" id="btn-add">
            <i class="far fa-plus-square"></i>&nbsp;Thêm sản phẩm
        </button> --}}
    </div>
    <div class="pagination-custom ">
        @include('common.pagination', ['paginator' => $data])
    </div>
</div>
<div class="table-responsive-sm">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Tên khách hàng</th>
                <th class="text-center" scope="col">Số điện thoại</th>
                <th class="text-center" scope="col">Địa chỉ</th>
                <th class="text-center" scope="col">Email</th>
                <th class="text-center" scope="col">Tổng tiền</th>
                <th class="text-center" scope="col">Ngày tạo</th>
                <th class="text-center" scope="col">Trạng thái</th>
                <th class="text-center" scope="col">Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) == 0)
                <tr>
                    <td class="text-center text-red text-bold" colspan="6">
                        Không tìm thấy dữ liệu nào.
                    </td>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr style="" data-id="{{ $item->id }}">
                        <td class="text-center">
                            {{ optional($item)->id }}
                        </td>
                        <td class="text-left">
                            {{ optional($item)->ten }}
                        </td>
                        <td class="text-center">
                            {{ optional($item)->sdt }}
                        </td>
                        <td class="text-left">
                            {{ optional($item)->dia_chi . ', ' . optional($item)->xa . ', ' . optional($item)->huyen . ', ' . optional($item)->tinh }}
                        </td>

                        <td class="text-center">
                            {{ optional($item)->email }}
                        </td>
                        <td class="text-center">
                            {{ number_format(optional($item)->hoaDonSanPham->sum('thanh_tien'), 0, '', ',') . ' VND' }}
                        </td>
                        <td class="text-center">
                            {{ optional($item)->created_at }}
                        </td>
                        <td class="text-center">
                            {{ config('constant.trang_thai.hoa_don')[optional($item)->trang_thai] }}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning px-3 btn-edit" title='Sửa'><i
                                    class="fas fa-pen"></i></button>
                            <button class="btn btn-sm btn-danger px-3 btn-delete" title="Xóa"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
