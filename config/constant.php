<?php

return [
    'status' => [
        0 => [
            'value' => '0',
            'text' => 'Disable',
            'label' => 'danger',
        ],
        1 => [
            'value' => '1',
            'text' => 'Active',
            'label' => 'success',
        ]
    ],

    'number_element_on_page' => '1',
    'pageCustom' => [
        'numberOnPage' => '8',
        'columns' => ['*'],
        'pageName' => 'page',
        'page' => '1',
    ],

    'pagination' => [
        'item_per_page' => 10, //Phần tử trên trang
        'columns' => ['*'], //columns
        'page_name' => 'page', //tên phân trang
        'page' => 1 //Page hiện tại
    ],

    'type_modal' => [
        'show' => '0',
        'create' => '1',
        'edit' => '2',
    ],

    'trang_thai' => [
        'hoa_don' => [
            '0' => 'Chờ xác nhận',
            '1' => 'Chuẩn bị hàng',
            '2' => 'Đang giao hàng',
            '3' => 'Giao thành công',
            '4' => 'Giao thất bại'
        ]
    ]
];
