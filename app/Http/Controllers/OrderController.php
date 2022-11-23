<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{

    private $cart = null;
    private $data = null;
    private $pageCustom = null;

    public function __construct()
    {
        $this->pageCustom = config('constant')['pageCustom'];
    }

    public function index()
    {
        $this->cart = session('cart.product');

        return view('order.index', ['data' => $this->cart]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $this->cart = session('cart.product');

            return response()->json([
                'status' => true,
                'view' => view('order.cart', ['data' => $this->cart])->render(),
                'message' => 'Success!'
            ], 200);
        }
        return abort(404);
    }

    public function order(OrderRequest $request)
    {

        DB::beginTransaction();

        try {
            $this->cart = session('cart.product');
            if ($this->cart == null) {
                return response()->json([
                    'status' => false,
                    'icon' => 'error',
                    'title' => __('Đặt hàng thất bại'),
                    'message' => __('Giỏ hàng trống! Vui lòng thêm món ăn vào giỏ hàng trước!'),
                ], 200);
            }

            $data = [
                'ten' => $request->ten,
                'diachi' => $request->diachi,
                'idkh' => auth()->id(),
            ];

            $donHang = DonHang::create($data);

            if ($donHang) {
                foreach ($this->cart as $cart) {
                    $chiTietDonHang[] = new ChiTietDonHang([
                        'madonhang' => $donHang->id,
                        'mamonan' => $cart['id'],
                        'tenmonan' => $cart['tenmon'],
                        'giatien' => $cart['gia'],
                        'soluong' => $cart['qty'],
                    ]);
                }
                $ctDH = $donHang->chiTietDonHang()->saveMany($chiTietDonHang);
            }

            DB::commit();

            $request->session()->forget('cart.product');

            return response()->json([
                'status' => true,
                'icon' => 'success',
                'title' => __('Đặt hàng thành công'),
                'message' => __('Bạn đã đặt hàng thành công!'),
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    public function placed(Request $request)
    {

        if ($request->ajax()) {
            // dd($request->page);
            if ($request->has('page')) {
                $this->pageCustom['page'] = $request->page;
            }

            if (auth()->user()->chuc_vu == 1 && $request->route()->getName() == 'admin.order-placed') {
                $dsDonHang = DonHang::orderBy('id', 'desc')->paginate($this->pageCustom['numberOnPage'], $this->pageCustom['columns'], $this->pageCustom['pageName'], $this->pageCustom['page']);
            } else {
                $dsDonHang = DonHang::where('idkh', '=', auth()->id())->orderBy('id', 'desc')->paginate($this->pageCustom['numberOnPage'], $this->pageCustom['columns'], $this->pageCustom['pageName'], $this->pageCustom['page']);
            }

            $dsDonHang->withPath(route('order.placed'));

            return response()->json([
                'status' => true,
                'view' => view('order.list-order-placed', ['data' => $dsDonHang])->render(),
                'pagination' => view('common.pagination', ['paginator' => $dsDonHang])->render(),
                'message' => 'Success!'
            ], 200);
        }

        //chuc_vu == 1 là admin, load tất cả đơn hàng
        if (auth()->user()->chuc_vu == 1 && $request->route()->getName() == 'admin.order-placed') {
            $dsDonHang = DonHang::orderBy('id', 'desc')->paginate($this->pageCustom['numberOnPage'], $this->pageCustom['columns'], $this->pageCustom['pageName'], $this->pageCustom['page']);
        } else {
            $dsDonHang = DonHang::where('idkh', '=', auth()->id())->orderBy('id', 'desc')->paginate($this->pageCustom['numberOnPage'], $this->pageCustom['columns'], $this->pageCustom['pageName'], $this->pageCustom['page']);
        }
        return view('order.order-placed', ['data' => $dsDonHang]);
    }

    public function placedDetail(Request $request)
    {

        if ($request->ajax()) {

            $id = $request->id;

            $this->data = ChiTietDonHang::where('madonhang', $id)->get();
            // dd($this->data);
            if ($this->data == null) {
                return response()->json([
                    'status' => false,
                    'icon' => 'error',
                    'title' => __('Error'),
                    'message' => __('Page not found!'),
                ], 404);
            }

            return response()->json([
                'status' => true,
                'view' => view('order.modal', ['data' => $this->data])->render(),
            ], 200);
        }

        return abort(404);
    }
}
