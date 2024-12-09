<?php

namespace App\Http\Controllers\Congtac;

use App\Http\Controllers\Controller;
use App\Models\Congtac\Doi;
use App\Models\Congtac\Nhiemvu;
use App\Models\Congtac\Phanloai;
use App\Models\Congtac\Phuongthucdichuyen;
use App\Models\Congtac\Tram;
use Illuminate\Http\Request;

class PhanloaiController extends Controller
{
    public function index()
    {
        $phanloai = Phanloai::all();
        $doi = Doi::all();
        $tram = Tram::all();
        $nhiemvu = Nhiemvu::all();
        $phuongthuc = Phuongthucdichuyen::all();
        //dd($phuongthuc); // Kiểm tra dữ liệu
        return view('profession', ['phanloai' => $phanloai, 'doi' => $doi, 'tram' => $tram, 'nhiemvu' => $nhiemvu, 'phuongthuc' => $phuongthuc]);
    }
}
