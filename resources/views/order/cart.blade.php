<div class="table-responsive-sm">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Tên món ăn</th>
                <th class="text-center" scope="col">Hình ảnh</th>
                <th class="text-center" scope="col">Giá</th>
                <th class="text-center" scope="col">Số lượng</th>
                <th class="text-center" scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if ($data == null)
                <tr>
                    <th class="text-center" colspan="6">Giỏ hàng trống</th>
                </tr>
            @else
                @foreach ($data as $item)
                    <div class="row">
                        <tr style="height: 100px" data-id="{{ $item['id'] }}">
                            <th class="text-center h-100per" scope="row">
                                <div class="flex-wrap justify-content-center">
                                    {{ $item['id'] }}
                                </div>
                            </th>
                            <td class="text-left h-100per">
                                <div class="flex-wrap">
                                    {{ $item['tenmon'] }}
                                </div>
                            </td>
                            <td class="text-center h-100per"><img src="{{ $item['anh'] }}" height="100px" alt="">
                            </td>
                            <td class="text-right h-100per">
                                <div class="flex-wrap justify-content-center">
                                    {{ $item['gia'] }}
                                </div>
                            </td>
                            <td class="text-center h-100per" style="width: 130px">
                                <div class="flex-wrap qty-product d-flex align-items-center">
                                    <span><i class="fas fa-minus-circle decrease-qty"></i></span>
                                    <input name="qty" type="text" class="form-control m-2" value="{{ $item['qty'] }}">
                                    <span><i class="fas fa-plus-circle increase-qty"></i></span>
                                </div>
                            </td>
                            <td class="text-center h-100per">
                                <div class="flex-wrap justify-content-center">
                                    <i class="far fa-trash-alt remove-item-cart"></i>
                                </div>
                            </td>
                        </tr>
                    </div>
                @endforeach
            @endif
        </tbody>
    </table>
</div>