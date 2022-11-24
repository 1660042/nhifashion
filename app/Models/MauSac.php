<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MauSac extends Model
{
    use HasFactory;

    protected $table = 'mau_sac';
    protected $fillable = ['ten'];

    public function dsMauSac($sort = null)
    {
        $select = [
            $this->table . '.id',
            $this->table . '.ten',
        ];

        return AppHelper::findData($this, null, 'ALL', null, $sort, null, null, $select);
    }
}
