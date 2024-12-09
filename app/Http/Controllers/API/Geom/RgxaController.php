<?php

namespace App\Http\Controllers\API\Geom;

use App\Http\Controllers\Controller;
use App\Models\Geom\Rgxa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RgxaController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Lấy giá trị mahuyen từ query string, nếu không có giá trị thì để null
        $mahuyen = $request->query('mahuyen');

        // Lấy dữ liệu từ bảng rghuyen
        $query = DB::table('public.rgxa')
            ->select(DB::raw('ST_AsGeoJSON(geom) as geom'), 'id', 'tenxa', 'tenhuyen', 'maxa', 'mahuyen');

        // Nếu có truyền mã huyện, thêm điều kiện where
        if ($mahuyen) {
            $query->where('mahuyen', $mahuyen);
        }

        // Thực hiện truy vấn và lấy dữ liệu
        $data = $query->get();

        // Chuyển đổi dữ liệu thành định dạng GeoJSON
        $features = $data->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->id,
                    'tenxa' => $item->tenxa,
                    'tenhuyen' => $item->tenhuyen,
                    'maxa' => $item->maxa,
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Rgxa $rgxa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rgxa $rgxa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rgxa $rgxa)
    {
        //
    }
}
