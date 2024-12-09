<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Geom extends Model
{
    use HasFactory;

   /*  protected $table = 'lamnghiep.simplified_geom'; */
   protected $table = 'lamnghiep.dtlorung';

    protected $guarded = [];

    /* public static function getGeoJsonData()
    {
        return Cache::remember('geojson_data', 60, function () {
            return self::select('geom')->get();
        });
    } */
    /* public static function getGeoJsonData()
    {
        return Cache::remember('geojson_data', 60, function () {
            return self::select('geom')->get();
        });
    } */

    // Function tính diện tích theo huyện
   /*  public static function getAreaStatisticsByDistrict()
    {
        return Cache::remember('area_statistics_by_district', 60, function () {
            return self::selectRaw('tenhuyen, mahuyen, SUM(ST_Area(geom::geography)/10000) as total_area')
                ->groupBy('tenhuyen', 'mahuyen')
                ->get();
        });
    } */
}
