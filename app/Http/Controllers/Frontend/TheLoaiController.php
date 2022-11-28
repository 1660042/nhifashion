<?php

namespace App\Http\Controllers\Frontend;

use App\Models\TheLoai;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MauSac;
use App\Models\SanPham;
use App\Models\SanPhamChiTiet;
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

    public function index(Request $request, SanPham $sanPhamModel, SanPhamChiTiet $spChiTietModel, $theLoaiSlug)
    {
        $this->pagination['page'] = $request->has('page') ? $request->page : $this->pagination['page'];
        $this->pagination['item_per_page'] = $request->has('numItem') ? $request->numItem : 8;


        $params = [
            'the_loai_slug' => $theLoaiSlug,
        ];
        if ($request->method() == 'POST') {
            if ($request->has('sort.sortBy') && $request->has('sort.typeSort')) {
                $sort = $request->sort;
                if ($sort['sortBy'] == 'gia') {
                    $this->sort = [
                        ['column' => 'giaThapNhat', 'type' => $sort['typeSort']],
                    ];
                } else {
                    $this->sort = [
                        ['column' => $sort['sortBy'], 'type' => $sort['typeSort']],
                    ];
                }
            }
            if ($request->has('sizes')) {
                $params['sizes'] = implode(', ', $request->sizes);
            }

            if ($request->has('colors')) {
                $params['colors'] = implode(', ', $request->colors);
            }
        }

        $dsSanPham = $sanPhamModel->timSanPhamTheoTheLoai($params, $this->pagination, $this->sort);
        $theLoai = $this->model->where('slug', $params['the_loai_slug'])->first();

        if ($request->method() == 'GET') {
            $dsTheLoaiCha = $this->model->dsTheLoaiCha();
            $dsSize = $spChiTietModel->dsSize();
            $dsMauSac = MauSac::all();

            return view('frontend.theloai.index', [
                'dsSanPham' => $dsSanPham,
                'dsTheLoaiCha' => $dsTheLoaiCha,
                'theLoai' => $theLoai,
                'dsSize' => $dsSize,
                'dsMauSac' => $dsMauSac,
            ]);
        }
        return response()->json([
            'view' => view('frontend.theloai.data', [
                'dsSanPham' => $dsSanPham,
            ])->render(),
        ], 200);
    }
}
