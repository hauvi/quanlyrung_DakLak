<?php

use App\Http\Controllers\API\Geom\DanhsachController;
use App\Http\Controllers\API\Geom\DubaochayController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Congtac\PhanloaiController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GeoJsonController;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome');
//Route::view('/map', 'map');
Route::get('/',[DanhsachController::class, 'index']);
//Route::get('/map',[DanhsachController::class, 'index']);
Route::get('/xa-by-huyen', [DanhsachController::class, 'getXaByHuyen'])->name('xa.getByHuyen');
Route::prefix('/data')->group(function() {
    Route::view('', 'data.index');
   /*  Route::get('/{schema}/{table}/{id}', function($schema, $table, $id) {
        return view('data.edit', compact('schema', 'table', 'id'));
    }); */
});
Route::get('/profession', [PhanloaiController::class, 'index']);

Route::view('/admin', 'admin');
Route::view('/test', 'test');

Route::get('import', [DubaochayController::class, 'showImportForm'])->name('import.form');
Route::post('/import/preview', [DubaochayController::class, 'preview'])->name('import.preview');
Route::post('import', [DubaochayController::class, 'import'])->name('import');

Route::get('/import-view', function () {
    return view('import');
})->name('import.view');