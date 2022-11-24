<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TheLoai;
use App\Helpers\AppHelper;
use App\Models\MauSac;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SanPhamController extends Controller
{
    private $model = null;
    private $sort = null;
    private $cfTypeModal = null;
    private $pagination = null;
    private $rules = null;

    public function __construct(SanPham $model)
    {
        $this->pagination = config('constant.pagination');
        $this->cfTypeModal = config('constant.type_modal');
        $this->sort = [
            ['column' => 'created_at', 'type' => 'desc'],
        ];
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $this->pagination['page'] = $request->has('page') ? $request->page : $this->pagination['page'];
        $data = $this->model->searchData($request, $this->sort, $this->pagination);
        if ($request->method() == 'POST') {
            return response()->json([
                'view' => view('sanpham.data', ['data' => $data])->render()
            ], 200);
        }
        return view('sanpham.index', ['data' => $data]);
    }

    public function create(TheLoai $theLoaiModel, MauSac $mauSacModel)
    {
        $dsMauSac = $mauSacModel->dsMauSac($this->sort);
        $dsTheLoai = $theLoaiModel->dsTheLoai($this->sort);
        return response()->json([
            'view' => view('sanpham.modal', [
                'data' => null,
                'dsTheLoai' => $dsTheLoai,
                'dsMauSac' => $dsMauSac,
                'type_modal' => $this->cfTypeModal['create'],
            ])->render(),
        ], 200);
    }

    public function edit($id)
    {
        $theLoai = $this->model->timTheLoai(['id' => $id]);
        if (!$theLoai) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }
        $dsTheLoaiCha = $this->model->dsTheLoaiCha($this->sort);
        return response()->json([
            'view' => view('theloai.modal', [
                'data' => $theLoai,
                'dsTheLoaiCha' => $dsTheLoaiCha,
                'type_modal' => $this->cfTypeModal['edit'],
            ])->render(),
        ], 200);
    }

    public function store(Request $request)
    {
        $this->rules = AppHelper::getRules(Route::currentRouteName());
        $this->attributes = AppHelper::getAttributes(Route::currentRouteName());
        $validator = Validator::make(
            $request->all(),
            $this->rules,
            [
                'the_loai_cha_id.integer' => ':attribute không hợp lệ.'
            ],
            $this->attributes
        );
        if ($validator->fails()) {
            return response([
                'messages' => $validator->errors(),
                'message' => 'Lưu thất bại.',
            ], 400);
        }


        $data = [
            'ten' => $request->ten,
            'the_loai_cha_id' => $request->the_loai_cha_id,
            'created_by' => auth()->id(),
        ];
        try {
            $this->model->create($data);
            return response()->json([
                'message' => 'Lưu thành công.',
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Lưu thất bại. Vui lòng thử lại sau.'
                // 'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $this->rules = AppHelper::getRules(Route::currentRouteName(), ['id' => $id]);
        $this->attributes = AppHelper::getAttributes(Route::currentRouteName());
        $validator = Validator::make(
            $request->all(),
            $this->rules,
            [
                'the_loai_cha_id.integer' => ':attribute không hợp lệ.'
            ],
            $this->attributes
        );
        if ($validator->fails()) {
            return response([
                'messages' => $validator->errors(),
                'message' => 'Lưu thất bại.',
            ], 400);
        }

        $theLoai = $this->model->timTheLoai(['id' => $id]);
        if (!$theLoai) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }

        $data = [
            'ten' => $request->ten,
            'the_loai_cha_id' => $request->the_loai_cha_id,
            'updated_by' => auth()->id(),
        ];
        try {
            $theLoai->update($data);
            return response()->json([
                'message' => 'Lưu thành công.',
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Lưu thất bại. Vui lòng thử lại sau.'
                // 'message' => $e->getMessage()
            ], 400);
        }
    }

    public function delete(Request $request, $id)
    {
        $theLoai = $this->model->timTheLoai(['id' => $id]);
        if (!$theLoai) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }

        try {
            $theLoai->delete();
            return response()->json([
                'message' => 'Xóa thành công.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Xóa thất bại. Vui lòng thử lại sau.'
                // 'message' => $e->getMessage()
            ], 400);
        }
    }
}
