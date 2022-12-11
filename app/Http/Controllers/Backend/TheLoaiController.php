<?php

namespace App\Http\Controllers\Backend;

use App\Models\TheLoai;
use App\Helpers\AppHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class TheLoaiController extends Controller
{
    private $model = null;
    private $sort = null;
    private $cfTypeModal = null;
    private $pagination = null;
    private $rules = null;

    public function __construct(TheLoai $model)
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
                'view' => view('backend.theloai.data', ['data' => $data])->render()
            ], 200);
        }
        return view('backend.theloai.index', ['data' => $data]);
    }

    public function create()
    {
        $dsTheLoaiCha = $this->model->dsTheLoaiCha($this->sort);
        return response()->json([
            'view' => view('backend.theloai.modal', [
                'data' => null,
                'dsTheLoaiCha' => $dsTheLoaiCha,
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
            'view' => view('backend.theloai.modal', [
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

        if ($request->is_show == '1') {
            $totalShow = $this->model->where('is_show', '1')->count();
            if ($totalShow >= 3) {
                return response([
                    'message' => 'Hiện thể loại ở trang chủ giới hạn 3 thể loại. Vui lòng bỏ tick ở thể loại khác trước.',
                ], 400);
            }
        }

        $file = $request->file('ten_anh');
        $name = Str::uuid() . '_' . date('YmdHis') .   '.' . $file->extension();
        $file->move(storage_path('app') . '/public/images/the_loai', $name);

        $data = [
            'ten' => $request->ten,
            'the_loai_cha_id' => $request->the_loai_cha_id,
            'slug' => Str::slug($request->ten, '-'),
            'created_by' => auth()->id(),
            'ten_anh' => $name,
            'is_show' => $request->is_show,
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

        if ($request->is_show == '1') {
            $totalShow = $this->model->where([
                ['is_show', '=', '1'],
                ['id', '!=', $id],
            ])->count();
            if ($totalShow >= 3) {
                return response([
                    'message' => 'Hiện thể loại ở trang chủ giới hạn 3 thể loại. Vui lòng bỏ tick ở thể loại khác trước.',
                ], 400);
            }
        }

        $data = [
            'ten' => $request->ten,
            'the_loai_cha_id' => $request->the_loai_cha_id,
            'updated_by' => auth()->id(),
            'slug' => Str::slug($request->ten, '-'),
            'is_show' => $request->is_show,
        ];

        if ($request->has('ten_anh')) {
            $file = $request->file('ten_anh');
            $name = Str::uuid() . '_' . date('YmdHis') .   '.' . $file->extension();
            $file->move(storage_path('app') . '/public/images/the_loai', $name);
            $data['ten_anh'] = $name;
            $tenAnhCu = $theLoai->ten_anh;
        }

        try {
            $theLoai->update($data);
            if (isset($tenAnhCu) && strlen(trim($tenAnhCu)) > 0) {
                $this->removeFile($tenAnhCu);
            }
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

        $tenAnhCu = $theLoai->ten_anh;
        try {
            $theLoai->delete();
            $this->removeFile($tenAnhCu);
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

    private function removeFile($tenAnh)
    {
        $path = storage_path('app') . '/public/images/the_loai';
        if (file_exists($path . '/' . $tenAnh)) {
            unlink($path . '/' . $tenAnh);
        }
    }
}
