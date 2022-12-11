<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TheLoai extends Model
{
    use HasFactory;

    protected $table = 'the_loai';
    protected $fillable = ['ten', 'the_loai_cha_id', 'created_by', 'updated_by', 'slug', 'ten_anh', 'is_show'];

    public function searchData($request, $sort = null, $pagination = null, $typeSearch = 'ALL')
    {

        $joins = [
            [
                'databaseName' =>  'users',
                'typeJoin' => 'innerJoin',
                'on' => [$this->table . '.created_by' => 'users.id'],
            ],
            [
                'databaseName' => $this->table . ' as the_loai_cha',
                'typeJoin' => 'leftJoin',
                'on' => [
                    $this->table . '.the_loai_cha_id' => 'the_loai_cha.id',
                    // 'RAW' => 'the_loai_cha.the_loai_cha_id is not null',
                ],
            ],
        ];

        $select = DB::raw(
            $this->table . '.*, users.ten as nguoiTao,the_loai_cha.ten as the_loai_cha',
        );

        $condition = [];

        if ($request->ten_search !== null) {
            $condition[] = ['column' => 'ten', 'compare' => 'like', 'value' => $request->ten_search];
        }

        return AppHelper::findData($this, $condition, $typeSearch, $pagination, $sort, null, $joins, $select);
    }

    public function dsTheLoaiCha($sort = null)
    {
        $select = [
            $this->table . '.*',
        ];
        $whereRaw = $this->table . '.the_loai_cha_id is null';
        $condition[] = ['type' => 'RAW', 'value' => $whereRaw];

        return AppHelper::findData($this, $condition, 'ALL', null, $sort, null, null, $select);
    }

    public function dsTheLoai($sort = null)
    {
        $select = [
            $this->table . '.*',
        ];

        return AppHelper::findData($this, null, 'ALL', null, $sort, null, null, $select);
    }

    public function timTheLoai($params)
    {

        $condition = [];
        if (isset($params['id'])) {
            $condition[] = ['column' => 'id', 'compare' => '=', 'value' => $params['id']];
        }
        if (count($condition) == 0) return null;
        return AppHelper::findData($this, $condition);
    }

    public function theLoaiCon()
    {
        return $this->hasMany(TheLoai::class, 'the_loai_cha_id', 'id');
    }
}
