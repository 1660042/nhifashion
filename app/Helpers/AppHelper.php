<?php

namespace App\Helpers;

use DateTime;
use Carbon\Carbon;
use App\Models\MCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cookie;
use Carbon\Exceptions\InvalidFormatException;

class AppHelper
{

    public static function getRules($routeName, $option = [])
    {
        switch ($routeName) {
            case 'backend.the_loai.store':
                return [
                    'ten' => 'bail|required|min:4|max:60|unique:the_loai,ten',
                    'the_loai_cha_id' => 'bail|nullable|integer',
                    'ten_anh' => 'bail|required|image|mimes:jpeg,jpg,png,gif,webp|max:10000',
                ];
                break;
            case 'backend.the_loai.update':
                return [
                    'ten' => 'bail|required|min:4|max:60|unique:the_loai,ten,' . $option['id'],
                    'the_loai_cha_id' => 'bail|nullable|integer',
                    'ten_anh' => 'bail|nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10000',
                ];
                break;
            case 'backend.san_pham.store':
                return [
                    'ten' => 'bail|required|min:4|max:60|unique:san_pham,ten',
                    'the_loai_id' => 'bail|required|integer',
                    'gioi_thieu' => 'bail|nullable|string|max:2000',
                    'mau_sac' => 'bail|required|array',
                    'mau_sac.*' => 'bail|required|integer',
                    'size' => 'bail|required|array',
                    'size.*' => 'bail|required|string',
                    'gia' => 'bail|required|array',
                    'gia.*' => 'bail|required|numeric',
                    'trang_thai' => 'bail|required|array',
                    'trang_thai.*' => 'bail|required|integer',
                    'anh' => 'bail|required|array',
                    'anh.*' => 'bail|required|image|mimes:jpeg,jpg,png,gif,webp|max:10000',
                ];
                break;
            case 'backend.san_pham.update':
                return [
                    'ten' => 'bail|required|min:4|max:60|unique:san_pham,ten,' . $option['id'],
                    'the_loai_id' => 'bail|required|integer',
                    'gioi_thieu' => 'bail|nullable|string|max:2000',
                    'mau_sac' => 'bail|required|array',
                    'mau_sac.*' => 'bail|required|integer',
                    'size' => 'bail|required|array',
                    'size.*' => 'bail|required|string',
                    'gia' => 'bail|required|array',
                    'gia.*' => 'bail|required|numeric',
                    'trang_thai' => 'bail|required|array',
                    'trang_thai.*' => 'bail|required|integer',
                    'anh' => 'bail|nullable|array',
                    'anh.*' => 'bail|nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10000',
                ];
                break;
            case 'backend.don_hang.update':
                return [
                    'ten' => 'bail|required|min:4|max:255',
                    'phuong_thuc_thanh_toan' => 'bail|required|integer|max:9',
                    'sdt' => 'bail|required|numeric',
                    'email' => 'bail|required|email',
                    'dia_chi' => 'bail|required|string|max:255',
                    'xa' => 'bail|required|string|max:60',
                    'huyen' => 'bail|required|string|max:60',
                    'tinh' => 'bail|required|string|max:60',
                    'trang_thai' => 'bail|required|integer|max:9',
                ];
                break;
            case 'frontend.cart.dat_hang':
                return [
                    'hoTen' => 'bail|required|min:4|max:60',
                    'email' => 'bail|required|email',
                    'soDienThoai' => 'bail|required|numeric|digits:10',
                    'diaChi' => 'bail|required|string|max:255',
                    'tinh' => 'bail|required|string|max:60',
                    'huyen' => 'bail|required|string|max:60',
                    'xa' => 'bail|required|string|max:60',
                    'phuong_thuc' => 'bail|required|integer'
                ];
                break;
        }
        return [];
    }

    public static function formatErrors($validator)
    {
        $errors = $validator->errors()->getMessages();
        $obj = $validator->failed();
        $result = [];
        foreach ($obj as $input => $rules) {
            $i = 0;
            foreach ($rules as $rule => $ruleInfo) {
                $rule = $input . '[' . strtolower($rule) . ']';
                $result[$rule] = $errors[$input][$i];
                $i++;
            }
        }
        return $result;
    }

