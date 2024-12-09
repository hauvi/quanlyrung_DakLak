<?php

namespace App\Http\Controllers\API\Tinhtrang;

use App\Http\Controllers\Controller;
use App\Models\Tinhtrang\Tranhchap;
use Illuminate\Http\Request;

class TranhchapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Tranhchap::getData());
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
        $new_data = Tranhchap::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tranhchap $tranhchap)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Tranhchap::getFieldNameMap();
        $tableName = Tranhchap::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $tranhchap,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tranhchap $tranhchap)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'tinhtrang' => 'required|string|max:255'
        ]);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $tranhchap->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $tranhchap
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tranhchap $tranhchap)
    {
        // Xóa đối tượng
        $tranhchap->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
