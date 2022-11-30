<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SanPham;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $menu = null;
    private $data = null;

    public function __construct(SanPham $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        // dd(session('cart.product'));
        $cart = array_values(session('cart.product'));
        // dd(array_values($a));
        // $request->session()->flush();
        return response()->json([
            'status' => true,
            'cart' => $cart,
        ], 200);
    }

    public function add(Request $request)
    {
        $quantity = $request->quantity;



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

        if ($request->session()->exists('gio_hang.san_pham.' . $sanPham->id . '_' . $spct->id_sp_chi_tiet)) {
            $quantity += Session::get('gio_hang.san_pham.' . $sanPham->id . '_' . $spct->id_sp_chi_tiet . '.qty');
        }

        $cookie = [
            'san_pham_id' => $sanPham->id,
            'san_pham_chi_tiet_id' => $spct->id_sp_chi_tiet,
            'gia' => $spct->gia,
            'giam_gia' => $sanPham->giam_gia,
            'qty' => $quantity,
        ];

        $request->session()->put("gio_hang.san_pham." . $sanPham->id . '_' . $spct->id_sp_chi_tiet, $cookie);

        $numCart = Session::get('gio_hang.san_pham') ? count(Session::get('gio_hang.san_pham')) : 0;

        return response()->json([
            'status' => true,
            'message' => __('Thêm vào giỏ hàng thành công!'),
            'num_cart' => $numCart
        ], 200);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;

        $product = $this->menu->find($id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'icon' => 'error',
                'title' => __('Error'),
                'message' => __('Product not found!'),
            ], 404);
        }

        // if ($request->session()->exists('cart.product.' . $product->id)) {
        //     // dd("OK");
        //     $qty += Session::get('cart.product.' . $product->id . '.qty');
        // }

        $request->session()->put("cart.product." . $product->id, [
            'id' => $product->id,
            'tenmon' => $product->tenmon,
            'gia' => $product->gia,
            'anh' => $product->anh,
            'qty' => $qty,
        ]);

        return response()->json([
            'status' => true,
            'icon' => 'success',
            'title' => __('Thành công'),
            'message' => __('Cập nhật giỏ hàng thành công!'),
        ], 200);
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $isDelAll = $request->isDelAll;

        $request->session()->forget('cart.product.' . $id);

        return response()->json([
            'status' => true,
            'icon' => 'success',
            'title' => __('Thành công'),
            'message' => __('Đã xóa thành công!'),
        ], 200);
    }
}
