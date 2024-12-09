<?php

namespace App\Models\Lamnghiep;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doituong extends Model
{
    use HasFactory;

    protected $table = 'lamnghiep.doituong';

    protected $guarded = [];

    // Map tên trường cho bảng 'doituong'
    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã đối tượng',
            'ten_viettat' => 'Tên viết tắt đối tượng',
            'ten' => 'Tên gọi đối tượng',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Đối tượng rừng'
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
