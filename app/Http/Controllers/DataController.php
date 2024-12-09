<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Http\Requests\StoreDataRequest;
use App\Http\Requests\UpdateDataRequest;
use App\Http\Resources\DataResource;

class DataController extends Controller
{
    // Hàm riêng để tạo tên bảng đầy đủ
    private function getFullTableName($schema, $table)
    {
        // Validate schema và table name để ngăn chặn SQL injection
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $schema) || !preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
            throw new \InvalidArgumentException('Invalid schema or table name');
        }

        // Tạo tên bảng đầy đủ
        return "{$schema}.{$table}";
    }

    /**
     * Display a listing of the resource.
     */
    public function index($schema, $table)
    {
         try {
            // Sử dụng hàm riêng để lấy tên bảng đầy đủ
            $fullTableName = $this->getFullTableName($schema, $table);

            // Sử dụng DynamicModel để truy vấn dữ liệu
            $dynamicModel = new Data();
            $data = $dynamicModel->setTable($fullTableName)->paginate(10);
            return DataResource::collection($data);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Table not found or other error occurred'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Data $data)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Data $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataRequest $request, Data $data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Data $data)
    {
        //
    }
}
