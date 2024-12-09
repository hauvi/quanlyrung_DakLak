<?php

namespace App\Models\Dienbien;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nhomdb extends Model
{
    use HasFactory;
    protected $table = 'dienbien.nhom';
    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã nhóm',           
            'ten' => 'Tên nhóm diễn biến',
            'id_huong' => 'Mã hướng'
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu nhóm diễn biến'
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
