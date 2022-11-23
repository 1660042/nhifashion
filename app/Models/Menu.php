<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $fillable = ['tenmon', 'mota', 'anh', 'gia', 'idtheloai', 'idth'];

    protected $searchField = [
        'nameSearch' => [
            'value' => null,
            'compare' => 'like',
            'nameDB' => 'tenmon',
        ],
        'categorySearch' => [
            'value' => null,
            'compare' => '=',
            'nameDB' => 'idtheloai',
        ],
        'brandSearch' => [
            'value' => null,
            'compare' => '=',
            'nameDB' => 'idth',
        ],
    ];

    public function search($pageCustom, $sort = null)
    {
        $query = Menu::query();

        foreach ($this->searchField as $field => $data) {
            if ($data['value'] != null && $data['value'] != '') {
                if ($data['compare'] == 'like') {
                    $query->where($data['nameDB'], $data['compare'], '%' . $data['value'] . '%');
                } else {
                    $query->where($data['nameDB'], $data['compare'], $data['value']);
                }
            }
        }

        foreach ($sort as $key => $value) {
            $query->orderBy($key, $value);
        }

        return $query->paginate($pageCustom['numberOnPage'], $pageCustom['columns'], $pageCustom['pageName'], $pageCustom['page']);
    }

    public function loadDataSearch(Request $request)
    {

        foreach ($this->searchField as $field => $data) {
            if ($request->has($field)) {
                $this->searchField[$field]['value'] = $request->$field;
            }
        }
    }

    public function getTheLoai() {
        return $this->belongsTo(TheLoai::class, 'idtheloai', 'id');
    }

    public function getThuongHieu() {
        return $this->belongsTo(ThuongHieu::class, 'idth', 'id');
    }
}
