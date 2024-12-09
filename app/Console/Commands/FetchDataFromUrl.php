<?php

namespace App\Console\Commands;

use App\Models\Geom\Dubaochay;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchDataFromUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from a URL and store it in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // URL để lấy dữ liệu
        $url = 'https://watch.pcccr.vn/thongKe/duBaoChay/dtGetData';

        // Gửi yêu cầu HTTP GET
        $response = Http::get($url);

        // Kiểm tra nếu yêu cầu thành công
        if ($response->successful()) {
            // Lưu dữ liệu vào cơ sở dữ liệu
            // Giả sử dữ liệu là JSON và bạn đã có model tương ứng
            $data = $response->json();
            
            // Lưu dữ liệu (giả sử bạn có model Data)
            foreach ($data as $item) {
                Dubaochay::updateOrCreate(
                    ['id' => $item['id']], // Thay thế bằng trường duy nhất của bạn
                    [
                        'tentinh' => $item['pro_name'],
                        'tenhuyen' => $item['dis_name'],
                        //'ma_tram' => $item['ma_tram'],
                        'ngay' => $item['thoi_gian'],
                        'nhietdo' => $item['nhiet_do'],
                        'doam' => $item['do_am'],
                        //'tocdo_gio' => $item['tocdo_gio'],
                        //'huong_gio' => $item['huong_gio'],
                        'luongmua' => $item['luong_mua'],
                        //'do_cao' => $item['do_cao'],
                        'capdubao' => $item['cap_chay'],
                        // Có thể thêm các trường khác nếu cần
                    ]
                );
            }

            $this->info('Data fetched and stored successfully!');
        } else {
            $this->error('Failed to fetch data: ' . $response->status());
        }
    }
}
