<?php

namespace App\Models\Geom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Rghuyen extends Model
{
    use HasFactory;

    /*  protected $table = 'lamnghiep.simplified_geom'; */
    protected $table = 'public.rghuyen';

    protected $guarded = [];

    public static function getGeoJsonData()
    {
        $data = DB::table('public.rghuyen')->select('geom', 'tenhuyen', 'mahuyen')->get();
        return response()->json($data);
    }
}
