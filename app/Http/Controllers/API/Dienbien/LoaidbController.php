<?php

namespace App\Http\Controllers\API\Dienbien;

use App\Http\Controllers\Controller;
use App\Models\Dienbien\Loaidb;
use Illuminate\Http\Request;

class LoaidbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Loaidb::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'id_nhom' => 'required|integer'
        ]);

        // Tạo đối tượng mới
        $new_data = Loaidb::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loaidb $loai)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Loaidb::getFieldNameMap();
        $tableName = Loaidb::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $loai,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loaidb $loai)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'id_nhom' => 'required|integer'
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $loai->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $loai
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loaidb $loai)
    {
        // Xóa đối tượng
        $loai->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