    public static function formatNumber($number, $length = 5, $value = '0', $isLeft = true)
    {
        if ($number === null) {
            return null;
        }

        if ($isLeft)
            return str_pad($number, $length, $value, STR_PAD_LEFT);
        return str_pad($number, $length, $value, STR_PAD_RIGHT);
    }

    public static function getAttributes($routeName)
    {
        switch ($routeName) {
            case 'backend.the_loai.store':
                return [
                    'ten' => 'Tên thể loại',
                    'the_loai_cha_id' => 'Thể loại cha',
                    'ten_anh' => 'Hình ảnh'
                ];
                break;
            case 'backend.the_loai.update':
                return [
                    'ten' => 'Tên thể loại',
                    'the_loai_cha_id' => 'Thể loại cha',
                    'ten_anh' => 'Hình ảnh'
                ];
                break;
            case 'backend.san_pham.store':
                return [
                    'ten' => 'Tên sản phẩm',
                    'the_loai_id' => 'Thể loại',
                    'anh' => 'Hình ảnh',
                    'anh.*' => 'HÌnh ảnh',
                    'gioi_thieu' => 'Giới thiệu',
                    'mau_sac.*' => 'Màu sắc',
                    'size.*' => 'Kích thước',
                    'gia.*' => 'Giá',
                    'trang_thai.*' => 'Trạng thái',
                ];
                break;
            case 'backend.san_pham.update':
                return [
                    'ten' => 'Tên sản phẩm',
                    'the_loai_id' => 'Thể loại',
                    'anh' => 'Hình ảnh',
                    'anh.*' => 'HÌnh ảnh',
                    'gioi_thieu' => 'Giới thiệu',
                    'mau_sac.*' => 'Màu sắc',
                    'size.*' => 'Kích thước',
                    'gia.*' => 'Giá',
                    'trang_thai.*' => 'Trạng thái',
                ];
                break;
            case 'frontend.cart.dat_hang':
                return [
                    'hoTen' => 'Họ tên',
                    'email' => 'Email',
                    'soDienThoai' => 'Số điện thoại',
                    'diaChi' => 'Địa chỉ',
                    'tinh' => 'Tỉnh/Thành phố',
                    'huyen' => 'Quận/Huyện',
                    'xa' => 'Phường/Xã',
                    'phuong_thuc' => 'Phương thức thanh toán'
                ];
                break;
            case 'backend.don_hang.update':
                return [
                    'ten' => 'Tên khách hàng',
                    'phuong_thuc_thanh_toan' => 'Phương thức thanh toán',
                    'sdt' => 'Số điện thoại',
                    'email' => 'Email',
                    'dia_chi' => 'Địa chỉ',
                    'xa' => 'Phường/Xã',
                    'huyen' => 'Quận/Huyện',
                    'tinh' => 'Tỉnh/Thành phố',
                    'trang_thai' => 'Trạng thái đơn hàng',
                ];
                break;
        }
        return [];
    }

