<?php

namespace App\Http\Controllers\API\mucdichsd;

use App\Http\Controllers\Controller;
use App\Models\mucdichsd\Phanloaiphu;
use Illuminate\Http\Request;

class PhanloaiphuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Phanloaiphu::getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Xác thực dữ liệu đầu vào
         $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'ten_viettat' =>  'required|string|max:255'
        ]);

        // Tạo đối tượng mới
        $new_data = Phanloaiphu::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Phanloaiphu $phanloaiphu)
    {
         // Lấy danh sách tên cột và thông tin bảng từ model
         $fieldNames = Phanloaiphu::getFieldNameMap();
         $tableName = Phanloaiphu::tableName();
 
         // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
         return response()->json([
             'data' => $phanloaiphu,
             'field_names' => $fieldNames,
             'table_name' => $tableName,
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phanloaiphu $phanloaiphu)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
             'ten_viettat' =>  'required|string|max:255'
        ]);

        //$rungtrong = Rungtrong::find($id);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $phanloaiphu->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $phanloaiphu
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phanloaiphu $phanloaiphu)
    {
         // Xóa đối tượng
         $phanloaiphu->delete();

         // Trả về phản hồi
         return response()->json([
             'message' => 'Dữ liệu đã được xóa thành công!'
         ], 200);
    }
}
