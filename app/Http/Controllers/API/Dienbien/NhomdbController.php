<?php

namespace App\Http\Controllers\API\Dienbien;

use App\Http\Controllers\Controller;
use App\Models\Dienbien\Nhomdb;
use Illuminate\Http\Request;

class NhomdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Nhomdb::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'id_huong' => 'required|integer'
        ]);

        // Tạo đối tượng mới
        $new_data = Nhomdb::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nhomdb $nhom)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Nhomdb::getFieldNameMap();
        $tableName = Nhomdb::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $nhom,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nhomdb $nhom)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'id_huong' => 'required|integer'
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $nhom->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $nhom
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nhomdb $nhom)
    {
        // Xóa đối tượng
        $nhom->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
