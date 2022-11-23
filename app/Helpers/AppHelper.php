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
            case 'the_loai.store':
                return [
                    'ten' => 'bail|required|min:4|max:60|unique:the_loai,ten',
                    'the_loai_cha_id' => 'bail|nullable|integer'
                ];
                break;
            case 'the_loai.update':
                return [
                    'ten' => 'bail|required|min:4|max:60|unique:the_loai,ten,' . $option['id'],
                    'the_loai_cha_id' => 'bail|nullable|integer'
                ];
                break;
            case 'customer.store':
                return [
                    'customer_id' => [
                        'bail', 'required', 'regex:/^[a-zA-Z0-9]+$/', 'max:20', 'unique:' . config('constants.mCustomer') . ',customer_id,NULL,customer_id,company_id,' . Auth::user()->company_id . ',delete_flg,' . $cfDeleteFlg['ACTIVE']
                    ],
                    'link_id' => [
                        'bail', 'nullable', 'regex:/^[a-zA-Z0-9]+$/', 'max:20', 'unique:' . config('constants.mCustomer') . ',link_id,NULL,customer_id,company_id,' . Auth::user()->company_id . ',delete_flg,' . $cfDeleteFlg['ACTIVE']
                    ],
                    'office_id' => 'bail|required|integer|between:0,9999|exists:' . config('constants.mOffice') . ',office_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id,
                    'customer_name' => 'bail|required|string|max:60',
                    'customer_kana' => 'bail|nullable|string|max:60',
                    // 'customer_kana' => ['bail', 'nullable', 'regex:/^[\0-9\x{30A0}-\x{30FF}\s]*$/u', 'max:60'],
                    'valve_status' => 'bail|nullable|integer|between:0,9',
                    'customer_zip' => ['bail', 'nullable', 'regex:/^[0-9-]{0,8}+$/'],
                    'customer_addr' => 'bail|nullable|string|max:60',
                    'customer_tel' => ['bail', 'nullable', 'regex:/^[0-9-]{0,15}+$/'],
                    'vendor_id' => 'bail|required|integer|exists:' . config('constants.tComVendor') . ',vendor_id,company_id,' . Auth::user()->company_id,
                    'meter_no' => 'bail|nullable|string|max:15',
                    'unit_id' => 'bail|nullable|string|max:20|exists:' . config('constants.mDevice') . ',unit_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id . '|unique:' . config('constants.mCustomer') . ',unit_id,NULL,customer_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id,
                    'information_status' => 'bail|in:0,1,9|integer',
                    'monthly_inspection_date' => 'bail|nullable|integer|between:1,31',
                    'customer_memo' => 'bail|nullable|string',
                ];
                break;
            case 'customer.update':
                return [
                    'customer_id' => [
                        'bail', 'required', 'regex:/^[a-zA-Z0-9]+$/', 'max:20',
                    ],
                    'link_id' => [
                        'bail', 'nullable', 'regex:/^[a-zA-Z0-9]+$/', 'max:20', 'unique:' . config('constants.mCustomer') . ',link_id,' . $id . ',customer_id,company_id,' . Auth::user()->company_id . ',delete_flg,' . $cfDeleteFlg['ACTIVE']
                    ],
                    'office_id' => 'bail|required|integer|between:0,9999|exists:' . config('constants.mOffice') . ',office_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id,
                    'customer_name' => 'bail|nullable|string|max:60',
                    'customer_kana' => 'bail|nullable|string|max:60',
                    // 'customer_kana' => ['bail', 'nullable', 'regex:/^[\0-9\x{30A0}-\x{30FF}\s]*$/u', 'max:60'],
                    'valve_status' => 'bail|nullable|integer|between:0,9',
                    'customer_zip' => ['bail', 'nullable', 'regex:/^[0-9-]{0,8}+$/'],
                    'customer_addr' => 'bail|nullable|string|max:60',
                    'customer_tel' => ['bail', 'nullable', 'regex:/^[0-9-]{0,15}+$/'],
                    'vendor_id' => 'bail|required|integer|exists:' . config('constants.tComVendor') . ',vendor_id,company_id,' . Auth::user()->company_id,
                    'meter_no' => 'bail|nullable|string|max:15',
                    'unit_id' => 'bail|nullable|string|max:20|exists:' . config('constants.mDevice') . ',unit_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id . '|unique:' . config('constants.mCustomer') . ',unit_id,' . $id . ',customer_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id,
                    'information_status' => 'bail|in:0,1,9|integer',
                    'monthly_inspection_date' => 'bail|nullable|integer|between:1,31',
                    'customer_memo' => 'bail|nullable|string',
                ];
                break;
            case 'customer.set-request':
                return [
                    'customer_id' => [
                        'bail', 'required', 'regex:/^[a-zA-Z0-9]+$/', 'max:20',
                    ],
                    'input_request' => 'bail|required|string',
                    'uuid' => 'bail|required|string',
                ];
                break;
            case 'device.store':
                return [
                    'unit_id' => 'bail|required|string|min:11|max:20|unique:' . config('constants.mDevice') . ',unit_id,NULL,unit_id',
                    'office_id' => 'bail|required|integer|between:0,9999|exists:' . config('constants.mOffice') . ',office_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id,
                    'product_name' => 'bail|nullable|string|max:50',
                    'model' => 'bail|nullable|string|max:20',
                    'sim_id' => 'bail|nullable|string|max:20',
                    'production_date' => 'bail|nullable|date',
                    'acceptance_date' => 'bail|nullable|date',
                    'abolished_date' => 'bail|nullable|date',
                    'device_memo' => 'bail|string|max:2000|nullable',
                ];
                break;
            case 'device.update':
                return [
                    'unit_id' => 'bail|required|string|min:11|max:20|unique:m_device,unit_id,' . $id . ',unit_id',
                    'office_id' => 'bail|required_unless:roll_code,' . config('constants.roll_code.MEMBER.value') . '|integer|between:0,9999|exists:' . config('constants.mOffice') . ',office_id,delete_flg,' . $cfDeleteFlg['ACTIVE'] . ',company_id,' . Auth::user()->company_id,
                    'product_name' => 'bail|nullable|string|max:50',
                    'model' => 'bail|nullable|string|max:20',
                    'sim_id' => 'bail|nullable|string|max:20',
                    'production_date' => 'bail|nullable|date',
                    'acceptance_date' => 'bail|nullable|date',
                    'abolished_date' => 'bail|nullable|date',
                    'device_memo' => 'bail|string|max:2000|nullable',
                ];
                break;
            case 't_com_vendor.create':
                return [
                    'company_id' => 'bail|required|numeric|between:1,99999',
                    'vendor_id' => 'bail|required|integer|between:0,99999',
                ];
                break;
            case 't_com_vendor.store':
                $cfRequestMethod = config('constants.request_method');
                return [
                    'company_id' => 'bail|required|numeric|between:1,99999|exists:' . config('constants.mCompany') . ',company_id',
                    'vendor_id' => 'bail|required|integer|exists:' . config('constants.mVendor') . ',vendor_id|unique:' . config('constants.tComVendor') . ',vendor_id,NULL,id,company_id,' . $id_2,
                    'memo' => 'bail|nullable|string|max:200',

                    'api_key_name' => 'bail|nullable|string|max:40|required_if:request_method,' . $cfRequestMethod['API']['value'],
                    'api_key_value' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['API']['value'],
                    'api_url' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['API']['value'],

                    'send_path' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'receive_path' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'ftp_user' => 'bail|nullable|string|max:40|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'ftp_password' => 'bail|nullable|string|max:40|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'client_id' => 'bail|nullable|string|max:20',
                    'password' => 'bail|nullable|string|max:20',
                ];
                break;
            case 't_com_vendor.update':
                $cfRequestMethod = config('constants.request_method');
                return [
                    'memo' => 'bail|nullable|string|max:200',

                    'api_key_name' => 'bail|nullable|string|max:40|required_if:request_method,' . $cfRequestMethod['API']['value'],
                    'api_key_value' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['API']['value'],
                    'api_url' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['API']['value'],

                    'send_path' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'receive_path' => 'bail|nullable|string|max:200|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'ftp_user' => 'bail|nullable|string|max:40|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'ftp_password' => 'bail|nullable|string|max:40|required_if:request_method,' . $cfRequestMethod['FTP']['value'],
                    'client_id' => 'bail|nullable|string|max:20',
                    'password' => 'bail|nullable|string|max:20',
                    'active_flag' => 'bail|nullable|integer|between:0,1',
                ];
                break;
            case 'company.check-company':
                return [
                    'company_id' => 'bail|required|numeric|between:1,99999',
                ];
                break;
            case 'company.edit':
                return [
                    'company_id' => 'bail|required|numeric|between:1,99999',
                ];
                break;
            case 'company.update':
                return [
                    'company_id' => 'bail|required|numeric|between:1,99999',
                    // 'company_kana' => 'bail|required|string|max:50',
                    'company_zip' => ['bail', 'required', 'regex:/^[0-9-]{0,8}+$/'],
                    'company_addr' => 'bail|required|string|max:60',
                    'company_tel' => ['bail', 'required', 'regex:/^[0-9-]{0,15}+$/'],
                    'company_fax' => ['bail', 'nullable', 'regex:/^[0-9-]{0,15}+$/'],
                    // 'company_email' => 'bail|nullable|email|max:80',
                    // 'contract_from' => 'bail|nullable|date',
                    // 'contract_to' => 'bail|nullable|date',
                    'company_memo' => 'bail|nullable|string|max:2000',
                ];
                break;
            case 'office.store':
                return [
                    'office_id' => 'bail|required|integer|between:0,9999|unique:' . config('constants.mOffice') . ',office_id,NULL,office_id,company_id,' . Auth::user()->company_id,
                    'office_name' => 'bail|required|string|max:60',
                    // 'office_kana' => ['bail', 'nullable', 'regex:/^[\0-9\x{30A0}-\x{30FF}\s]*$/u', 'max:60'],
                    'office_kana' => 'bail|nullable|string|max:60',
                    'office_zip' => ['bail', 'nullable', 'regex:/^[0-9-]{0,8}+$/'],
                    'office_addr' => 'bail|nullable|string|max:60',
                    'office_tel' => ['bail', 'nullable', 'regex:/^[0-9-]{0,15}+$/'],
                    'office_fax' => ['bail', 'nullable', 'regex:/^[0-9-]{0,15}+$/'],
                    'office_memo' => 'bail|nullable|string|max:2000',
                    'delete_flg' => 'bail|required|integer|digits_between:0,1',
                ];
                break;
            case 'office.delete':
                return [
                    'office_id' => 'bail|required|integer|between:0,9999',
                ];
            case 'office.edit':
                return [
                    'office_id' => 'bail|required|integer|between:0,9999',
                ];
                break;
            case 'office.search':
                return [
                    'office_id' => 'bail|nullable|integer',
                ];
                break;
            case 'office.update':
                return [
                    'office_id' => 'bail|required|integer|between:0,9999',
                    'office_name' => 'bail|required|string|max:60',
                    // 'office_kana' => ['bail', 'nullable', 'regex:/^[\0-9\x{30A0}-\x{30FF}\s]*$/u', 'max:60'],
                    'office_kana' => 'bail|nullable|string|max:60',
                    'office_zip' => ['bail', 'nullable', 'regex:/^[0-9-]{0,8}+$/'],
                    'office_addr' => 'bail|nullable|string|max:60',
                    'office_tel' => ['bail', 'nullable', 'regex:/^[0-9-]{0,15}+$/'],
                    'office_fax' => ['bail', 'nullable', 'regex:/^[0-9-]{0,15}+$/'],
                    'office_memo' => 'bail|nullable|string|max:2000',
                    'delete_flg' => 'bail|required|integer|digits_between:0,1',
                ];
                break;
            case 'crontab_customer_request_api_3':
                return [
                    'customer_id' => [
                        'bail', 'nullable', 'regex:/^[a-zA-Z0-9]+$/', 'max:20'
                    ],
                    'usage_amount' => 'bail|nullable|numeric|between:0,99999999',
                    'date' => 'bail|required|date_format:Y-m-d H:i:s',
                    'values' => 'bail|required|numeric|between:0,99999999',
                    'prev_date' => 'bail|nullable|date_format:Y-m-d H:i:s',
                    'prev_values' => 'bail|nullable|numeric|between:0,99999999',
                    'number_decimal' => 'bail|nullable|integer|max:9',
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
            case 'the_loai.store':
                return [
                    'ten' => 'Tên thể loại',
                    'the_loai_cha_id' => 'Thể loại cha'
                ];
                break;
            case 'the_loai.update':
                return [
                    'ten' => 'Tên thể loại',
                    'the_loai_cha_id' => 'Thể loại cha'
                ];
                break;
        }
        return [];
    }

    public static function findData($model, $params, $type = 'ONE', $pagination = null, $sort = null, $relation = null, $joins = null, $select = null, $groupBy = null, $having = null)
    {
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
