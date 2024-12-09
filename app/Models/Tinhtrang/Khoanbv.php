<?php

namespace App\Models\Tinhtrang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoanbv extends Model
{
    use HasFactory;
    protected $table = 'tinhtrang.khoanbaoverung';
    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã tình trạng',           
            'tinhtrang' => 'Tình trạng khoán',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Khoán bảo vệ rừng'
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
