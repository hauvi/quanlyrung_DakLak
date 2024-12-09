<?php

namespace App\Models\Congtac;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doi extends Model
{
    use HasFactory;
    protected $table = 'congtac.doi';
    protected $guarded = [];
}
