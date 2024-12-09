<?php

namespace App\Http\Controllers\API\Dienbien;

use App\Http\Controllers\Controller;
use App\Models\Dienbien\Huongdb;
use Illuminate\Http\Request;

class HuongdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Huongdb::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        // Tạo đối tượng mới
        $new_data = Huongdb::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Huongdb $huong)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Huongdb::getFieldNameMap();
        $tableName = Huongdb::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $huong,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Huongdb $huong)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255'
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $huong->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $huong
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Huongdb $huong)
    {
        // Xóa đối tượng
        $huong->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
