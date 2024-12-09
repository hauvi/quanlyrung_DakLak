<?php

namespace App\Models\Tinhtrang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapdia extends Model
{
    use HasFactory;
    protected $table = 'tinhtrang.lapdia';
    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã tình trạng',            
            'ten_viettat' => 'Tên viết tắt',
            'ten' => 'Tình trạng lập địa',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Tình trạng lập địa'
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
