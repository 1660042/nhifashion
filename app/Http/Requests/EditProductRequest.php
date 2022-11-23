<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tenmon' => 'required|unique:menu,tenmon,' . $this->id,
            'mota' => 'required|string|max:255',
            'gia' => 'required|numeric',
            'idtheloai' => 'required|numeric',
            'idth' => 'required|numeric',
            'anh' => 'required|image|mimes:jpge,png,jpg|mimetypes:image/jpeg,image/png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống!',
            'idtheloai.required' => 'Vui lòng chọn :attribute!',
            'idth.required' => 'Vui lòng chọn :attribute!',
            'numeric' => ':attribute phải là kiểu số!',
            'unique' => ':attribute đã tồn tại!',
            'string' => ':attribute phải là kiểu chuỗi!',
            'anh.image' => ':attribute phải là file ảnh!',
            'anh.mimes' => ':attribute phải là kiểu jpge hoặc png!',
            'anh.mimetypes' => ':attribute phải có chuẩn image/jpeg hoặc image/png!',
            'anh.max' => ':attribute có kích thước không được vượt quá 2048 kilobytes!',
        ];
    }

    public function attributes()
    {
        return [
            'tenmon' => 'Tên món ăn',
            'mota' => 'Mô tả',
            'gia' => 'Giá bán',
            'idtheloai' => 'thể loại',
            'idth' => 'thương hiệu',
            'anh' => 'Hình ảnh'
        ];
    }
}
