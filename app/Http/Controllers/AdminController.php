<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\DonHang;
use App\Models\TheLoai;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;

class AdminController extends Controller
{

    private $user = null;
    private $menu = null;
    private $donHang = null;
    private $pageCustom = null;
    private $data = null;
    private $theLoai = null;
    private $thuongHieu = null;
    private $sort = ['id' => 'desc'];

    private $folderImageProduct = 'image-product';

    public function __construct(User $user, Menu $menu, DonHang $donHang, TheLoai $theLoai, ThuongHieu $thuongHieu)
    {
        $this->user = $user;
        $this->menu = $menu;
        $this->donHang = $donHang;

        $this->theLoai = $theLoai;
        $this->thuongHieu = $thuongHieu;

        $this->pageCustom = config('constant')['pageCustom'];
    }
    public function index()
    {
        $totalUser = $this->user->count();
        $totalProduct = $this->menu->count();
        // $listOrderPlaced = $this->donHang->all();
        $totalOrderPlaced = $this->donHang->count();


        $data = [
            'totalUser' => $totalUser,
            'totalProduct' => $totalProduct,
            'totalOrderPlaced' => $totalOrderPlaced,
            // 'listOrderPlaced' => $listOrderPlaced,
        ];

        return view('admin.index', $data);
    }

    public function orderPlaced(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->page);
            if ($request->has('page')) {
                $this->pageCustom['page'] = $request->page;
            }

            $dsDonHang = DonHang::orderBy('id', 'desc')->paginate($this->pageCustom['numberOnPage'], $this->pageCustom['columns'], $this->pageCustom['pageName'], $this->pageCustom['page']);

            $dsDonHang->withPath(route('order.placed'));

