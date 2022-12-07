<?php

namespace App\Http\Controllers\Backend;

use App\Models\MauSac;
use App\Models\TheLoai;
use App\Helpers\AppHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\HoaDon;
use App\Models\HoaDonSanPham;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class DonHangController extends Controller
{
    private $model = null;
    private $sort = null;
    private $cfTypeModal = null;
    private $pagination = null;
    private $rules = null;

    public function __construct(HoaDon $model)
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
                'view' => view('backend.donhang.data', ['data' => $data])->render()
            ], 200);
        }
        return view('backend.donhang.index', ['data' => $data]);
    }

    public function edit(HoaDonSanPham $hdspModel, $id)
    {
        $donHang = $this->model->where('id', $id)->first();
        $donHangSanPham = $hdspModel->getHoaDonSanPham(['hoa_don_id' => $donHang->id]);
        if (!$donHang || count($donHangSanPham) == 0) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }

        return response()->json([
            'view' => view('backend.donhang.modal', [
                'donHang' => $donHang,
                'donHangSanPham' => $donHangSanPham,
            ])->render(),
        ], 200);
    }

    public function update(Request $request, $id)
    {

        $params = [
            'ten' => $request->ten,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,
            'dia_chi' => $request->dia_chi,
            'xa' => $request->xa,
            'huyen' => $request->huyen,
            'tinh' => $request->tinh,
            'trang_thai' => $request->trang_thai,
        ];

        $this->rules = AppHelper::getRules(Route::currentRouteName(), ['id' => $id]);
        $this->attributes = AppHelper::getAttributes(Route::currentRouteName());
        $validator = Validator::make(
            $params,
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

        $hoaDon = $this->model->find($id);
        if (!$hoaDon) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }

        $hoaDon->update($params);
    }

    public function delete(Request $request, $id)
    {
        $data = $this->model->timSanPham(['id' => $id]);
        if (!$data) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $data->delete();
            $oldFiles = [];
            foreach ($data->dsHinhAnh as $hinhAnh) {
                $oldFiles[] = [
                    'ten_anh' => $hinhAnh->ten_anh
                ];
            }
            $data->dsHinhAnh()->delete();
            $data->dsSanPhamChiTiet()->delete();
            if (isset($oldFiles)) {
                $this->removeFile($oldFiles);
            }
            DB::commit();
            return response()->json([
                'message' => 'Xóa thành công.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Xóa thất bại. Vui lòng thử lại sau.'
                // 'message' => $e->getMessage()
            ], 400);
        }
    }

    private function getDataSanPhamChiTiet($params, $idSp)
    {
        $data = [];
        $line = count($params['mau_sac']);
        if (count($params['size']) == $line && count($params['gia']) == $line && count($params['trang_thai']) == $line) {
            foreach ($params['mau_sac'] as $key => $value) {
                $data[] = [
                    'id_sp' => $idSp,
                    'id_mau_sac' => $value,
                    'size' => trim($params['size'][$key]),
                    'gia' => trim($params['gia'][$key]),
                    'trang_thai' => trim($params['trang_thai'][$key]),
                ];
            }
        }
        return $data;
    }

    private function removeFile($files)
    {
        $path = storage_path('app') . '/public/images';
        foreach ($files as $file) {
            if (file_exists($path . '/' . $file['ten_anh'])) {
                unlink($path . '/' . $file['ten_anh']);
            }
        }
    }
}
