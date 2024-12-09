<?php

namespace App\Http\Controllers\API\Lamnghiep;

use App\Http\Controllers\Controller;
use App\Models\Lamnghiep\Phanloaidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhanloaidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Phanloaidat::getData());
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
            'truluong_min' => 'required|integer',
            'truluong_max' => 'required|integer',
        ]);

        // Tạo đối tượng mới
        $phanloaidat = Phanloaidat::create($validatedData);

        // Trả về response
        return response()->json([
            'message' => 'Dữ liệu đã được tạo thành công!',
            'data' => $phanloaidat
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Phanloaidat $loaidatloairung)
    {
        // Lấy danh sách tên cột và thông tin bảng từ model
        $fieldNames = Phanloaidat::getFieldNameMap();
        $tableName = Phanloaidat::tableName();

        // Trả về dữ liệu và thông tin cấu trúc bảng dưới dạng JSON
        return response()->json([
            'data' => $loaidatloairung,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phanloaidat $loaidatloairung)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten_viettat' => 'required|string|max:255',
            'ten' => 'required|string|max:255',
            'truluong_min' => 'required|integer',
            'truluong_max' => 'required|integer',
        ]);

       /*  $phanloaidat = Phanloaidat::find($id);
        // Kiểm tra đối tượng $phanloaidat trước khi cập nhật
        if (!$phanloaidat) {
            return response()->json(['message' => 'Đối tượng không tồn tại!'], 404);
        } */

        // Cập nhật đối tượng với dữ liệu đã xác thực
        $updated = $loaidatloairung->update($validatedData);
        if (!$updated) {
            return response()->json(['message' => 'Cập nhật thất bại!'], 500);
        }

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được cập nhật thành công!',  
            'data' => $loaidatloairung          
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phanloaidat $loaidatloairung)
    {
        //$phanloaidat = Phanloaidat::find($id);
        // Xóa đối tượng
        $loaidatloairung->delete();

        // Trả về phản hồi
        return response()->json([
            'message' => 'Dữ liệu đã được xóa thành công!'
        ], 200);
    }
}
