<?php

namespace App\Models\Geom;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Dubaochay extends Model
{
    use HasFactory;

    protected $table = 'lamnghiep.dubaochay';

    protected $guarded = [];

    public static function getFieldNameMap()
    {
        return [
            'id' => 'Mã dự báo',
            'tentinh' => 'Tên tỉnh',
            'tenhuyen' => 'Tên huyện',
            'nhietdo' => 'Nhiệt độ (℃)',
            'doam' => 'Độ ẩm (%)',
            'luongmua' => 'Lương mưa (mm)',
            'capdubao' => 'Cấp dự báo',
            'ngay' => 'Ngày dự báo'
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Dự báo điểm cháy'
        ];
    }

    public static function getData($ngay = null)
    {
        $columns = array_keys(self::getFieldNameMap()); // Lấy các trường từ map

        // Lấy tất cả dữ liệu và join với bảng rghuyen
        $query = self::join('public.rghuyen', 'lamnghiep.dubaochay.tenhuyen', '=', 'public.rghuyen.tenhuyen')
    ->select(array_merge(
        // Chỉ định bảng cho mỗi cột để tránh xung đột
        array_map(fn($col) => 'lamnghiep.dubaochay.' . $col, $columns),
        [DB::raw('ST_AsGeoJSON(public.rghuyen.geom) as geom')]
    ));

     // Nếu có truyền ngày, lọc dữ liệu theo ngày
     if ($ngay) {
        $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $ngay)->format('d/m/Y');
        $query->whereRaw("TO_CHAR(TO_TIMESTAMP(ngay, 'HH24:MI:SS DD/MM/YYYY'), 'DD/MM/YYYY') = ?", [$formattedDate]);
    }

        // Chuyển đổi dữ liệu thành định dạng GeoJSON
        $features = $query->get()->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->id,
                    'tenhuyen' => $item->tenhuyen,
                    'nhietdo' => $item->nhietdo,
                    'doam' => $item->doam,
                    'luongmua' => $item->luongmua,
                    'capdubao' => $item->capdubao,
                    'ngay' => $item->ngay
                ],
            ];
        });

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features->toArray(),
        ];

        /* return [
            'data' => $geojson,
            'field_names' => self::getFieldNameMap(),
            'table_name' => self::tableName()
        ]; */
        return response()->json($geojson);
    }
}
