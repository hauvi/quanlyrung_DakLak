<?php

namespace App\Models\Lamnghiep;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phanloaidat extends Model
{
    use HasFactory;

    protected $table = 'lamnghiep.loaidatloairung';

    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã phân loại đất, rừng',
            'ten_viettat' => 'Tên viết tắt loại đất, rừng',
            'ten' => 'Tên gọi loại đất, rừng',
            'truluong_min' => 'Trữ lượng nhỏ nhất',
            'truluong_max' => 'Trữ lượng lớn nhất'
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Phân loại đất, rừng'
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