    public static function findData(
        $model,
        $params,
        $type = 'ONE',
        $pagination = null,
        $sort = null,
        $relation = null,
        $joins = null,
        $select = null,
        $groupBy = null,
        $having = null,
        $limit = null,
    ) {
        $query =  $model->query();
        $query = self::fillQuery($query, $params);
        //Nếu có relation
        if (is_array($relation)) {
            $with = [];
            foreach ($relation as $nameRelation => $conditionRelation) {
                //Nếu conditionRelation === 0 => chỉ relation nhưng ko check exist (whereHas)
                if ($conditionRelation === 0) {
                    $with[] = $nameRelation;
                } else {
                    $query->withWhereHas($nameRelation, function ($qr) use ($conditionRelation) {
                        $qr = self::fillQuery($qr, $conditionRelation);
                        return $qr;
                    });
                }
            }
            if (count($with) > 0) {
                $query->with($with);
            }
        }

        //Nếu có join
        if (is_array($joins)) {
            foreach ($joins as $key => $join) {
                $onArr = $join['on'];
                $databaseName = $join['databaseName'];
                if ($join['typeJoin'] == 'leftJoin') {
                    $query->leftJoin($join['databaseName'], function ($qJoin) use ($onArr) {
                        foreach ($onArr as $key => $on) {
                            if ($key === 'RAW') {
                                $qJoin->on(DB::raw('(' . $on . ') and 1'), '=', DB::raw('1'));
                                continue;
                            }
                            $qJoin->on($key, '=', $on);
                        }
                    });
                } else if ($join['typeJoin'] == 'innerJoin') {
                    $query->join($join['databaseName'], function ($qJoin) use ($onArr) {
                        foreach ($onArr as $key => $on) {
                            if ($key === 'RAW') {
                                $qJoin->on(DB::raw('(' . $on . ') and 1'), '=', DB::raw('1'));
                                continue;
                            }
                            $qJoin->on($key, '=', $on);
                        }
                    });
                }
                if (isset($join['where'])) {
                    $c = $join['where'];
                    $query->where(function ($q) use ($c, $databaseName) {
                        $q = self::fillQuery($q, $c, $databaseName);
                        return $q;
                    });
                }
            }
        }
        if (is_array($select)) {
            $query->select($select);
        } else if ($select != null && strlen(trim($select)) > 0) {
            $query->selectRaw($select);
        }

        if ($groupBy != null && strlen(trim($groupBy)) > 0) {
            $query->groupBy($groupBy);
        }

        if ($having != null && strlen(trim($having)) > 0) {
            $query->havingRaw($having);
        }

        if ($sort && is_array($sort)) {
            foreach ($sort as $s) {
                $query->orderBy($s['column'], $s['type']);
            }
        }
        if ($type === 'ALL') {
            if ($pagination) {
                return $query->paginate($pagination['item_per_page'], $pagination['columns'], $pagination['page_name'], $pagination['page']);
            }
            return $query->get();
        } else if ($type === 'EXISTS') {
            return $query->exists();
        } else if ($type === 'LIMIT') {
            return $query->take($limit)->get();
        }
        return $query->first();
    }

    private static function fillQuery($query, $params = null, $tableName = null)
    {
        if ($tableName == null) {
            $tableName = $query->getModel()->getTable();
        }
        if (is_array($params)) {
            foreach ($params as $item) {
                if (!isset($item['type'])) {
                    if ($item['value'] !== null && strlen(trim($item['value'])) > 0) {
                        if (strpos($item['column'], '.')) { //TH column truyền vào table.column => cắt ra
                            $temp = explode('.', $item['column']);
                            if ($item['compare'] == 'like') {
                                $query->where($temp[0] . '.' . $temp[1], $item['compare'], '%' . $item['value'] . '%');
                            } else {
                                $query->where($temp[0] . '.' . $temp[1], $item['compare'], $item['value']);
                            }
                        } else {
                            if ($item['compare'] == 'like') {
                                $query->where($tableName . '.' . $item['column'], $item['compare'], '%' . $item['value'] . '%');
                            } else {
                                $query->where($tableName . '.' . $item['column'], $item['compare'], $item['value']);
                            }
                        }
                    }
                } else if ($item['type'] == 'RAW' && $item['value']) {
                    $query->whereRaw($item['value']);
                }
            }
        }
        return $query;
    }

    public static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public static function writeLog($msg, $name, $folder = '')
    {

        if (!$folder) {
            $folder = storage_path('logs');
        }

        if (!is_dir($folder)) {
            mkdir($folder, 0777);
        }

        $filePath = $folder . '/' . $name . '.log';
        if (File::exists($filePath)) {
            $filePath = $folder . '/' . $name . '_' . date("Ymd_His") . '.log';
        }
        $fp = fopen($filePath, 'w');

        $data = '';

        if (is_array($msg)) {
            foreach ($msg as $key => $row) {
                $data .= "\n" . $key .  ": \t" . $row;
            }
            $data .= "\n";
        } else $data = $msg;

        fwrite($fp, $data);
        fclose($fp);
    }

    public static function removeFile($folder, $day = 7)
    {

        try {
            $files = File::allFiles($folder . '/');
            $now = Carbon::now();
            foreach ($files as $file) {
                $lastModified = File::lastModified($file);
                $dateFile = Carbon::parse($lastModified);
                if ($dateFile->isPast() && $dateFile->diffInDays($now) > $day) { //Neu ngay cua file là quá khứ và cách hơn 7 ngày so với hôm nay
                    File::delete($file);
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public static function cleanOldFile($dir)
    {
        $interval = strtotime('-2 day');
        foreach (glob($dir . "/*") as $file) {
            if (filemtime($file) <= $interval) unlink($file);
        }
    }
}
