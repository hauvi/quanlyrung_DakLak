<?php

namespace App\Models\Lamnghiep;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biendongrung extends Model
{
    use HasFactory;
    protected $table = 'lamnghiep.biendong_dtrung';
    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã biến động diện tích rừng',
            'madienbien' => 'Mã diễn biến biến động rừng',
            'maldlr_tbd' => 'Mã loại đất, rừng trước biến động',
            'thoigianbd' => 'Thời gian thay đổi',
            'tenlomoi' => 'Tên lô mới',
            'malomoi' => 'Mã lô mới',
            'maldlr_sbd' => 'Mã loại đất, rừng sau biến động',
            'dientichbd' => 'Diện tích biến động',
            'loaicay' => 'Giống cây',
            'namtrong' => 'Năm trồng',
            'malr3' => 'Mã mục đích sử dụng, phân loại chính',
            'ghichu' => 'Ghi chú',
            'nguonvt' => 'Nguồn ảnh vệ tinh'
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Biến động Diện tích rừng'
        ];
    }

    public static function getData()
    {
        $columns = array_keys(self::getFieldNameMap()); // Sử dụng tên trường từ map
        $geojsonData = self::select($columns)->paginate(15);

        return [
            'data' => $geojsonData,
            'field_names' => self::getFieldNameMap(),
            'table_name' => self::tableName()
        ];
    }
}
