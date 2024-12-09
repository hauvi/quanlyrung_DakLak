<?php

namespace App\Http\Controllers\API\Tinhtrang;

use App\Http\Controllers\Controller;
use App\Models\Tinhtrang\Nguyensinh;
use Illuminate\Http\Request;

class NguyensinhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Nguyensinh::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'tinhtrang' => 'required|string|max:255',
        ]);

        // Tạo đối tượng mới
        $new_data = Nguyensinh::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nguyensinh $nguyensinh)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Nguyensinh::getFieldNameMap();
        $tableName = Nguyensinh::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $nguyensinh,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nguyensinh $nguyensinh)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'tinhtrang' => 'required|string|max:255'
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $nguyensinh->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $nguyensinh
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nguyensinh $nguyensinh)
    {
        // Xóa đối tượng
        $nguyensinh->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
