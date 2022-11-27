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
}
