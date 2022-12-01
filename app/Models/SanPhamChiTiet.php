<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanPhamChiTiet extends Model
{
    use HasFactory;

    protected $table = 'san_pham_chi_tiet';
    protected $primaryKey = 'id_sp_chi_tiet';
    public $timestamps = false;
    protected $fillable = ['id_mau_sac', 'id_sp', 'size', 'trang_thai'];

    public function dsSize()
    {
        $query = $this->query();
        $query->select("size");
        $query->groupBy("size");
        return $query->get();
    }

    public function dsSizeTheoSanPham($params)
    {
        $joins = [
            [
                'databaseName' => 'san_pham as sp',
                'typeJoin' => 'innerJoin',
                'on' => ['sp.id' => $this->table . '.id_sp'],
            ],
        ];

        $select = DB::raw(
            $this->table . '.size, GROUP_CONCAT(DISTINCT ' . $this->table . '.id_mau_sac) list_mau'
        );

        $condition[] = ['column' => 'sp.san_pham_slug', 'compare' => '=', 'value' => $params['san_pham_slug']];

        $groupBy = DB::raw($this->table . '.size');

        return AppHelper::findData($this, $condition, 'ALL', null, null, null, $joins, $select, $groupBy);
    }

    public function mauSac()
    {
        return $this->belongsTo(MauSac::class, 'id_mau_sac', 'id');
    }
}