            return response()->json([
                'status' => true,
                'view' => view('admin.list-order-placed', ['data' => $dsDonHang])->render(),
                'pagination' => view('common.pagination', ['paginator' => $dsDonHang])->render(),
                'message' => 'Success!'
            ], 200);
        }

        $dsDonHang = DonHang::orderBy('id', 'desc')->paginate($this->pageCustom['numberOnPage'], $this->pageCustom['columns'], $this->pageCustom['pageName'], $this->pageCustom['page']);
        return view('admin.order-placed', ['data' => $dsDonHang]);
    }



    public function product()
    {

        $dsThuongHieu = $this->thuongHieu->all();
        $dsTheLoai = $this->theLoai->all();

        $this->data = $this->menu->search($this->pageCustom, $this->sort);

        return view('admin.product', ['data' => $this->data, 'dsThuongHieu' => $dsThuongHieu, 'dsTheLoai' => $dsTheLoai]);
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $this->menu->loadDataSearch($request);

        if ($request->has('page')) {
            $this->pageCustom['page'] = $request->page;
        }

        $this->data = $this->menu->search($this->pageCustom, $this->sort);

        $this->data->withPath(route('admin.product.index'));

        return response()->json([
            'status' => true,
            'view' => view('admin.data-product', ['data' => $this->data])->render(),
            'pagination' => view('common.pagination', ['paginator' => $this->data])->render(),
            'message' => 'Success!'
        ], 200);
    }

    public function detail(Request $request, $id)
    {
        if ($request->ajax()) {

            $dsThuongHieu = $this->thuongHieu->all();
            $dsTheLoai = $this->theLoai->all();

            $this->data = $this->menu->find($id);

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
                'view' => view('admin.modal', [
                    'data' => $this->data,
                    'dsThuongHieu' => $dsThuongHieu,
                    'dsTheLoai' => $dsTheLoai,
                    'type' => 'view',
                    'title' => 'Thông tin món ăn',
                ])->render(),
            ], 200);
        }

        return abort(404);
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {

            $dsThuongHieu = $this->thuongHieu->all();
            $dsTheLoai = $this->theLoai->all();

            return response()->json([
                'status' => true,
                'view' => view('admin.modal', [
                    'data' => null,
                    'dsThuongHieu' => $dsThuongHieu,
                    'dsTheLoai' => $dsTheLoai,
                    'type' => 'add',
                    'title' => 'Thêm món ăn',
                ])->render(),
            ], 200);
        }

        return abort(404);
    }

    public function store(AddProductRequest $request)
    {

        $domain = $request->root();
        $this->menu->fill($request->all());

        $fileName = uniqid() . '_' . $request->file('anh')->getClientOriginalName();

        $this->menu->anh = $domain . '/storage/' . $this->folderImageProduct . '/' . $fileName;
        $rs = $this->menu->save();
        if ($rs) {

            // $request->file('anh')->move('upload', $fileName);
            $request->file('anh')->storeAs('public/' . $this->folderImageProduct, $fileName);

            $this->data = $this->menu->search($this->pageCustom, $this->sort);

            $this->data->withPath(route('admin.product.index'));
            return response()->json([
                'status' => true,
                'view' => view('admin.data-product', ['data' => $this->data])->render(),
                'pagination' => view('common.pagination', ['paginator' => $this->data])->render(),
                'message' => 'Success!'
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Fail',
        ], 500);
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {

            $dsThuongHieu = $this->thuongHieu->all();
            $dsTheLoai = $this->theLoai->all();

            $this->data = $this->menu->find($id);

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
                'view' => view('admin.modal', [
                    'data' => $this->data,
                    'dsThuongHieu' => $dsThuongHieu,
                    'dsTheLoai' => $dsTheLoai,
                    'type' => 'edit',
                    'title' => 'Cập nhật món ăn',
                ])->render(),
            ], 200);
        }

        return abort(404);
    }

    public function update(EditProductRequest $request, $id)
    {
        try {

            $this->data = $this->menu->find($request->id);
            if ($this->data == null) {
                return response()->json([
                    'status' => false,
                    'icon' => 'error',
                    'title' => __('Error'),
                    'message' => __('Page not found!'),
                ], 404);
            }

            $imgLinkOld = $this->data->anh;
            $arrTemp = explode("/", $imgLinkOld);
            $fileNameOld = end($arrTemp);

            $domain = $request->root();

            $fileName = uniqid() . '_' . $request->file('anh')->getClientOriginalName();

            $data = [
                'tenmon' => $request->tenmon,
                'mota' => $request->mota,
                'anh' => $domain . '/storage/' . $this->folderImageProduct . '/' . $fileName,
                'gia' => $request->gia,
                'idtheloai' => $request->idtheloai,
                'idth' => $request->idth,
            ];



            $this->data->update($data);

            $filePathOld = storage_path('app/public/' . $this->folderImageProduct). '/' . $fileNameOld;

            // dd($filePathOld);

            if (file_exists($filePathOld)) {
                unlink($filePathOld);
            }

            //Lưu vào storage/app/public/image-product/
            $request->file('anh')->storeAs('public/' . $this->folderImageProduct, $fileName);

            $this->data = $this->menu->search($this->pageCustom, $this->sort);

            $this->data->withPath(route('admin.product.index'));

            return response()->json([
                'status' => true,
                'view' => view('admin.data-product', ['data' => $this->data])->render(),
                'pagination' => view('common.pagination', ['paginator' => $this->data])->render(),
                'message' => 'Success!'
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $this->data = $this->menu->find($id);

        if ($this->data == null) {
            return response()->json([
                'status' => false,
                'icon' => 'error',
                'title' => __('Error'),
                'message' => __('Page not found!'),
            ], 404);
        }

        $this->data->delete();

        if ($request->has('page')) {
            $this->pageCustom['page'] = $request->page;
        }

        $this->menu->loadDataSearch($request);

        $this->data = $this->menu->search($this->pageCustom, $this->sort);

        $this->data->withPath(route('admin.product.index'));

        return response()->json([
            'status' => true,
            'view' => view('admin.data-product', ['data' => $this->data])->render(),
            'pagination' => view('common.pagination', ['paginator' => $this->data])->render(),
            'message' => 'Success!'
        ], 200);
    }
}
