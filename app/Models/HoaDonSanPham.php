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
        'hoa_don_id', 'san_pham_chi_tiet_id', 'so_luong', 'thanh_tien',
    ];
    public $timestamps = false;
}
