<?php

namespace App\Models\Mucdichsd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phanloaichinh extends Model
{
    use HasFactory;

    protected $table = 'mucdichsd.phanloaichinh';

    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã mục đích sử dụng',           
            'ten' => 'Tên mục đích sử dụng',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Mục đích sử dụng - Phân loại chính'
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
