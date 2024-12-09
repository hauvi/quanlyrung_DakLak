<?php

namespace App\Models\Tinhtrang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tranhchap extends Model
{
    use HasFactory;
    protected $table = 'tinhtrang.tranhchap';
    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã tình trạng',           
            'tinhtrang' => 'Tình trạng tranh chấp',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Tình trạng tranh chấp'
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
