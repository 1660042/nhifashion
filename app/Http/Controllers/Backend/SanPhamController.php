<?php

namespace App\Http\Controllers\Backend;

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
                'view' => view('backend.sanpham.data', ['data' => $data])->render()
            ], 200);
        }
        return view('backend.sanpham.index', ['data' => $data]);
    }

    public function create(TheLoai $theLoaiModel, MauSac $mauSacModel)
    {
        $dsMauSac = $mauSacModel->dsMauSac($this->sort);
        $dsTheLoai = $theLoaiModel->dsTheLoai($this->sort);
        $dsSanPhamChiTiet = [0 => '1'];
        return response()->json([
            'view' => view('backend.sanpham.modal', [
                'data' => null,
                'dsTheLoai' => $dsTheLoai,
                'dsMauSac' => $dsMauSac,
                'dsSanPhamChiTiet' => $dsSanPhamChiTiet,
                'type_modal' => $this->cfTypeModal['create'],
            ])->render(),
        ], 200);
    }

    public function edit(TheLoai $theLoaiModel, MauSac $mauSacModel, $id)
    {
        $sanPham = $this->model->timSanPham(['id' => $id]);
        if (!$sanPham) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }

        $dsMauSac = $mauSacModel->dsMauSac($this->sort);
        $dsTheLoai = $theLoaiModel->dsTheLoai($this->sort);

        $dsHinhAnh = $sanPham->dsHinhAnh;
        $dsSanPhamChiTiet = $sanPham->dsSanPhamChiTiet;
        // var_dump($dsSanPhamChiTiet);
        // exit;
        return response()->json([
            'view' => view('backend.sanpham.modal', [
                'data' => $sanPham,
                'dsHinhAnh' => $dsHinhAnh,
                'dsSanPhamChiTiet' => $dsSanPhamChiTiet,
                'dsTheLoai' => $dsTheLoai,
                'dsMauSac' => $dsMauSac,
                'type_modal' => $this->cfTypeModal['edit'],
            ])->render(),
        ], 200);
    }

    public function store(Request $request)
    {
        $params = [
            'ten' => $request->ten,
            'anh' => $request->anh,
            'the_loai_id' => $request->the_loai_id,
            'hot' => $request->hot ? '1' : '0',
            'giam_gia' => $request->giam_gia,
            'gioi_thieu' => $request->gioi_thieu,
            'mau_sac' => $request->has('mau_sac') ? explode(',', $request->mau_sac) : NULL,
            'size' => $request->has('size') ? explode(',', $request->size) : NULL,
            'gia' => $request->has('gia') ? explode(',', $request->gia) : NULL,
            'trang_thai' => $request->has('trang_thai') ? explode(',', $request->trang_thai) : NULL,
            'san_pham_slug' => Str::slug($request->ten, '-'),
        ];

        $this->rules = AppHelper::getRules(Route::currentRouteName());
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

        $data = [
            'ten' => $params['ten'],
            'the_loai_id' => $params['the_loai_id'],
            'gioi_thieu' => $params['gioi_thieu'],
            'created_by' => auth()->id(),
            'hot' => $params['hot'],
            'giam_gia' => $params['giam_gia'],
            'san_pham_slug' => $params['san_pham_slug'],
        ];
        DB::beginTransaction();
        try {
            $sanPham = $this->model->create($data);
            if (!$sanPham) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Không thể tạo sản phẩm.',
                ], 400);
            }
            $files = [];
            foreach ($request->file('anh') as $file) {
                $name = Str::uuid() . '_' . date('YmdHis') .   '.' . $file->extension();
                $file->move(storage_path('app') . '/public/images', $name);
                $files[] = [
                    'ten_anh' => $name,
                    'id_sp' => $sanPham->id,
                ];
            }
            $sanPham->dsHinhAnh()->createMany($files);
            $dataChiTiet = $this->getDataSanPhamChiTiet($params, $sanPham->id);
            if (count($dataChiTiet) == 0) {
                if (isset($files))
                    $this->removeFile($files);
                DB::rollBack();
                return response()->json([
                    'message' => 'Lỗi khi tạo chi tiết sản phẩm.',
                ], 400);
            }
            $sanPham->dsSanPhamChiTiet()->insertOrIgnore($dataChiTiet);
            DB::commit();
            return response()->json([
                'message' => 'Lưu thành công.',
            ], 200);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            if (isset($files))
                $this->removeFile($files);
            DB::rollBack();
            return response()->json([
                'message' => 'Lưu thất bại. Vui lòng thử lại sau.'
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {

        $params = [
            'ten' => $request->ten,
            'anh' => $request->anh,
            'the_loai_id' => $request->the_loai_id,
            'hot' => $request->hot ? '1' : '0',
            'giam_gia' => $request->giam_gia,
            'gioi_thieu' => $request->gioi_thieu,
            'mau_sac' => $request->has('mau_sac') ? explode(',', $request->mau_sac) : NULL,
            'size' => $request->has('size') ? explode(',', $request->size) : NULL,
            'gia' => $request->has('gia') ? explode(',', $request->gia) : NULL,
            'trang_thai' => $request->has('trang_thai') ? explode(',', $request->trang_thai) : NULL,
            'san_pham_slug' => Str::slug($request->ten, '-'),

        ];

        // var_dump($request->all());
        // exit;

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

        $sanPham = $this->model->timSanPham(['id' => $id]);
        if (!$sanPham) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            if ($request->hasfile('anh')) {
                $oldFiles = [];
                foreach ($sanPham->dsHinhAnh as $hinhAnh) {
                    $oldFiles[] = [
                        'ten_anh' => $hinhAnh->ten_anh
                    ];
                }
                $files = [];
                foreach ($request->file('anh') as $file) {
                    $name = Str::uuid() . '_' . date('YmdHis') .   '.' . $file->extension();
                    $file->move(storage_path('app') . '/public/images', $name);
                    $files[] = [
                        'ten_anh' => $name,
                        'id_sp' => $sanPham->id,
                    ];
                }
                $sanPham->dsHinhAnh()->delete();
                $sanPham->dsHinhAnh()->createMany($files);
            }

            $sanPham->dsSanPhamChiTiet()->delete();
            $dataChiTiet = $this->getDataSanPhamChiTiet($params, $sanPham->id);
            if (count($dataChiTiet) == 0) {
                if (isset($files))
                    $this->removeFile($files);
                DB::rollBack();
                return response()->json([
                    'message' => 'Lỗi khi tạo chi tiết sản phẩm.',
                ], 400);
            }
            $sanPham->dsSanPhamChiTiet()->insertOrIgnore($dataChiTiet);

            $data = [
                'ten' => $params['ten'],
                'the_loai_id' => $params['the_loai_id'],
                'gioi_thieu' => $params['gioi_thieu'],
                'updated_by' => auth()->id(),
                'hot' => $params['hot'],
                'giam_gia' => $params['giam_gia'],
                'san_pham_slug' => $params['san_pham_slug'],

            ];

            $sanPham->update($data);
            // var_dump($oldFiles);
            // exit;
            if (isset($oldFiles)) {
                $this->removeFile($oldFiles);
            }
            DB::commit();
            return response()->json([
                'message' => 'Lưu thành công.',
            ], 200);
        } catch (\Exception $e) {
            var_dump($e->getMessage() . ' - ' . $e->getLine());
            DB::rollBack();
            if (isset($files))
                $this->removeFile($files);
            return response()->json([
                'message' => 'Lưu thất bại. Vui lòng thử lại sau.'
                // 'message' => $e->getMessage()
            ], 400);
        }
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
