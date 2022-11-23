<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'donhang';

    protected $fillable = ['ten', 'diachi', 'idkh'];

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'madonhang', 'id');
    }

    public function khachHang() {
        return $this->belongsTo(User::class, 'idkh', 'id');
    }
}
