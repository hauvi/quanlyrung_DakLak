<?php

namespace App\Http\Controllers\API\Mucdichsd;

use App\Http\Controllers\Controller;
use App\Models\Mucdichsd\Phanloaichinh;
use Illuminate\Http\Request;

class PhanloaichinhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Phanloaichinh::getData());
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
        $new_data = Phanloaichinh::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Phanloaichinh $phanloaichinh)
    {
        /* // Lấy dữ liệu của đối tượng dựa trên $id
        $rungtrong = Rungtrong::findOrFail($id); */

        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Phanloaichinh::getFieldNameMap();
        $tableName = Phanloaichinh::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $phanloaichinh,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phanloaichinh $phanloaichinh)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        //$rungtrong = Rungtrong::find($id);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $phanloaichinh->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $phanloaichinh
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phanloaichinh $phanloaichinh)
    {
        // Xóa đối tượng
        $phanloaichinh->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
