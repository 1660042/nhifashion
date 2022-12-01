<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\SanPhamChiTiet;
use Illuminate\Support\Facades\Session;

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
        // print_r($sessionCarts);
        // exit;
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
                    $request->session()->put("gio_hang.san_pham." . $keyCart, $session);
                    continue;
                }
                $request->session()->forget('gio_hang.san_pham.' . $key);
            }
        }
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function muaHang()
    {
        return view('frontend.cart.mua_hang');
    }
}
