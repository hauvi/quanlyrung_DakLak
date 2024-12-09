<?php

namespace App\Http\Controllers\Congtac;

use App\Http\Controllers\Controller;
use App\Models\Congtac\Kehoachtuantra;
use App\Models\Congtac\Phanloai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KehoachtuantraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Lấy dữ liệu từ request
            $tenKeHoach = $request->input('ten');
            $moTa = $request->input('mota');
            $phanLoai = $request->input('phanloai');
            $ngay = $request->input('ngay');
            $ngaykt = $request->input('ngaykt');
            $tramTuanTra = $request->input('tram');
            $doiTuanTra = $request->input('doi');
            $nhomTruong = $request->input('nhomtruong');
            $thanhVien = $request->input('thanhvien');
            $phuongThucDiChuyen = $request->input('phuongthuc_dichuyen');
            $nhiemVu =  $request->input('nhiemvu');
            $mucTieu = $request->input('muctieu');
            $ghiChu = $request->input('ghichu');
            $geojson = json_decode($request->input('geom'), true); // Lấy dữ liệu GeoJSON và chuyển đổi thành mảng

            // Kiểm tra xem GeoJSON có hợp lệ không
            if (!$geojson || !isset($geojson['geometry']['type']) || !isset($geojson['geometry']['coordinates'])) {
                return response()->json(['status' => 'error', 'message' => 'Dữ liệu hình học không hợp lệ.'], 400);
            }

            // Lấy loại hình học và tọa độ
            $geomType = $geojson['geometry']['type'];
            $coordinates = $geojson['geometry']['coordinates'];

            // Xác định cú pháp ST_GeomFromText dựa trên loại hình học
            $geomText = '';
            switch ($geomType) {
                case 'Point':
                    $geomText = "ST_GeomFromText('POINT(" . implode(' ', $coordinates) . ")', 4326)";
                    break;
                case 'LineString':
                    $geomText = "ST_GeomFromText('LINESTRING(" . implode(',', array_map(function ($point) {
                        return implode(' ', $point);
                    }, $coordinates)) . ")', 4326)";
                    break;
                case 'Polygon':
                    $geomText = "ST_GeomFromText('POLYGON((" . implode(',', array_map(function ($point) {
                        return implode(' ', $point);
                    }, $coordinates[0])) . "))', 4326)";
                    break;
                default:
                    return response()->json(['status' => 'error', 'message' => 'Loại hình học không được hỗ trợ.'], 400);
            }

            // Lưu vào database
            KeHoachTuanTra::create([
                'ten' => $tenKeHoach,
                'mota' => $moTa,
                'phanloai' => $phanLoai,
                'ngay' => $ngay,
                'ngaykt' => $ngaykt,
                'tram' => $tramTuanTra,
                'doi' => $doiTuanTra,
                'nhomtruong' => $nhomTruong,
                'thanhvien' => $thanhVien,
                'phuongthuc_dichuyen' => $phuongThucDiChuyen,
                'nhiemvu' => $nhiemVu,
                'muctieu' => $mucTieu,
                'ghichu' => $ghiChu,
                'geom' => DB::raw($geomText), // Sử dụng ST_GeomFromText để tạo Geometry từ mảng coordinates
            ]);

            // Trả về phản hồi JSON thành công
            return response()->json(['status' => 'success', 'message' => 'Kế hoạch tuần tra đã được lưu thành công.'], 200);
        } catch (\Exception $e) {
            // Bắt lỗi và trả về phản hồi JSON lỗi
            return response()->json(['status' => 'error', 'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kehoachtuantra $kehoachtuantra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kehoachtuantra $kehoachtuantra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kehoachtuantra $kehoachtuantra)
    {
        //
    }
}
