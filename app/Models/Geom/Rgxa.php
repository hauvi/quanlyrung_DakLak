<?php

namespace App\Models\Geom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rgxa extends Model
{
    use HasFactory;
    protected $table = 'public.rgxa';
    protected $guard = [];
    public static function getGeoJsonData()
    {
        // Lấy dữ liệu từ bảng rghuyen
        $data = DB::table('public.rgxa')
            ->select(DB::raw('ST_AsGeoJSON(geom) as geom'), 'id', 'tenxa')  // Cải thiện cho đúng cấu trúc GeoJSON
            ->get();

        // Chuyển đổi dữ liệu thành định dạng GeoJSON
        $features = $data->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->id,
                    'tenxa' => $item->tenxa,
                ],
            ];
        });

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features->toArray(),
        ];

        return response()->json($geojson);
    }
}
