<?php

namespace App\Models\mucdichsd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phanloaiphu extends Model
{
    use HasFactory;

    protected $table = 'mucdichsd.phanloaiphu';

    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã mục đích sử dụng',
            'ten_viettat' => 'Tên viết tắt',      
            'ten' => 'Tên mục đích sử dụng',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Mục đích sử dụng - Phân loại phụ'
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
