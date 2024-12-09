<?php

use App\Http\Controllers\API\Lamnghiep\BiendongrungController;
use App\Http\Controllers\API\DataController;
use App\Http\Controllers\API\Dienbien\HuongdbController;
use App\Http\Controllers\API\Dienbien\LoaidbController;
use App\Http\Controllers\API\Dienbien\NhomdbController;
use App\Http\Controllers\API\Geom\DubaochayController;
use App\Http\Controllers\API\Geom\Lorung_xaController;
use App\Http\Controllers\API\Geom\RghuyenController;
use App\Http\Controllers\API\Geom\RgxaController;
use App\Http\Controllers\API\Lamnghiep\DoituongController;
use App\Http\Controllers\API\Lamnghiep\LorungController;
use App\Http\Controllers\API\Lamnghiep\PhanloaidatController;
use App\Http\Controllers\API\Nguongoc\RungController;
use App\Http\Controllers\API\PolygonController;
use App\Http\Controllers\GeomController;
use App\Http\Controllers\API\Mucdichsd\PhanloaichinhController;
use App\Http\Controllers\API\Mucdichsd\PhanloaiphuController;
use App\Http\Controllers\API\Nguongoc\RungtrongController;
use App\Http\Controllers\API\Tinhtrang\KhoanbvContronller;
use App\Http\Controllers\API\Tinhtrang\LapdiaController;
use App\Http\Controllers\API\Tinhtrang\NguyensinhController;
use App\Http\Controllers\API\Tinhtrang\QuyensddController;
use App\Http\Controllers\API\Tinhtrang\QuyhoachController;
use App\Http\Controllers\API\Tinhtrang\ThanhrungController;
use App\Http\Controllers\API\Tinhtrang\TranhchapController;
use App\Http\Controllers\Congtac\KehoachtuantraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* Route::apiResource('/polygon/{schema}/{table}', PolygonController::class); */
/* Route::prefix('data')->group( function () {
    Route::apiResource('/{schema}/{table}', DataController::class);
});
 */
/* Route::prefix('{schema}')->group( function () {
    Route::apiResource('/{table}', DataController::class);
}); */
Route::prefix('lamnghiep')->group(function () {
    Route::apiResource('lorung', LorungController::class)->parameters(['lorung' => 'lorung',]);
    Route::apiResource('doituong', DoituongController::class)->parameters(['doituong' => 'doituong',]);
    Route::apiResource('loaidatloairung', PhanloaidatController::class)->parameters(['loaidatloairung' => 'loaidatloairung',]);
    Route::apiResource('biendong_dtrung', BiendongrungController::class)->parameters(['biendong_dtrung' => 'biendong_dtrung',]);
});

Route::prefix('nguongoc')->group(function () {
    Route::apiResource('rung', RungController::class)->parameters(['rung' => 'rung',]);
    Route::apiResource('rungtrong', RungtrongController::class)->parameters(['rungtrong' => 'rungtrong',]);
});

Route::prefix('mucdichsd')->group(function () {
    Route::apiResource('phanloaichinh', PhanloaichinhController::class)->parameters(['phanloaichinh' => 'phanloaichinh',]);
    Route::apiResource('phanloaiphu', PhanloaiphuController::class)->parameters(['phanloaiphu' => 'phanloaiphu',]);
});

Route::prefix('tinhtrang')->group(function () {
    Route::apiResource('thanhrung', ThanhrungController::class)->parameters(['thanhrung' => 'thanhrung',]);
    Route::apiResource('lapdia', LapdiaController::class)->parameters(['lapdia' => 'lapdia',]);
    Route::apiResource('tranhchap', TranhchapController::class)->parameters(['tranhchap' => 'tranhchap',]);
    Route::apiResource('quyensudungdat', QuyensddController::class)->parameters(['quyensudungdat' => 'quyensudungdat',]);
    Route::apiResource('khoanbaoverung', KhoanbvContronller::class)->parameters(['khoanbaoverung' => 'khoanbaoverung',]);
    Route::apiResource('quyhoach', QuyhoachController::class)->parameters(['quyhoach' => 'quyhoach',]);
    Route::apiResource('nguyensinh', NguyensinhController::class)->parameters(['nguyensinh' => 'nguyensinh',]);
});

Route::prefix('dienbien')->group(function () {
    Route::apiResource('loai', LoaidbController::class)->parameters(['loai' => 'loai',]);
    Route::apiResource('nhom', NhomdbController::class)->parameters(['nhom' => 'nhom',]);
    Route::apiResource('huong', HuongdbController::class)->parameters(['huong' => 'huong',]);
});

Route::prefix('congtac')->group(function () {
    Route::apiResource('kehoachtuantra', KehoachtuantraController::class)->parameters(['kehoachtuantra' => 'kehoachtuantra',]);
});

Route::prefix('geom')->group(function () {
    Route::get('lorung', [LorungController::class, 'getLorungInfo']);
    Route::get('lorung_geom', [LorungController::class, 'gop_lorung']);
    Route::get('lorung/{maxa}', [Lorung_xaController::class, 'index']);
    Route::apiResource('rghuyen', RghuyenController::class);
    Route::apiResource('rgxa', RgxaController::class);
    Route::apiResource('dubaochay', DubaochayController::class);

});

Route::prefix('static')->group(function () {
    Route::get('lorung', [LorungController::class, 'staticLorung']);
});

Route::prefix('search')->group(function () {
    Route::get('lorung', [LorungController::class, 'search']);
});