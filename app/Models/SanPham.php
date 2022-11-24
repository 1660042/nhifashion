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
    protected $fillable = ['ten', 'the_loai_id', 'gia', 'gioi_thieu', 'created_by', 'updated_by'];

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
}
