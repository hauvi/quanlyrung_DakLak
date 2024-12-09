<?php

namespace App\Http\Controllers\API\Geom;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class RghuyenController extends Controller
{
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy dữ liệu từ bảng rghuyen
        $data = DB::table('public.rghuyen')
            ->select(DB::raw('ST_AsGeoJSON(geom) as geom'), 'id', 'tenhuyen', 'mahuyen')  // Cải thiện cho đúng cấu trúc GeoJSON
            ->get();

        // Chuyển đổi dữ liệu thành định dạng GeoJSON
        $features = $data->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->id,
                    'tenhuyen' => $item->tenhuyen,
                    'mahuyen' => $item->mahuyen
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
