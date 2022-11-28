<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanPham extends Model
{
    use HasFactory;

    protected $table = 'san_pham';
    protected $fillable = [
        'ten', 'the_loai_id', 'gia', 'gioi_thieu',
        'created_by', 'updated_by', 'hot', 'giam_gia', 'san_pham_slug'
    ];

    public function searchData($request, $sort = null, $pagination = null, $typeSearch = 'ALL')
    {

        $joins = [
            [
                'databaseName' =>  'users',
                'typeJoin' => 'innerJoin',
                'on' => [$this->table . '.created_by' => 'users.id'],
            ],
            [
                'databaseName' => 'the_loai',
                'typeJoin' => 'innerJoin',
                'on' => [$this->table . '.the_loai_id' => 'the_loai.id'],
            ],
        ];

        $select = DB::raw(
            $this->table . '.*, users.ten as nguoiTao,the_loai.ten as tenTheLoai',
        );

        $condition = [];

        if ($request->ten_search !== null) {
            $condition[] = ['column' => 'ten', 'compare' => 'like', 'value' => $request->ten_search];
        }

        return AppHelper::findData($this, $condition, $typeSearch, $pagination, $sort, null, $joins, $select);
    }

    public function timSanPham($params)
    {

        $joins = [
            [
                'databaseName' => 'the_loai',
                'typeJoin' => 'innerJoin',
                'on' => [$this->table . '.the_loai_id' => 'the_loai.id'],
            ],
        ];

        $relations = [
            'dsHinhAnh' => 0,
            'dsSanPhamChiTiet' => 0,
        ];

        $select = DB::raw(
            $this->table . '.*, the_loai.id as idTheLoai, the_loai.ten as tenTheLoai',
        );

        $condition = [];
        if (isset($params['id'])) {
            $condition[] = ['column' => 'id', 'compare' => '=', 'value' => $params['id']];
        }
        if (count($condition) == 0) return null;

        return AppHelper::findData($this, $condition, 'ONE', null, null, $relations, $joins, $select);
    }

    public function dsHinhAnh()
    {
        return $this->hasMany(SanPhamHinhAnh::class, 'id_sp', 'id');
    }

    public function dsSanPhamChiTiet()
    {
        return $this->hasMany(SanPhamChiTiet::class, 'id_sp', 'id');
    }

    public function dsHangMoiVe($params = null, $limit = 10)
    {
        $theLoaiModel = new TheLoai();
        $sort = [
            ['column' => 'created_at', 'type' => 'desc'],
        ];
        $joins = [
            [
                'databaseName' => 'the_loai as the_loai_2',
                'typeJoin' => 'leftJoin',
                'on' => ['RAW' => 'the_loai.the_loai_cha_id = the_loai_2.id OR the_loai.id = the_loai_2.the_loai_cha_id',],
            ],
            [
                'databaseName' => 'san_pham',
                'typeJoin' => 'innerJoin',
                'on' => ['RAW' => 'san_pham.the_loai_id = the_loai.id OR san_pham.the_loai_id = the_loai_2.id'],
            ],
            [
                'databaseName' => 'san_pham_chi_tiet as spct',
                'typeJoin' => 'innerJoin',
                'on' => ['san_pham.id' => 'spct.id_sp'],
            ],
        ];

        $select = DB::raw(
            $this->table . '.*, MIN(spct.gia) as giaThapNhat, MAX(spct.gia) as giaCaoNhat',
        );

        $condition = [];

        if (isset($params['id']) && $params['id'] != null) {
            $condition[] = ['column' => 'the_loai.id', 'compare' => 'like', 'value' => $params['id']];
        }

        $groupBy = DB::raw('san_pham.id, san_pham.ten');

        return AppHelper::findData($theLoaiModel, $condition, 'LIMIT', null, $sort, null, $joins, $select, $groupBy, null, $limit);
    }

    public function dsHangHot()
    {
        $query = $this->query();

        $query->selectRaw(DB::raw(
            $this->table . '.*, MIN(spct.gia) as giaThapNhat, MAX(spct.gia) as giaCaoNhat',
        ));
        $query->join('san_pham_chi_tiet as spct', 'san_pham.id', '=', 'spct.id_sp');
        $query->groupBy(DB::raw('san_pham.id, san_pham.ten'));

        return $query->where('hot', '1')->inRandomOrder()->limit(10)->get();

        // $groupBy = DB::raw('san_pham.id, san_pham.ten');

        // return AppHelper::findData($theLoaiModel, $condition, 'ALL', $pagination, $sort, null, null, $select);
    }

    public function timSanPhamTheoTheLoai($params = null, $pagination = null, $sort = null)
    {
        $theLoaiModel = new TheLoai();
        $joins = [
            [
                'databaseName' => 'the_loai as tl',
                'typeJoin' => 'innerJoin',
                'on' => [$this->table . '.the_loai_id' => 'tl.id'],
            ],
            [
                'databaseName' => 'san_pham_chi_tiet as spct',
                'typeJoin' => 'innerJoin',
                'on' => [$this->table . '.id' => 'spct.id_sp'],
            ],
        ];

        $select = DB::raw(
            $this->table . '.*, MIN(spct.gia) as giaThapNhat, MAX(spct.gia) as giaCaoNhat',
        );

        $condition[] = ['column' => 'tl.slug', 'compare' => '=', 'value' => $params['the_loai_slug']];

        if (isset($params['sizes']) && $params['sizes'] != null) {
            $condition[] = ['type' => 'RAW', 'value' => 'spct.size IN (' . $params['sizes'] . ')'];
        }

        if (isset($params['colors']) && $params['colors'] != null) {
            $condition[] = ['type' => 'RAW', 'value' => 'spct.id_mau_sac IN (' . $params['colors'] . ')'];
        }

        $groupBy = DB::raw('san_pham.id, san_pham.ten');

        return AppHelper::findData($this, $condition, 'ALL', $pagination, $sort, null, $joins, $select, $groupBy);
    }

    public function timsanPhamTheoSlug($params)
    {
        $query = $this->query();

        $query->selectRaw(DB::raw(
            $this->table . '.*, MIN(spct.gia) as giaThapNhat, MAX(spct.gia) as giaCaoNhat,
            tl.ten as tenTheLoai, tl.slug as theLoaiSlug',
        ));
        $query->join('san_pham_chi_tiet as spct', 'san_pham.id', '=', 'spct.id_sp');
        $query->join('the_loai as tl', 'san_pham.the_loai_id', '=', 'tl.id');
        $query->groupBy(DB::raw('san_pham.id, san_pham.ten'));
        $query->where('san_pham_slug', $params['san_pham_slug']);

        return $query->first();
    }

    public function theLoai()
    {
        return $this->belongsTo(TheLoai::class, 'the_loai_id', 'id');
    }
}
