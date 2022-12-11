<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MauSac;
use App\Models\SanPham;
use App\Models\TheLoai;
use App\Helpers\AppHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    private $model = null;
    private $sort = null;
    private $pagination = null;

    public function __construct(SanPham $model)
    {
        $this->pagination = config('constant.pagination');
        $this->cfTypeModal = config('constant.type_modal');
        $this->sort = [
            ['column' => 'created_at', 'type' => 'desc'],
        ];
        $this->model = $model;
    }

    public function index(TheLoai $theLoaiModel, Request $request)
    {
        $this->pagination['page'] = $request->has('page') ? $request->page : $this->pagination['page'];
        $dsTheLoaiTieuBieu = $theLoaiModel->where('is_show', '1')->get();
        $dsHangMoiVe = $this->model->dsHangMoiVe();
        $dsHangHot = $this->model->dsHangHot();
        return view('frontend.index.index', [
            'dsTheLoaiTieuBieu' => $dsTheLoaiTieuBieu,
            'dsHangMoiVe' => $dsHangMoiVe,
            'dsHangHot' => $dsHangHot
        ]);
    }

    public function getHangMoiVe(Request $request)
    {
        $dsHangMoiVe = $this->model->dsHangMoiVe(['id' => $request->id]);
        return response()->json([
            'view' => view('frontend.index.data_new_product', [
                'dsHangMoiVe' => $dsHangMoiVe,
            ])->render(),
        ], 200);
    }
}
