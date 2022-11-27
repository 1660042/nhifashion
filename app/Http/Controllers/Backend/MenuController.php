<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TheLoai;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    private $model = null;
    private $data = null;
    private $sort = ['id' => 'desc'];
    private $pageCustom = null;

    private $theLoai = null;
    private $thuongHieu = null;

    public function __construct(Menu $menu, TheLoai $theLoai, ThuongHieu $thuongHieu)
    {
        $this->model = $menu;
        $this->pageCustom = config('constant')['pageCustom'];

        $this->theLoai = $theLoai;
        $this->thuongHieu = $thuongHieu;
    }

    public function index(Request $request)
    {

        $dsThuongHieu = $this->thuongHieu->all();
        $dsTheLoai = $this->theLoai->all();

        $this->data = $this->model->search($this->pageCustom, $this->sort);
        return view('menu.index', ['data' => $this->data, 'dsThuongHieu' => $dsThuongHieu, 'dsTheLoai' => $dsTheLoai]);
    }

    public function getData(Request $request) {
        if ($request->ajax()) {

            $this->data = $this->model->search($this->pageCustom, $this->sort);

            $this->data->withPath(route('menu.index'));
            return response()->json([
                'status' => true,
                'view' => view('menu.data', ['data' => $this->data])->render(),
                'pagination' => view('common.pagination', ['paginator' => $this->data])->render(),
                'message' => 'Success!'
            ], 200);
        }
        return abort(404);
    }

    public function search(Request $request)
    {
        $this->model->loadDataSearch($request);

        if ($request->has('page')) {
            $this->pageCustom['page'] = $request->page;
        }

        $this->data = $this->model->search($this->pageCustom, $this->sort);

        $this->data->withPath(route('menu.index'));

        return response()->json([
            'status' => true,
            'view' => view('menu.data', ['data' => $this->data])->render(),
            'pagination' => view('common.pagination', ['paginator' => $this->data])->render(),
            'message' => 'Success!'
        ], 200);
    }

    public function detail(Request $request, $id)
    {
        if ($request->ajax()) {

            $this->data = $this->model->find($id);

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
                'view' => view('menu.modal', ['data' => $this->data])->render(),
            ], 200);
        }

        return abort(404);
    }
}
