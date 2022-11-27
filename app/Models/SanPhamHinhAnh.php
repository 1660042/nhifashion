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
}
