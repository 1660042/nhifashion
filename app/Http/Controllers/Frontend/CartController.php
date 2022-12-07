<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Menu;
use App\Models\HoaDon;
use App\Models\SanPham;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Models\HoaDonSanPham;
use App\Models\SanPhamChiTiet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    private $menu = null;
    private $data = null;

    public function __construct(SanPham $model)
    {
        $this->model = $model;
    }

    public function index(Request $request, SanPhamChiTiet $spctModel)
    {
        // $request->session()->forget('gio_hang.san_pham');

        $sessionCarts = session('gio_hang.san_pham');
        $carts = [];
        if ($sessionCarts) {
            foreach ($sessionCarts as $key => $item) {
                try {
                    $sanPham = $this->model->with(['hinhAnh', 'dsSanPhamChiTiet'])->find($item['san_pham_id']);
                    $spha = $sanPham->hinhAnh;
                    $spct = $sanPham->dsSanPhamChiTiet()->where([
                        ['id_mau_sac', '=', $item['id_mau_sac']],
                        ['size', '=', $item['size']],
                    ])->first();
                    if (!$sanPham || count($spha) == 0 || !$spct) {
                        continue;
                    }

                    $soLuong = $item['so_luong'];

                    $giamGia = $sanPham->giam_gia ? $sanPham->giam_gia : 0;
                    $tiLeGiam = $giamGia == 0 ? $giamGia : $giamGia / 100;
                    $gia = $spct->gia ? $spct->gia : 0;
                    $thanhTien = ($gia * $soLuong) - ($gia * $soLuong * $tiLeGiam);

                    $carts[$key] = [
                        'hinh_anh' => $spha[0]->ten_anh,
                        'ten_san_pham' => $sanPham->ten,
                        'san_pham_slug' => $sanPham->san_pham_slug,
                        'mau_sac' => $spct->mauSac->ten,
                        'size' => $spct->size,
                        'gia' => $gia,
                        'giam_gia' => $giamGia,
                        'so_luong' => $soLuong,
                        'thanh_tien' => $thanhTien,
                    ];
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    exit;
                    unset($carts[$key]);
                }
            }
        }

        return response()->json([
            'status' => true,
            'view' => view('frontend.cart.modal', ['carts' => $carts])->render(),
            'num_cart' => count($carts),
        ], 200);
    }

    public function add(Request $request)
    {
        $soLuong = $request->quantity;

        $sanPham = $this->model->with('dsSanPhamChiTiet')->where('san_pham_slug', $request->san_pham_slug)->first();
        if (!$sanPham) {
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm không tồn tại.',
            ], 404);
        }

        $spct = $sanPham->dsSanPhamChiTiet()->where([
            ['id_mau_sac', '=', $request->color_id],
            ['size', '=', $request->size],
        ])->first();

        if (!$spct) {
            return response()->json([
                'status' => false,
                'message' => 'Màu sắc và size không tồn tại.',
            ], 404);
        }
        $keyCart = $sanPham->id . '_' . $request->color_id . '_' . $request->size;
        if ($request->session()->exists('gio_hang.san_pham.' . $keyCart)) {
            $soLuong += Session::get('gio_hang.san_pham.' . $keyCart . '.so_luong');
        }

        $session = [
            'san_pham_id' => $sanPham->id,
            'id_mau_sac' => $request->color_id,
            'size' => $request->size,
            'so_luong' => $soLuong,
        ];

        $request->session()->put("gio_hang.san_pham." . $keyCart, $session);

        $numCart = Session::get('gio_hang.san_pham') ? count(Session::get('gio_hang.san_pham')) : 0;

        return response()->json([
            'status' => true,
            'message' => __('Thêm vào giỏ hàng thành công!'),
            'num_cart' => $numCart
        ], 200);
    }

    public function update(Request $request)
    {
        if (!$request->has('carts')) {
            $request->session()->forget('gio_hang.san_pham');
            return response()->json([
                'status' => true,
            ], 200);
        }

        $arrKeyCarts = [];
        foreach ($request->carts as $key => $num) {
            $arr = explode("_", $key);
            if (count($arr) != 5) continue;

            $soLuong = (int) $num;

            $keyCart = $arr[2] . '_' . $arr[3] . '_' . $arr[4];
            $arrKeyCarts[$keyCart] = $soLuong;
        }
        $sessionCarts = session('gio_hang.san_pham');
        if ($sessionCarts) {
            foreach ($sessionCarts as $key => $cart) {
                if (in_array($key, array_keys($arrKeyCarts))) {
                    $session = [
                        'san_pham_id' => $cart['san_pham_id'],
                        'id_mau_sac' => $cart['id_mau_sac'],
                        'size' => $cart['size'],
                        'so_luong' => $arrKeyCarts[$key],
                    ];
                    $request->session()->put("gio_hang.san_pham." . $key, $session);
                    continue;
                }
                $request->session()->forget('gio_hang.san_pham.' . $key);
            }
        }
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function muaHang(Request $request)
    {
        $sessionCarts = session('gio_hang.san_pham');
        $carts = [];
        if ($sessionCarts) {
            foreach ($sessionCarts as $key => $item) {
                try {
                    $sanPham = $this->model->with(['hinhAnh', 'dsSanPhamChiTiet'])->find($item['san_pham_id']);
                    $spha = $sanPham->hinhAnh;
                    $spct = $sanPham->dsSanPhamChiTiet()->where([
                        ['id_mau_sac', '=', $item['id_mau_sac']],
                        ['size', '=', $item['size']],
                    ])->first();
                    if (!$sanPham || count($spha) == 0 || !$spct) {
                        continue;
                    }

                    $soLuong = $item['so_luong'];

                    $giamGia = $sanPham->giam_gia ? $sanPham->giam_gia : 0;
                    $tiLeGiam = $giamGia == 0 ? $giamGia : $giamGia / 100;
                    $gia = $spct->gia ? $spct->gia : 0;
                    $thanhTien = ($gia * $soLuong) - ($gia * $soLuong * $tiLeGiam);

                    $carts[$key] = [
                        'hinh_anh' => $spha[0]->ten_anh,
                        'ten_san_pham' => $sanPham->ten,
                        'san_pham_slug' => $sanPham->san_pham_slug,
                        'mau_sac' => $spct->mauSac->ten,
                        'size' => $spct->size,
                        'gia' => $gia,
                        'giam_gia' => $giamGia,
                        'so_luong' => $soLuong,
                        'thanh_tien' => $thanhTien,
                    ];
                } catch (\Exception $e) {
                    unset($carts[$key]);
                }
            }
        }
        $dsTinh = $this->diaLy($request);
        return view('frontend.cart.mua_hang', ['carts' => $carts, 'dsTinh' => $dsTinh]);
    }

    public function datHang(HoaDon $hoaDonModel, HoaDonSanPham $hdctModel, SanPhamChiTiet $spctModel, Request $request)
    {
        $sessionCarts = session('gio_hang.san_pham');
        if (!$sessionCarts) {
            return response([
                'message' => 'Giỏ hàng trống.',
            ], 400);
        }
        $rules = AppHelper::getRules(Route::currentRouteName());
        $attributes = AppHelper::getAttributes(Route::currentRouteName());
        $validator = Validator::make(
            $request->all(),
            $rules,
            [
                'soDienThoai.*' => ':attribute gồm 10 số',
                'tinh.*' => ':attribute phải là chữ tối đa 60 ký tự',
                'huyen.*' => ':attribute phải là chữ tối đa 60 ký tự',
                'xa.*' => ':attribute phải là chữ tối đa 60 ký tự'
            ],
            $attributes
        );
        if ($validator->fails()) {
            return response([
                'messages' => $validator->errors(),
                'message' => 'Đặt hàng không thành công.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $data = [
                'ten' => $request->hoTen,
                'sdt' => $request->soDienThoai,
                'email' => $request->email,
                'dia_chi' => $request->diaChi,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc,
                'tinh' => $request->tinh,
                'huyen' => $request->huyen,
                'xa' => $request->xa,
            ];

            $hoaDon = $hoaDonModel->create($data);
            if (!$hoaDon) {
                DB::rollBack();
                return response([
                    'message' => 'Không thể tạo hóa đơn.',
                ], 400);
            }

            $dataChiTiet = [];
            foreach ($sessionCarts as $key => $item) {
                $spct = $spctModel->with('sanPham')->where([
                    ['id_mau_sac', '=', $item['id_mau_sac']],
                    ['size', '=', $item['size']],
                    ['id_sp', '=', $item['san_pham_id']],
                ])->first();
                if (!$spct) {
                    DB::rollBack();
                    return response([
                        'message' => 'Không thể tạo hóa đơn.',
                    ], 400);
                }

                $sanPham = $spct->sanPham;

                if (!$sanPham) {
                    DB::rollBack();
                    return response([
                        'message' => 'Không thể tạo hóa đơn.',
                    ], 400);
                }

                $soLuong = $item['so_luong'];

                $giamGia = $sanPham->giam_gia ? $sanPham->giam_gia : 0;
                $tiLeGiam = $giamGia == 0 ? $giamGia : $giamGia / 100;
                $gia = $spct->gia ? $spct->gia : 0;
                $thanhTien = ($gia * $soLuong) - ($gia * $soLuong * $tiLeGiam);

                $dataChiTiet[] = [
                    'hoa_don_id' => $hoaDon->id,
                    'san_pham_id' => $sanPham->id,
                    'id_mau_sac' => $item['id_mau_sac'],
                    'size' => $item['size'],
                    'so_luong' => $soLuong,
                    'gia' => $gia,
                    'thanh_tien' => $thanhTien,
                    'giam_gia' => $sanPham->giam_gia
                ];
            }
            // DB::enableQueryLog();
            $hoaDon->hoaDonSanPham()->createMany($dataChiTiet);
            DB::commit();
            $request->session()->forget('gio_hang.san_pham');
            return response([
                'message' => "Đặt hàng thành công. </br>Vui lòng chờ nhân viên cửa hàng liên hệ để xác nhận đơn hàng.",
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'Đặt hàng không thành công.',
            ], 400);
        }
    }

    public function diaLy(Request $request)
    {

        if ($request->session()->exists('dia_ly')) {
            $data = Session::get('dia_ly');
        } else {
            $response = Http::get('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json');
            $data = $response->object();
            $request->session()->put("dia_ly", $data);
        }

        if ($request->ajax()) {
            $tinhId = $request->tinh;
            $huyenId = $request->huyen;
            $huyen = [];
            $xa = [];
            if ($tinhId) {
                foreach ($data as $key => $row) {
                    if ($row->Id == $tinhId) {
                        $huyen = $row->Districts;
                        if ($huyenId) {
                            foreach ($huyen as $key => $rowHuyen) {
                                if ($rowHuyen->Id == $huyenId) {
                                    $xa = $rowHuyen->Wards;
                                    break;
                                }
                            }
                        }
                        break;
                    }
                }
                return response()->json([
                    'huyen' => $huyen,
                    'xa' => $xa,
                ], 200);
            }
        }
        if ($request->method() == 'GET') {
            return $data;
        }
        // dd($data);
    }
}
