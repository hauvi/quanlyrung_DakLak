<x-layout class="fixed">

    <x-sidebar>
        <x-checkbox tableName="" viTableName="Lập kế hoạch tuần tra, kiểm kê rừng" schemaName="" />
       {{--  <x-checkbox tableName="" viTableName="Xử lý vi phạm hành chỉnh trong lâm nghiệp" schemaName="" /> --}}
    </x-sidebar>

    <x-form action="{{ route('kehoachtuantra.store') }}" title="Lập kế hoạch kiểm kê - tuần tra rừng"
        buttonText="Lưu kế hoạch">
        <!-- Cột biểu mẫu -->
        <div class="w-1/2 h-full overflow-y-auto px-4 py-2 rounded-l-lg border border-gray-300">
            @csrf
            <x-input id="ten" placeholder="Nhập kế hoạch" label="Tên kế hoạch" />
            <x-input id="mota" placeholder="Nhập mô tả" label="Mô tả" />
            <x-selectbox :options="$phanloai" placeholder="Chọn loại" label="Phân loại" name="phanloai"
                :valueCallback="function ($item) {
                    return $item->ten;
                }" />
            <div class="flex mb-2 justify-between">
                <div class="flex mr-2">
                    <x-calendar id="ngay" placeholder="Chọn ngày" label="Ngày tuần tra" />
                </div>
                <div class="flex">
                    <x-calendar id="ngaykt" placeholder="Chọn ngày" label="Ngày kết thúc" />
                </div>
            </div>
            <x-selectbox :options="$tram" placeholder="Chọn trạm" label="Trạm tuần tra" name="tram"
                :valueCallback="function ($item) {
                    return $item->ten;
                }" />
            <x-selectbox :options="$doi" placeholder="Chọn đội" label="Đội tuần tra" name="doi"
                :valueCallback="function ($item) {
                    return $item->ten;
                }" />
            <x-input id="nhomtruong" placeholder="Nhập tên nhóm trưởng" label="Nhóm trưởng" />
            <x-input id="thanhvien" placeholder="Nhập tên thành viên" label="Thành viên" />
            <x-selectbox :options="$phuongthuc" placeholder="Chọn phương thức di chuyển" label="Phương thức di chuyển"
                name="phuongthuc_dichuyen" :valueCallback="function ($item) {
                    return $item->ten;
                }" />
            <x-selectbox :options="$nhiemvu" placeholder="Chọn nhiệm vụ" label="Nhiệm vụ" name="nhiemvu"
                :valueCallback="function ($item) {
                    return $item->ten . ' - ' . $item->ten_vn;
                }" />
            <x-input id="muctieu" placeholder="Nhập mục tiêu" label="Mục tiêu" />

            <div class="flex mb-2">
                <label for="ghichu"
                    class="flex items-center flex-shrink-0 text-gray-700 text-sm font-bold bg-gray-200 w-28 rounded-l-lg px-2">Ghi
                    chú</label>
                <textarea id="ghichu" name="ghichu" placeholder="..."
                    class="border border-gray-300 text-gray-900 text-sm rounded-r-lg leading-tight focus:outline block w-full p-2"></textarea>
            </div>
        </div>
        <!-- Cột bản đồ -->
        <div class="w-1/3 h-full">
            <div id="map" class="w-full h-[575px] rounded-r-lg"></div>
            {{-- Nhập toạ độ từ excel --}}
            {{-- <div class="flex mt-2">
                            <label
                                class="flex items-center flex-shrink-0 text-gray-700 text-sm font-bold bg-gray-200  rounded-l-lg px-2"
                                for="user_avatar">Nhập toạ độ</label>
                            <input id="file-upload" type="file" name="file" accept=".xlsx, .csv"
                                class="hidden" onchange="updateFileName()">
                            <div class="flex w-full text-sm text-gray-900 border border-gray-300 focus:outline-none">
                                <span id="file-name" class="ml-4 my-auto text-gray-500">Chưa có tệp nào được
                                    chọn</span>
                            </div>
                            <button type="button" onclick="document.getElementById('file-upload').click()"
                                class="cursor-pointer ml-auto bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-r-lg whitespace-nowrap">
                                Chọn tệp
                            </button>
                        </div>
                        <div class="text-md">Chọn tệp Excel (.xlsx) hoặc CSV để nhập dữ liệu</div> --}}
        </div>
    </x-form>
    <x-spinner />
    <x-toast />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo bản đồ
            var map = L.map('map').setView([12.7748685, 108.084071], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Tạo nhóm các hình đã vẽ
            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            // Khởi tạo điều khiển vẽ
            var drawControl = new L.Control.Draw({
                position: 'topright',
                edit: {
                    featureGroup: drawnItems,
                    remove: true // Cho phép xóa hình
                },
                draw: {
                    polygon: false,
                    polyline: {
                        shapeOptions: {
                            color: 'red', // Màu của polyline
                        },
                    },
                    circle: false,
                    rectangle: false,
                    marker: true,
                    circlemarker: false
                }
            });
            map.addControl(drawControl);

            // Xử lý sự kiện khi tạo hình
            map.on(L.Draw.Event.CREATED, function(e) {
                var layer = e.layer;
                drawnItems.addLayer(layer);
                document.getElementById('geom').value = JSON.stringify(layer.toGeoJSON());
                // Kiểm tra nếu là polyline thì thêm mũi tên chỉ hướng
                if (e.layerType === 'polyline') {
                    layer.arrowheads({
                        size: '6px',
                        frequency: 'endonly', // Hiển thị mũi tên ở mỗi điểm cuối
                        fill: true,
                        fillOpacity: 0.6
                    });
                    // Cập nhật lại layer trong drawnItems để hiển thị mũi tên ngay lập tức
                    drawnItems.removeLayer(layer); // Loại bỏ layer cũ
                    drawnItems.addLayer(layer); // Thêm lại layer mới với mũi tên
                }
            });

            // Xử lý sự kiện chỉnh sửa
            map.on(L.Draw.Event.EDITED, function(e) {
                e.layers.eachLayer(function(layer) {
                    // Cập nhật lại geom khi chỉnh sửa
                    document.getElementById('geom').value = JSON.stringify(layer.toGeoJSON());
                });
            });

            // Đối tượng ánh xạ giữa tên trường và tên tiếng Việt
            const fieldNames = {
                'ten': 'Tên kế hoạch',
                //'mota': 'Mô tả',
                //'phanloai': 'Phân loại',
                'ngay': 'Ngày tuần tra',
                //'tram': 'Trạm tuần tra',
                //'doi': 'Đội tuần tra',
                //'nhomtruong': 'Nhóm trưởng',
                'thanhvien': 'Thành viên',
                //'phuongthuc_dichuyen': 'Phương thức di chuyển',
                'nhiemvu': 'Nhiệm vụ',
                //'muctieu': 'Mục tiêu'
            };

            // Xử lý sự kiện khi gửi biểu mẫu
            // Xử lý sự kiện khi gửi biểu mẫu
            const form = document.querySelector('form');
            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                // Hiển thị spinner khi bắt đầu gửi biểu mẫu
                toggleSpinner(true);
                // Lấy dữ liệu từ biểu mẫu
                const formData = new FormData(this);

                // Kiểm tra các trường input
                const requiredFields = Object.keys(fieldNames);
                for (let field of requiredFields) {
                    if (!formData.get(field)) {
                        showToast(`Vui lòng nhập ${fieldNames[field]}!`, 'bg-red-500');
                        toggleSpinner(false); // Ẩn spinner nếu có lỗi
                        return;
                    }
                }

                // Lấy dữ liệu GeoJSON
                let geomValue = document.getElementById('geom').value;
                if (!geomValue) {
                    showToast('Vui lòng tạo dữ liệu hình học trước khi lưu kế hoạch!', 'bg-red-500');
                    toggleSpinner(false); // Ẩn spinner nếu có lỗi
                    return;
                }

                try {
                    // Gửi yêu cầu Fetch
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    });

                    // Kiểm tra trạng thái phản hồi
                    if (!response.ok) {
                        // Phản hồi có lỗi
                        const errorText = await response.text();
                        showToast(`Lỗi: ${response.status} - Gửi biểu mẫu thất bại!`, 'bg-red-500');
                        toggleSpinner(false); // Ẩn spinner nếu có lỗi
                        return;
                    }

                    // Kiểm tra kiểu nội dung của phản hồi
                    if (response.headers.get('content-type')?.includes('application/json')) {
                        const data = await response.json();
                        showToast('Gửi biểu mẫu thành công!', 'bg-green-500');
                    } else {
                        // Không phải là JSON
                        const text = await response.text();
                        showToast('Phản hồi từ server không phải JSON!', 'bg-red-500');
                    }
                } catch (error) {
                    showToast('Đã xảy ra lỗi khi gửi biểu mẫu. Vui lòng thử lại!', 'bg-red-500');
                } finally {
                    toggleSpinner(false); // Đảm bảo spinner ẩn khi hoàn tất
                }
            });

        });
    </script>

</x-layout>
