<div class="d-flex justify-content-between">
    <div>
        <button class="btn btn-success" id="btn-add">
            <i class="far fa-plus-square"></i>&nbsp;Thêm thể loại
        </button>
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
                <th class="text-center" scope="col">Tên thể loại</th>
                <th class="text-center" scope="col">Thể loại cha</th>
                <th class="text-center" scope="col">Hiển thị ở trang chủ</th>
                <th class="text-center" scope="col">Ngày tạo</th>
                <th class="text-center" scope="col">Người tạo</th>
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
                        <td class="text-center{{ $item->the_loai_cha_id ? '' : ' text-red' }}">
                            {{ optional($item)->the_loai_cha ? optional($item)->the_loai_cha : 'Không' }}
                        </td>
                        <td class="text-center{{ $item->is_show ? '' : ' text-red' }}">
                            {{ optional($item)->is_show ? 'Có' : 'Không' }}
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse(optional($item)->created_at)->format('d-m-Y') }}
                        </td>
                        <td class="text-center">
                            {{ optional($item)->nguoiTao }}
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
