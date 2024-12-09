<?php

namespace App\Http\Controllers\API\Lamnghiep;

use App\Http\Controllers\Controller;
use App\Http\Resources\LorungResource;
use App\Models\Lamnghiep\Lorung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LorungController extends Controller
{
    private function validated(Request $request)
    {
        $$request->validate([
            'maddlo' => request('maddlo'),
            'matinh' => request('matinh'),
            'mahuyen' => request('mahuyen'),
            'maxa' => request('maxa'),
            'tenxa' => request('tenxa'),
            'matieukhu' => request('matieukhu'),
            'makhoanh' => request('makhoanh'),
            'malo' => request('malo'),
            'soto' => request('soto'),
            'sothua' => request('sothua'),
            'diadanh' => request('diadanh'),
            'dientich' => request('dientich'),
            'mangr' => request('mangr'),
            'ldlr' => request('ldlr'),
            'maldlr' => request('maldlr'),
            'loaicay' => request('loaicay'),
            'namtrong' => request('namtrong'),
            'captuoi' => request('captuoi'),
            'nkheptan' => request('nkheptan'),
            'mangrt' => request('mangrt'),
            'mathanhrung' => request('mathanhrung'),
            'mgo' => request('mgo'),
            'mtn' => request('mtn'),
            'mgolo' => request('mgolo'),
            'mtnlo' => request('mtnlo'),
            'malapdia' => request('malapdia'),
            'malr3' => request('malr3'),
            'quyuocmdsd' => request('quyuocmdsd'),
            'mamdsd' => request('mamdsd'),
            'madoituong' => request('madoituong'),
            'churung' => request('madoituong'),
            'machurung' => request('machurung'),
            'matranhcha' => request('madoituong'),
            'mattqsdd' => request('mattqsdd'),
            'thoihansd' => request('thoihansd'),
            'makhoan' => request('makhoan'),
            'mattqh' => request('mattqh'),
            'nguoiky' => request('nguoiky'),
            'nguoichiut' => request('nguoichiut'),
            'manguoiky' => request('manguoiky'),
            'manguoichi' => request('manguoichi'),
            'mangsinh' => request('mangsinh'),
            'kinhdo' => request('kinhdo'),
            'vido' => request('vido'),
            'capkinhdo' => request('capkinhdo'),
            'capvido' => request('capvido'),
            'malocu' => request('malocu'),
            'mathuadat' => request('mathuadat'),
            'tentinh' => request('tentinh'),
            'tenhuyen' => request('tenhuyen')
        ]);
        if ($validate->fails()) {
            response()->json(['errors' => $validate->errors()], 422)->throwResponse();
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Lorung::getJsonData());
    }

    public function search(Request $request)
    {
        //$query = Lorung::query(); //khởi tạo một đối tượng query builder cho model
        $query = DB::table('lamnghiep.lorung_search');

        // Nếu có từ khóa tìm kiếm
        if ($request->has('search')) {
            $searchTerm = $request->input('search'); // Lấy từ khóa tìm kiếm

            // Tìm kiếm trên nhiều trường cùng lúc
            $query->where(function ($query) use ($searchTerm) {
                $query->where('mathuadat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('malo', 'like', '%' . $searchTerm . '%')
                    ->orWhere('soto', 'like', '%' . $searchTerm . '%')
                    ->orWhere('sothua', 'like', '%' . $searchTerm . '%')
                    ->orWhere('churung', 'like', '%' . $searchTerm . '%');
            });
            if ($request->has('xa')) {
                $query->where('maxa', $request->input('xa')); // Adjust column name if needed
            }
        }

        $data = $query->paginate(15); // Keep pagination

        // Kiểm tra có `xa` trong request
        $hasXa = $request->has('xa');

        if (!$hasXa) {
            $ids = $data->pluck('id'); // Lấy danh sách ID từ kết quả tìm kiếm

            // Lấy dữ liệu geom từ bảng lorung_geo
            $geomData = DB::table('lamnghiep.lorung_search')
                ->whereIn('id', $ids)
                ->select(['id', DB::raw('ST_AsGeoJSON(geom) AS geom')])
                ->get();

            // Ghép `geom` vào `$data`
            $data = $data->map(function ($item) use ($geomData) {
                $geom = $geomData->firstWhere('id', $item->id); // Tìm geom tương ứng với ID
                $item->geom = $geom ? $geom->geom : null; // Gắn geom nếu tìm thấy
                return $item;
            });
        }

        $features = $data->map(function ($item) use ($hasXa) {
            $geometry = !$hasXa && isset($item->geom) ? json_decode($item->geom) : null;
            return [
                'type' => 'Feature',
                'geometry' =>  $geometry,
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
    public function store(Request $request)
    {
        /*   $this->validated($request); */

        $lorung = Lorung::create([
            'geom' => $request->geom,
            'maddlo' => $request->maddlo,
            'matinh' => $request->matinh,
            'mahuyen' => $request->mahuyen,
            'maxa' => $request->maxa,
            'tenxa' => $request->tenxa,
            'matieukhu' => $request->matieukhu,
            'makhoanh' => $request->makhoanh,
            'malo' => $request->malo,
            'soto' => $request->soto,
            'sothua' => $request->sothua,
            'diadanh' => $request->diadanh,
            'dientich' => $request->dientich,
            'mangr' => $request->mangr,
            'ldlr' => $request->ldlr,
            'maldlr' => $request->maldlr,
            'loaicay' => $request->loaicay,
            'namtrong' => $request->namtrong,
            'captuoi' => $request->captuoi,
            'nkheptan' => $request->nkheptan,
            'mangrt' => $request->mangrt,
            'mathanhrung' => $request->mathanhrung,
            'mgo' => $request->mgo,
            'mtn' => $request->mtn,
            'mgolo' => $request->mgolo,
            'mtnlo' => $request->mtnlo,
            'malapdia' => $request->malapdia,
            'malr3' => $request->malr3,
            'quyuocmdsd' => $request->quyuocmdsd,
            'mamdsd' => $request->mamdsd,
            'madoituong' => $request->madoituong,
            'churung' => $request->churung,
            'machurung' => $request->machurung,
            'matranhchap' => $request->matranhchap,
            'mattqsdd' => $request->mattqsdd,
            'thoihansd' => $request->thoihansd,
            'makhoan' => $request->makhoan,
            'mattqh' => $request->mattqh,
            'nguoiky' => $request->nguoiky,
            'nguoichiutn' => $request->nguoichiutn,
            'manguoiky' => $request->manguoiky,
            'manguoichiutn' => $request->manguoichiutn,
            'mangsinh' => $request->mangsinh,
            'kinhdo' => $request->kinhdo,
            'vido' => $request->vido,
            'capkinhdo' => $request->capkinhdo,
            'capvido' => $request->capvido,
            'malocu' => $request->malocu,
            'mathuadat' => $request->mathuadat,
            'tentinh' => $request->tentinh,
            'tenhuyen' => $request->tenhuyen
        ]);
        return response()->json([
            "message" => "Tạo mới thành công",
            "data" => new LorungResource($lorung),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lorung $lorung)
    {
        $lorung = new LorungResource($lorung);
        $fieldNames = Lorung::getFieldNameMap();
        $tableName = Lorung::tableName();
        return response()->json([
            'data' => $lorung,
            'field_names' => $fieldNames,
            'table_name' => $tableName,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lorung $lorung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lorung $lorung)
    {
        $lorung->update([
            'geom' => $request->geom,
            'maddlo' => $request->maddlo,
            'matinh' => $request->matinh,
            'mahuyen' => $request->mahuyen,
            'maxa' => $request->maxa,
            'tenxa' => $request->tenxa,
            'matieukhu' => $request->matieukhu,
            'makhoanh' => $request->makhoanh,
            'malo' => $request->malo,
            'soto' => $request->soto,
            'sothua' => $request->sothua,
            'diadanh' => $request->diadanh,
            'dientich' => $request->dientich,
            'mangr' => $request->mangr,
            'ldlr' => $request->ldlr,
            'maldlr' => $request->maldlr,
            'loaicay' => $request->loaicay,
            'namtrong' => $request->namtrong,
            'captuoi' => $request->captuoi,
            'nkheptan' => $request->nkheptan,
            'mangrt' => $request->mangrt,
            'mathanhrung' => $request->mathanhrung,
            'mgo' => $request->mgo,
            'mtn' => $request->mtn,
            'mgolo' => $request->mgolo,
            'mtnlo' => $request->mtnlo,
            'malapdia' => $request->malapdia,
            'malr3' => $request->malr3,
            'quyuocmdsd' => $request->quyuocmdsd,
            'mamdsd' => $request->mamdsd,
            'madoituong' => $request->madoituong,
            'churung' => $request->churung,
            'machurung' => $request->machurung,
            'matranhchap' => $request->matranhchap,
            'mattqsdd' => $request->mattqsdd,
            'thoihansd' => $request->thoihansd,
            'makhoan' => $request->makhoan,
            'mattqh' => $request->mattqh,
            'nguoiky' => $request->nguoiky,
            'nguoichiutn' => $request->nguoichiutn,
            'manguoiky' => $request->manguoiky,
            'manguoichiutn' => $request->manguoichiutn,
            'mangsinh' => $request->mangsinh,
            'kinhdo' => $request->kinhdo,
            'vido' => $request->vido,
            'capkinhdo' => $request->capkinhdo,
            'capvido' => $request->capvido,
            'malocu' => $request->malocu,
            'mathuadat' => $request->mathuadat,
            'tentinh' => $request->tentinh,
            'tenhuyen' => $request->tenhuyen
        ]);
        return response()->json([
            "message" => "Update success",
            "data" => new LorungResource($lorung),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lorung $lorung)
    {
        $lorung->delete();
        return response()->json([
            "message" => "Delete success",
        ]);
    }

    public function getLorungInfo()
    {
        $lorungInfo = DB::table('lamnghiep.lorung_info')
            ->paginate(15); // Lấy 100 bản ghi mỗi lần
        // Chuyển đổi dữ liệu sang cấu trúc GeoJSON
        $features = $lorungInfo->map(function ($item) {
            return [
                'type' => 'Feature',
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
            'links' => $lorungInfo->links(), // Link phân trang
            'meta' => [
                'current_page' => $lorungInfo->currentPage(),
                'last_page' => $lorungInfo->lastPage(),
                'per_page' => $lorungInfo->perPage(),
                'total' => $lorungInfo->total(),
            ],
        ];

        return response()->json($geojson);
    }

    public function staticLorung(Request $request)
    {
        /*  $lorung = DB::table('lamnghiep.lorung_info')
            ->select('tenhuyen', DB::raw('SUM(dientich) as tong_dientich'), DB::raw('COUNT(ID) as tong_lorung'))
            ->groupBy('tenhuyen')
            ->get();

        // Trả về kết quả dưới dạng JSON
        return response()->json([
            'status' => 'success',
            'data' => $lorung
        ]); */
        $chartType = $request->input('chart_type');
        $maHuyen = $request->input('mahuyen'); // Get the "mahuyen" parameter



        if ($chartType === 'dientich') {
            $data = DB::table('lamnghiep.lorung_info')
                ->select('tenhuyen', DB::raw('SUM(dientich) as tong_dientich'))
                ->groupBy('tenhuyen')
                ->get();
            // ... your query for dien tich ... (e.g., sum of dientich, grouped by huyen)
            if ($maHuyen) { // Add filtering by "mahuyen"
                $data = DB::table('lamnghiep.lorung_info')
                    ->select('tenxa', DB::raw('SUM(dientich) as tong_dientich'))
                    ->where('mahuyen', $maHuyen)
                    ->groupBy('tenxa')
                    ->get();
            }
        } else if ($chartType === 'soluong') {
            $data = DB::table('lamnghiep.lorung_info')
                ->select('tenhuyen', DB::raw('COUNT(ID) as tong_lorung'))
                ->groupBy('tenhuyen')
                ->get();
            // ... your query for so luong ... (e.g., count of lorung, grouped by huyen)
            if ($maHuyen) { // Add filtering by "mahuyen"
                $data = DB::table('lamnghiep.lorung_info')
                    ->select('tenxa', DB::raw('COUNT(ID) as tong_lorung'))
                    ->where('mahuyen', $maHuyen)
                    ->groupBy('tenxa')
                    ->get();
                // ... your query to filter data for the selected "mahuyen" ...
            }
        }



        return response()->json(['data' => $data]);
    }

    public function gop_lorung()
    {
        $geojsonData = DB::table('lamnghiep.gop_lorung')
            ->select(DB::raw('ST_AsGeoJSON(geom) as geom'))
            ->get();
        $features = $geojsonData->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [],
            ];
        });
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features->toArray(),
        ];
        return response()->json($geojson);
    }
}
