<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LorungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            /* 'geom' => $this-> geom, */
            'maddlo' => $this-> maddlo,
            'matinh' => $this-> matinh,
            'mahuyen' => $this-> mahuyen,
            'maxa' => $this-> maxa,
            'tenxa' => $this-> tenxa,
            'matieukhu' => $this-> matieukhu,
            'makhoanh' => $this-> makhoanh,
            'malo' => $this-> malo,
            'soto' => $this-> soto,
            'sothua' => $this-> sothua,
            'diadanh' => $this->diadanh,
            'dientich' => $this-> dientich,
            'mangr' => $this-> mangr,
            'ldlr' => $this-> ldlr,
            'maldlr' => $this-> maldlr,
            'loaicay' => $this-> loaicay,
            'namtrong' => $this-> namtrong,
            'captuoi' => $this-> captuoi,
            'nkheptan' => $this-> nkheptan,
            'mangrt' => $this-> mangrt,
            'mathanhrung' => $this-> mathanhrung,
            'mgo' => $this-> mgo,
            'mtn' => $this-> mtn,
            'mgolo' => $this-> mgolo,
            'mtnlo' => $this-> mtnlo,
            'malapdia' => $this-> malapdia,
            'malr3' => $this-> malr3,
            'quyuocmdsd' => $this-> quyuocmdsd,
            'mamdsd' => $this-> mamdsd,
            'madoituong' => $this-> madoituong,
            'churung' => $this-> churung,
            'machurung' => $this-> machurung,
            'matranhchap' => $this-> matranhchap,
            'mattqsdd' => $this-> mattqsdd,
            'thoihansd' => $this-> thoihansd,
            'makhoan' => $this-> makhoan,
            'mattqh' => $this-> mattqh,
            'nguoiky' => $this-> nguoiky,
            'nguoichiutn' => $this-> nguoichiutn, 
            'manguoiky' => $this-> manguoiky,
            'manguoichiutn' => $this-> manguoichiutn,
            'mangsinh' => $this-> mangsinh,
            'kinhdo' => $this-> kinhdo,
            'vido' => $this-> vido,
            'capkinhdo' => $this-> capkinhdo,
            'capvido' => $this-> capvido,
            'malocu' => $this-> malocu,
            'mathuadat' => $this-> mathuadat,
            'tentinh' => $this-> tentinh,
            'tenhuyen' => $this-> tenhuyen,
        ];
    }
}
