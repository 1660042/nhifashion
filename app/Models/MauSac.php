<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MauSac extends Model
{
    use HasFactory;

    protected $table = 'mau_sac';
    protected $fillable = ['ten'];

    public function dsMauSac($sort = null)
    {
        $select = [
            $this->table . '.id',
            $this->table . '.ten',
        ];

        return AppHelper::findData($this, null, 'ALL', null, $sort, null, null, $select);
    }

    public function dsMauSacCuaSanPham($params)
    {
        $joins = [
            [
                'databaseName' => 'san_pham_chi_tiet as spct',
                'typeJoin' => 'innerJoin',
                'on' => [$this->table . '.id' => 'spct.id_mau_sac'],
            ],
            [
                'databaseName' => 'san_pham as sp',
                'typeJoin' => 'innerJoin',
                'on' => ['sp.id' => 'spct.id_sp'],
            ],
        ];

        $select = DB::raw(
            $this->table . '.id, ' . $this->table  . '.ten,' . $this->table . '.code'
        );

        $condition[] = ['column' => 'sp.san_pham_slug', 'compare' => '=', 'value' => $params['san_pham_slug']];

        $groupBy = DB::raw($this->table . '.id, ' . $this->table  . '.ten,' . $this->table . '.code');

        return AppHelper::findData($this, $condition, 'ALL', null, null, null, $joins, $select, $groupBy);
    }
}
