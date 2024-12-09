<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schema = 'congtac.';

        // Thêm dữ liệu cho bảng phân loại
        DB::table($schema.'phanloai')->insert([
            ['ten' => 'Loại 1'],
            ['ten' => 'Loại 2'],
            ['ten' => 'Loại 3']
        ]);

        // Thêm dữ liệu cho bảng trạm tuần tra
        DB::table($schema.'tram')->insert([
            ['ten' => 'Trạm 1'],
            ['ten' => 'Trạm 2'],
            ['ten' => 'Trạm 3']
        ]);

        // Thêm dữ liệu cho bảng đội tuần tra
        DB::table($schema.'doi')->insert([
            ['ten' => 'Đội 1'],
            ['ten' => 'Đội 2'],
            ['ten' => 'Đội 3']
        ]);

        // Thêm dữ liệu cho bảng phương thức di chuyển
        DB::table($schema.'phuongthuc_dichuyen')->insert([
            ['ten' => 'Đi bộ'],
            ['ten' => 'Xe máy'],
            ['ten' => 'Ô tô']
        ]);

        // Thêm dữ liệu cho bảng nhiệm vụ
        DB::table($schema.'nhiemvu')->insert([
            ['ten' => 'Anti - poaching', 'ten_vn' => 'Chống săn trộm'],
            ['ten' => 'Follow - up', 'ten_vn' => 'Theo dõi sau khi thực hiện các biện pháp kiểm lâm hoặc bảo vệ rừng'],
            ['ten' => 'Research and Monitoring', 'ten_vn' => 'Nghiên cứu và quan trắc'],
            ['ten' => 'Surveillance', 'ten_vn' => 'Giám sát liên tục hoặc định kỳ để phát hiện và ngăn chặn các hành vi vi phạm']
        ]);
    }
}
