<?php

namespace App\Http\Controllers;

use App\Models\DataModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\select;

class ApiController extends Controller
{

    public function getdata($table)
    {
        // Kiểm tra nếu bảng tồn tại
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        // Tạo một instance của DataModel
        $model = new DataModel();
        $model->setTableName($table);

        // Lấy danh sách các cột trong bảng, ngoại trừ cột geom
        $columns = Schema::getColumnListing($table);
        $columns = array_diff($columns, ['geom']);

        // Lấy tất cả dữ liệu từ bảng động
        $data = $model->newQuery()->select($columns)->paginate(10);
        return response()->json($data);
    }

    public function getgeom($table)
    {
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table not found'], 404);
        }
        $model = new DataModel();
        $model->setTableName($table);
        $geojsonData = $model->newQuery()->selectRaw('ST_AsGeoJSON(geom) as geom')->get();
        // Chuyển đổi chuỗi JSON thành đối tượng PHP
        $features = [];
        foreach ($geojsonData as $data) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($data->geom),
                'properties' => [], // Các thuộc tính có thể thêm vào nếu cần
            ];
            $features[] = $feature;
        }

        // Định dạng dữ liệu theo GeoJSON
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        return response()->json($geojson);
    }
}
