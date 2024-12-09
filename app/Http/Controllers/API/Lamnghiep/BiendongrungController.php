<?php

namespace App\Http\Controllers\API\Lamnghiep;

use App\Http\Controllers\Controller;
use App\Models\Lamnghiep\Biendongrung;
use Illuminate\Http\Request;

class BiendongrungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Biendongrung::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'madienbien' => 'required|integer',
            'maldlr_tbd' => 'required|integer',
            'thoigianbd' => 'required|string|max:255',
            'tenlomoi' => 'required|string|max:255',
            'malomoi' => 'required|string|max:255',
            'maldlr_sbd' => 'required|string|max:255',
            'dientichbd' => 'required|double',
            'loaicay' => 'required|string|max:255',
            'namtrong' => 'required|integer',
            'malr3' => 'required|integer',
            'ghichu'  => 'required|string|max:255',
            'nguonvt'  => 'required|string|max:255'
        ]);

        // Tạo đối tượng mới
        $new_data = Biendongrung::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Biendongrung $biendong_dtrung)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Biendongrung::getFieldNameMap();
        $tableName = Biendongrung::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $biendong_dtrung,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Biendongrung $biendong_dtrung)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'madienbien' => 'required|integer',
            'maldlr_tbd' => 'required|integer',
            'thoigianbd' => 'required|string|max:255',
            'tenlomoi' => 'required|string|max:255',
            'malomoi' => 'required|string|max:255',
            'maldlr_sbd' => 'required|string|max:255',
            'dientichbd' => 'required|double',
            'loaicay' => 'required|string|max:255',
            'namtrong' => 'required|integer',
            'malr3' => 'required|integer',
            'ghichu'  => 'required|string|max:255',
            'nguonvt'  => 'required|string|max:255'
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $biendong_dtrung->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $biendong_dtrung
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Biendongrung $biendong_dtrung)
    {
        // Xóa đối tượng
        $biendong_dtrung->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
