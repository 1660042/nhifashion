<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;

    protected $table = 'chitietdonhang';

    public $timestamps = false;
    
    protected $fillable = ['madonhang', 'mamonan', 'tenmonan', 'giatien', 'soluong'];
}
