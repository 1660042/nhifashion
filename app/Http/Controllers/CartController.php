<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $menu = null;
    private $data = null;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
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
        $id = $request->id;
        $qty = $request->qty;

        $product = $this->menu->find($id);
        // $product = null;
        if ($product == null) {
            return response()->json([
                'status' => false,
                'icon' => 'error',
                'title' => __('Error'),
                'message' => __('Product not found!'),
            ], 404);
        }

        if ($request->session()->exists('cart.product.' . $product->id)) {
            // dd("OK");
            $qty += Session::get('cart.product.' . $product->id . '.qty');
        }

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
            'message' => __('Thêm vào giỏ hàng thành công!'),
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

    public function remove(Request $request) {
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
