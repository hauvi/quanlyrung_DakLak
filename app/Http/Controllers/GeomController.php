<?php

namespace App\Http\Controllers;

use App\Models\Geom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ini_set('max_execution_time', 300);
        // Gọi model để lấy dữ liệu thống kê diện tích theo huyện
        $statistics = Geom::getAreaStatisticsByDistrict();

        // Trả về dữ liệu dưới dạng JSON
        return response()->stream(function () use ($statistics) {
            echo json_encode($statistics);
        }, 200, ['Content-Type' => 'application/json']);
    }
}
