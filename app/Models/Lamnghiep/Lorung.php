<?php

namespace App\Models\Lamnghiep;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lorung extends Model
{
    use HasFactory;

    protected $table = 'lamnghiep.lorung_prop';

    protected $guarded = [];

    // Map tên trường cho bảng 'lorung'
    public static function getFieldNameMap()
    {
        return [
            'id' => 'STT',
            'maddlo' => 'Mã định danh lô',
            'matinh' => 'Mã tỉnh',
            'mahuyen' => 'Mã huyện',
            'maxa' => 'Mã xã',
            'matieukhu' => 'Mã tiểu khu',
            'makhoanh' => 'Mã khoanh',
            'mangr' => 'Mã nguồn gốc rừng',
            'maldlr' => 'Mã phân loại đất, rừng',
            'mangrt' => 'Mã nguồn gốc rừng trồng',
            'mathanhrung' => 'Mã tình trạng thành rừng',
            'malapdia' => 'Mã tình trạng lập địa',
            'malr3' => 'Mã mục dích sử dụng (chính)',
            'mamdsd' => 'Mã mục đích sử dụng (phụ)',
            'madoituong' => 'Mã đối tượng',
            'machurung' => 'Mã chủ rừng',
            'matranhchap' => 'Mã tình trạng tranh chấp',
            'mattqsdd' => 'Mã tình trạng quyền sử dụng đất',
            'makhoan' => 'Mã tình trạng khoán bảo vệ rừng',
            'mattqh' => 'Mã tình trạng quy hoạch',
            'manguoiky' => 'Mã người ký',
            'manguoichiutn' => 'Mã người chịu trách nhiệm',
            'mangsinh' => 'Mã tình trạng nguyên sinh',
            'malocu' => 'Mã lô (cũ)',
            'tentinh' => 'Tên tỉnh',
            'tenhuyen' => 'Tên huyện',
            'tenxa' => 'Tên xã',
            'malo' => 'Mã lô',
            'mathuadat' => 'Mã thửa đất',
            'soto' => 'Số tờ',
            'sothua' => 'Số thửa',
            'diadanh' => 'Địa danh',
            'dientich' => 'Diện tích (Ha)',
            'ldlr' => 'Phân loại',
            'loaicay' => 'Loại cây',
            'namtrong' => 'Năm trồng',
            'captuoi' => 'Cấp tuổi',
            'nkheptan' => 'Số năm khép tán',
            'mgo' => 'Trữ lượng gỗ theo ha (m3/ha)',
            'mtn' => 'Trữ lượng tre nứa theo ha (1000 cây/ha)',
            'mgolo' => 'Trữ lượng gỗ theo lô (m3/lô)',
            'mtnlo' => 'Trữ lượng cây tre nứa theo lô (1000 cây/lô)',
            'quyuocmdsd' => 'Quy ước MĐSD rừng',
            'churung' => 'Chủ rừng',
            'thoihansd' => 'Thời hạn sử dụng',
            'nguoiky' => 'Người ký',
            'nguoichiutn' => 'Người chịu trách nhiệm',
            'kinhdo' => 'Kinh độ',
            'vido' => 'Vĩ độ',
            'capkinhdo' => 'Cấp kinh độ',
            'capvido' => 'Cấp vĩ độ'
            // Thêm các trường khác nếu cần
        ];
    }

    public static function tableName()
    {
        return [
            'tableName' => 'Dữ liệu Lô rừng'
        ];
    }

    public static function getJsonData()
    {
        $column = ['id', 'tentinh', 'tenhuyen', 'tenxa', 'malo', 'mathuadat', 'soto', 'sothua', 'diadanh', 'dientich', 'ldlr', 'loaicay', 'namtrong', 'captuoi', 'nkheptan', 'mgo', 'mtn', 'mgolo', 'mtnlo', 'quyuocmdsd', 'churung', 'thoihansd', 'nguoiky', 'nguoichiutn', 'kinhdo', 'vido', 'capkinhdo', 'capvido'];
        $columns = array_keys(self::getFieldNameMap()); // Sử dụng tên trường từ map
        $geojsonData = self::select($columns)->paginate(15);
        /*   $features = [];

        foreach ($geojsonData as $data) {
            $properties = collect($data)->except('shape_leng', 'shape_area', 'created_at', 'updated_at')->toArray();

            $feature = [
                'type' => 'Feature',
                'properties' => $properties,
            ];
            $features[] = $feature;
        } */
        return [
            'data' => $geojsonData,
            'field_names' => self::getFieldNameMap(),
            'table_name' => self::tableName()
        ];

        /* return response()->json($geojsonData); */
        /* [
            'type' => 'FeatureCollection',
            'features' => $features,
            'pagination' => [
                'total' => $geojsonData->total(),
                'per_page' => $geojsonData->perPage(),
                'current_page' => $geojsonData->currentPage(),
                'last_page' => $geojsonData->lastPage(),
                'from' => $geojsonData->firstItem(),
                'to' => $geojsonData->lastItem(),
            ],
        ]; */
    }
}
