<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Models\HoaDonSanPham;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'hoa_don';
    protected $fillable = [
        'id',
        'user_id',
        'ten',
        'sdt',
        'email',
        'dia_chi',
        'phuong_thuc_thanh_toan',
        'tinh',
        'huyen',
        'xa',
    ];


    public function searchData($request = null, $sort = null, $pagination = null)
    {
        $joins = null;
        // $joins = [
        //     [
        //         'databaseName' =>  'users',
        //         'typeJoin' => 'innerJoin',
        //         'on' => [$this->table . '.created_by' => 'users.id'],
        //     ],
        //     [
        //         'databaseName' => $this->table . ' as the_loai_cha',
        //         'typeJoin' => 'leftJoin',
        //         'on' => [
        //             $this->table . '.id' => 'the_loai_cha.id',
        //             'RAW' => 'the_loai_cha.the_loai_cha_id is not null',
        //         ],
        //     ],
        // ];

        $relations = ['hoaDonSanPham' => 0];

        $select = DB::raw(
            $this->table . '.*',
        );

        $condition = [];

        // if ($request->ten_search !== null) {
        //     $condition[] = ['column' => 'ten', 'compare' => 'like', 'value' => $request->ten_search];
        // }

        return AppHelper::findData($this, $condition, 'ALL', $pagination, $sort, $relations, $joins, $select);
    }


    public function hoaDonSanPham()
    {
        return $this->hasMany(HoaDonSanPham::class, 'hoa_don_id', 'id');
    }
}
