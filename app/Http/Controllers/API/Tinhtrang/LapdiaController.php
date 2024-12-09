<?php

namespace App\Http\Controllers\API\Tinhtrang;

use App\Http\Controllers\Controller;
use App\Models\Tinhtrang\Lapdia;
use Illuminate\Http\Request;

class LapdiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Lapdia::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'ten_viettat' => 'required|string|max:255'
        ]);

        // Tạo đối tượng mới
        $new_data = Lapdia::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lapdia $lapdia)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Lapdia::getFieldNameMap();
        $tableName = Lapdia::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $lapdia,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lapdia $lapdia)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
             'ten' => 'required|string|max:255',
            'ten_viettat' => 'required|string|max:255'
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $lapdia->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $lapdia
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lapdia $lapdia)
    {
        // Xóa đối tượng
        $lapdia->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
