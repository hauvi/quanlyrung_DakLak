<?php

namespace App\Http\Controllers\API\Lamnghiep;

use App\Http\Controllers\Controller;
use App\Models\Lamnghiep\Doituong;
use Illuminate\Http\Request;

class DoituongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Doituong::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten_viettat' => 'required|string|max:255',
            'ten' => 'required|string|max:255',
        ]);

        // Tạo đối tượng mới
        $doituong = Doituong::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $doituong
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doituong $doituong)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Doituong::getFieldNameMap();
        $tableName = Doituong::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $doituong,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doituong $doituong)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten_viettat' => 'required|string|max:255',
            'ten' => 'required|string|max:255',
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $doituong->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $doituong
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doituong $doituong)
    {
        // Xóa đối tượng
        $doituong->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
