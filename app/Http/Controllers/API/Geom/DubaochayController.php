<?php

namespace App\Http\Controllers\API\Geom;

use App\Http\Controllers\Controller;
use App\Imports\DubaochayImport;
use App\Models\Geom\Dubaochay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DubaochayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy ngày mới nhất từ bảng dubaochay
        $latestDate = DB::table('lamnghiep.dubaochay')
            ->select(DB::raw('MAX(TO_TIMESTAMP(ngay, \'HH24:MI:SS DD/MM/YYYY\')) as latest_date'))
            ->pluck('latest_date')
            ->first();

        // Lấy dữ liệu cho ngày mới nhất và join với bảng rghuyen
        $geojsonData = DB::table('lamnghiep.dubaochay')
            ->join('public.rghuyen', 'lamnghiep.dubaochay.tenhuyen', '=', 'public.rghuyen.tenhuyen')
            ->whereRaw("TO_TIMESTAMP(ngay, 'HH24:MI:SS DD/MM/YYYY') = ?", [$latestDate])
            ->select(
                'lamnghiep.dubaochay.id',
                'lamnghiep.dubaochay.tenhuyen',
                'lamnghiep.dubaochay.nhietdo',
                'lamnghiep.dubaochay.doam',
                'lamnghiep.dubaochay.luongmua',
                'lamnghiep.dubaochay.capdubao',
                'lamnghiep.dubaochay.ngay',
                DB::raw("TO_CHAR(TO_TIMESTAMP(ngay, 'HH24:MI:SS DD/MM/YYYY'), 'DD/MM/YYYY') as ngay"),
                DB::raw('ST_AsGeoJSON(public.rghuyen.geom) as geom')
            )->get();

        // Chuyển đổi dữ liệu thành định dạng GeoJSON
        $features = $geojsonData->map(function ($item) {
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

        // Trả về JSON đơn giản
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
    public function show($ngay)
    {
        // Lấy dữ liệu cho ngày mới nhất và join với bảng rghuyen
        $query = DB::table('lamnghiep.dubaochay')
            ->join('public.rghuyen', 'lamnghiep.dubaochay.tenhuyen', '=', 'public.rghuyen.tenhuyen')
            ->select(
                'lamnghiep.dubaochay.id',
                'lamnghiep.dubaochay.tenhuyen',
                'lamnghiep.dubaochay.nhietdo',
                'lamnghiep.dubaochay.doam',
                'lamnghiep.dubaochay.luongmua',
                'lamnghiep.dubaochay.capdubao',
                'lamnghiep.dubaochay.ngay',
                DB::raw("TO_CHAR(TO_TIMESTAMP(ngay, 'HH24:MI:SS DD/MM/YYYY'), 'DD/MM/YYYY') as ngay"),
                DB::raw('ST_AsGeoJSON(public.rghuyen.geom) as geom')
            );

        $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $ngay)->format('d/m/Y');
        $query->whereRaw("TO_CHAR(TO_TIMESTAMP(ngay, 'HH24:MI:SS DD/MM/YYYY'), 'DD/MM/YYYY') = ?", [$formattedDate]);

        // Thực hiện truy vấn và lấy dữ liệu
        $data = $query->get();

        // Chuyển đổi dữ liệu thành định dạng GeoJSON
        $features = $data->map(function ($item) {
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

        // Trả về JSON đơn giản
        return response()->json($geojson);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dubaochay $dubaochay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dubaochay $dubaochay)
    {
        //
    }

    public function showImportForm()
    {
        return view('import'); // Tạo view cho form upload
    }

    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv', // Kiểm tra định dạng file
        ]);

        $file = $request->file('file');

        // Sử dụng lớp import để xử lý file và lấy dữ liệu
        $data = Excel::toArray(new DubaochayImport, $file);

        return response()->json($data); // Trả về dữ liệu dưới dạng JSON
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv', // Kiểm tra định dạng file
        ]);

        $file = $request->file('file');

        try {
            // Import dữ liệu sử dụng DubaochayImport
            Excel::import(new DubaochayImport, $file);

            // Gửi response thành công
            return response()->json(['success' => 'Dữ liệu đã được nhập thành công!']);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json(['error' => 'Đã xảy ra lỗi khi import dữ liệu: ' . $e->getMessage()], 500);
        }
    }
}
