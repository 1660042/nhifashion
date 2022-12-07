<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HoaDonSanPham extends Model
{
    use HasFactory;

    protected $table = 'hoa_don_san_pham';
    protected $fillable = [
        'hoa_don_id', 'san_pham_id', 'id_mau_sac', 'size', 'giam_gia', 'so_luong', 'gia', 'thanh_tien',
    ];
    public $timestamps = false;

    public function getHoaDonSanPham($params)
    {
        $query = $this->query();
        $query->join('mau_sac as ms', 'ms.id', '=', 'hoa_don_san_pham.id_mau_sac');
        $query->join('san_pham as sp', 'hoa_don_san_pham.san_pham_id', '=', 'sp.id');
        $query->where('hoa_don_san_pham.hoa_don_id', $params['hoa_don_id']);
        $query->selectRaw('sp.ten, hoa_don_san_pham.so_luong, hoa_don_san_pham.thanh_tien, ms.ten AS mau_sac, hoa_don_san_pham.size, hoa_don_san_pham.gia,(SELECT ten_anh FROM san_pham_hinh_anh spha WHERE spha.id_sp = sp.id LIMIT 1) AS hinh_anh');
        return $query->get();
    }
}
