<?php

namespace App\Http\Controllers\API\Geom;

use App\Http\Controllers\Controller;
use App\Models\Geom\Dubaochay;
use App\Models\Geom\Rghuyen;
use App\Models\Geom\Rgxa;
use App\Models\Lamnghiep\Lorung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DanhsachController extends Controller
{
    public function index(Request $request)
    {
        $huyenList = Rghuyen::select('tenhuyen', 'mahuyen')
        ->orderBy('tenhuyen')
        ->get();

        $ngayList = Dubaochay::select(DB::raw("TO_CHAR(TO_TIMESTAMP(ngay, 'HH24:MI:SS DD/MM/YYYY'), 'DD/MM/YYYY') as ngay"))
        ->distinct()
        ->get()
        ->pluck('ngay')
        ->sortByDesc(function ($dateString) {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $dateString);
        });
    
    return view('map',['huyenList' => $huyenList, 'ngayList' => $ngayList]);
    }
    public function getXaByHuyen(Request $request)
    {
        $mahuyen = $request->input('mahuyen');

        $xaList = Lorung::where('mahuyen', $mahuyen)
            ->select('maxa', 'tenxa')
            ->distinct()
            ->orderBy('tenxa')
            ->get();

        return response()->json($xaList);
    }
}
