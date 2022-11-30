<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanPhamHinhAnh extends Model
{
    use HasFactory;

    protected $table = 'san_pham_hinh_anh';
    protected $primaryKey = 'id_hinh_anh';
    public $timestamps = false;
    protected $fillable = ['ten_anh', 'id_sp'];

    public function dsHinhAnh($params)
    {
        $joins = [
            [
                'databaseName' => 'san_pham as sp',
                'typeJoin' => 'innerJoin',
                'on' => ['sp.id' => $this->table . '.id_sp'],
            ],
        ];

        $select = DB::raw(
            $this->table . '.*'
        );

        $condition[] = ['column' => 'sp.san_pham_slug', 'compare' => '=', 'value' => $params['san_pham_slug']];

        // $groupBy = DB::raw($this->table . '.size');

        return AppHelper::findData($this, $condition, 'ALL', null, null, null, $joins, $select, null);
    }
}
