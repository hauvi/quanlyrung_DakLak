<?php

namespace App\Http\Controllers\API\Nguongoc;

use App\Http\Controllers\Controller;
use App\Models\Nguongoc\Rung;
use Illuminate\Http\Request;

class RungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Rung::getData());
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
        $new_data = Rung::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $new_data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rung $rung)
    {
         // Lấy danh sách tên cột và thông tin bảng từ model
         $fieldNames = Rung::getFieldNameMap();
         $tableName = Rung::tableName();
 
         // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
         return response()->json([
             'data' => $rung,
             'field_names' => $fieldNames,
             'table_name' => $tableName,
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rung $rung)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
        ]);

       // $nguongocrung = Rung::find($id);

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $rung->update($validatedData);

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',
            'data' => $rung
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rung $rung)
    {
        //$nguongocrung = Rung::find($id);
         // Xóa đối tượng
         $rung->delete();

         // Trả về phản hồi
         return response()->json([
             'message' => 'Dữ liệu đã được xóa thành công!'
         ], 200);
    }
}
