<?php

namespace App\Http\Controllers\API\Nguongoc;

use App\Http\Controllers\Controller;
use App\Models\Nguongoc\Rungtrong;
use Illuminate\Http\Request;

class RungtrongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Rungtrong::getData());
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
        $new_data = Rungtrong::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rungtrong $rungtrong)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Rungtrong::getFieldNameMap();
        $tableName = Rungtrong::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $rungtrong,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rungtrong $rungtrong)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        //$rungtrong = Rungtrong::find($id);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $rungtrong->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $rungtrong
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rungtrong $rungtrong)
    {
        //$rungtrong = Rungtrong::find($id);
        // Xóa đối tượng
        $rungtrong->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
