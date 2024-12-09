<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Cho phép cập nhật tên bảng động
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }
}
