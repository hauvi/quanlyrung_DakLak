<?php

namespace App\Models\Dienbien;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loaidb extends Model
{
    use HasFactory;
    protected $table = 'dienbien.loai';
    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã loại',           
            'ten' => 'Tên loại diễn biến',
            'id_nhom' => 'Mã nhóm',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Loại diễn biến'
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
