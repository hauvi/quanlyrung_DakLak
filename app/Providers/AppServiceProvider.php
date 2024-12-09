<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mảng ánh xạ tên schema và table sang tên tiếng Việt
        $vinameMap = [
            'lamnghiep' => [
                'vi_name' => 'Lâm nghiệp',
                'tables' => [
                    'lorung' => 'Lô rừng',
                    'doituong' => 'Đối tượng',
                    'loaidatloairung' => 'Phân loại đất, rừng',
                    'biendong_dtrung' => 'Biến động diện tích rừng'
                ],
            ],
            'dienbien' => [
                'vi_name' => 'Diễn biến',
                'tables' => [
                    'loai' => 'Loại diễn biến rừng',
                    'nhom' => 'Nhóm diễn biến rừng',
                    'huong' => 'Hướng diễn biến rừng'
                ],
            ],
            'nguongoc' => [
                'vi_name' => 'Nguồn gốc',
                'tables' => [
                    'rung' => 'Nguồn gốc rừng',
                    'rungtrong' => 'Nguồn gốc rừng trồng',
                ],
            ],
            'mucdichsd' => [
                'vi_name' => 'Mục đích sử dụng',
                'tables' => [
                    'phanloaichinh' => 'Phân loại chính',
                    'phanloaiphu' => 'Phân loại phụ',
                ],
            ],
            'tinhtrang' => [
                'vi_name' => 'Tình trạng',
                'tables' => [
                    'thanhrung' => 'Tình trạng thành rừng',
                    'lapdia' => 'Tình trạng lập địa',
                    'tranhchap' => 'Tình trạng tranh chấp',
                    'quyensudungdat' => 'Tình trạng quyền sừ dụng đất',
                    'khoanbaoverung' => 'Tình trạng khoán bảo vệ rừng',
                    'quyhoach' => 'Tình trạng quy hoạch',
                    'nguyensinh' => 'Tình trạng nguyên sinh'
                ],
            ],
        ];

        // Sử dụng view composer để truyền dữ liệu đến view 'data.index'
        View::composer('data.index', function ($view) use ($vinameMap) {
            // Chỉ giữ lại các schema cần thiết
            $neededSchemas = array_keys($vinameMap);

            // Lấy danh sách schema từ cơ sở dữ liệu
            $schemas = DB::table('information_schema.schemata')
                ->whereIn('schema_name', $neededSchemas)
                ->get();

            // Lấy danh sách bảng từ cơ sở dữ liệu
            $tables = DB::table('information_schema.tables')
                ->where('table_type', 'BASE TABLE')
                ->whereIn('table_schema', $neededSchemas)
                ->get();

            // Tạo map cuối cùng chứa thông tin về schema và bảng
            $finalMap = [];

            foreach ($schemas as $schema) {
                $schemaName = $schema->schema_name;
                if (isset($vinameMap[$schemaName])) {
                    $finalMap[$schemaName] = [
                        'vi_name' => $vinameMap[$schemaName]['vi_name'],
                        'tables' => []
                    ];

                    foreach ($tables as $table) {
                        if ($table->table_schema === $schemaName) {
                            $finalMap[$schemaName]['tables'][$table->table_name] = $vinameMap[$schemaName]['tables'][$table->table_name] ?? $table->table_name;
                        }
                    }
                }
            }

            // Truyền map đến view
            $view->with('vinameMap', $finalMap);
        });
    }
}
