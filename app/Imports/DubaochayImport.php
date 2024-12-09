<?php

namespace App\Imports;

use App\Models\Geom\Dubaochay;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Throwable;

class DubaochayImport implements ToModel, WithHeadingRow, SkipsOnError
{
    public function model(array $row)
    {
        // Bỏ qua dòng đầu tiên (header)
        if (isset($row['stt']) && $row['stt'] == 'STT') {
            return null;
        }

        return new Dubaochay([
            'tentinh' => trim($row['tinh']),
            'tenhuyen' => trim($row['huyen']),
            'nhietdo' => trim($row['nhiet_do']),
            'doam' => trim($row['do_am']),
            'luongmua' => trim($row['luong_mua']),
            'capdubao' => trim($row['cap_du_bao']),
            'ngay' => trim($row['ngay']),
        ]);
    }

    public function onError(Throwable $error)
    {
        Log::error('Import Error:', ['message' => $error->getMessage()]);
    }
}

