<?php

namespace App\Models\Nguongoc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rungtrong extends Model
{
    use HasFactory;

    protected $table = 'nguongoc.rungtrong';

    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã nguồn gốc rừng trồng',           
            'ten' => 'Tên gọi nguồn gốc rừng trồng',
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Nguồn gốc rừng trồng'
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
