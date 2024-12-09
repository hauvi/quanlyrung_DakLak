<?php

namespace App\Http\Controllers\API\Geom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Lorung_xaController extends Controller
{
    public function index($maxa)
    {
        ini_set('memory_limit', '512M');
        $geojsonData = DB::table('lamnghiep.lorung_' . $maxa)
            ->select(DB::raw('ST_AsGeoJSON(geom) as geom'),'id','tentinh','tenhuyen','tenxa','maxa','mathuadat','malo','malocu','matieukhu','makhoanh','soto','sothua','diadanh','dientich','nguongoc_rung','nguongoc_rungtrong','phanloai_rung','loaicay','namtrong','captuoi','nkheptan','tinhtrang_thanhrung','truluong_go','truluong_tre','truluonglo_go','truluonglo_tre','tinhtrang_lapdia','mdsd_chinh','mdsd_phu','quyuoc_mdsd','doituong','churung','tinhtrang_tranhchap','tinhtrang_quyensudung','thoihansd','tinhtrang_khoanbaoverung','tinhtrang_quyhoach','nguoiky','nguoichiutn','tinhtrang_nguyensinh','kinhdo','vido','capkinhdo','capvido')
            ->paginate(1000);
        $features = $geojsonData->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->id,
                    'tentinh' => $item->tentinh,
                    'tenhuyen' => $item->tenhuyen,
                    'tenxa' => $item->tenxa,
                    'maxa' => $item->maxa,
                    'mathuadat' => $item->mathuadat,
                    'malo' => $item->malo,
                    'malocu' => $item->malocu,
                    'matieukhu' => $item->matieukhu,
                    'makhoanh' => $item->makhoanh,
                    'soto' => $item->soto,
                    'sothua' => $item->sothua,
                    'diadanh' => $item->diadanh,
                    'dientich' => $item->dientich,
                    'nguongoc_rung' => $item->nguongoc_rung,
                    'nguongoc_rungtrong' => $item->nguongoc_rungtrong,
                    'phanloai_rung' => $item->phanloai_rung,
                    'loaicay' => $item->loaicay,
                    'namtrong' => $item->namtrong,
                    'captuoi' => $item->captuoi,
                    'nkheptan' => $item->nkheptan,
                    'tinhtrang_thanhrung' => $item->tinhtrang_thanhrung,
                    'truluong_go' => $item->truluong_go,
                    'truluong_tre' => $item->truluong_tre,
                    'truluonglo_go' => $item->truluonglo_go,
                    'truluonglo_tre' => $item->truluonglo_tre,
                    'tinhtrang_lapdia' => $item->tinhtrang_lapdia,
                    'mdsd_chinh' => $item->mdsd_chinh,
                    'mdsd_phu' => $item->mdsd_phu,
                    'quyuoc_mdsd' => $item->quyuoc_mdsd,
                    'doituong' => $item->doituong,
                    'churung' => $item->churung,
                    'tinhtrang_tranhchap' => $item->tinhtrang_tranhchap,
                    'tinhtrang_quyensudung' => $item->tinhtrang_quyensudung,
                    'thoihansd' => $item->thoihansd,
                    'tinhtrang_khoanbaoverung' => $item->tinhtrang_khoanbaoverung,
                    'tinhtrang_quyhoach' => $item->tinhtrang_quyhoach,
                    'nguoiky' => $item->nguoiky,
                    'nguoichiutn' => $item->nguoichiutn,
                    'tinhtrang_nguyensinh' => $item->tinhtrang_nguyensinh,
                    'kinhdo' => $item->kinhdo,
                    'vido' => $item->vido,
                    'capkinhdo' => $item->capkinhdo,
                    'capvido' => $item->capvido,
                ],
            ];
        });
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features->toArray(),
        ];
        return response()->json($geojson);
    }
}
