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

    public function index(Request $request, $san_pham_slug)
    {
        $sanPham = $this->model->timsanPhamTheoSlug(['san_pham_slug' => $san_pham_slug]);
        if (!$sanPham) {
            return abort(404);
        }
        return view('frontend.sanpham.index', ['sanPham' => $sanPham]);
    }
}
