@vite([/* 'resources/js/chart.js', */ 'resources/js/table.js'])
<x-layout class="fixed">
    <x-sidebar>
        <x-accordion title="Lâm nghiệp" class="accordion">
            <x-checkbox tableName="lorung" viTableName="Lô rừng" schemaName="lamnghiep" />
            <x-checkbox tableName="doituong" viTableName="Đối tượng" schemaName="lamnghiep" />
            <x-checkbox tableName="loaidatloairung" viTableName="Phân loại đất, rừng" schemaName="lamnghiep" />
            <x-checkbox tableName="biendong_dtrung" viTableName="Biến động diện tích rừng" schemaName="lamnghiep" />
        </x-accordion>
        <x-accordion title="Diễn biến">
            <x-checkbox tableName="loai" viTableName="Loại diễn biến rừng" schemaName="dienbien" />
            <x-checkbox tableName="nhom" viTableName="Nhóm diễn biến rừng" schemaName="dienbien" />
            <x-checkbox tableName="huong" viTableName="Hướng diễn biến rừng" schemaName="dienbien" />
        </x-accordion>
        <x-accordion title="Nguồn gốc">
            <x-checkbox tableName="rung" viTableName="Nguồn gốc rừng" schemaName="nguongoc" />
            <x-checkbox tableName="rungtrong" viTableName="Nguồn gốc rừng trồng" schemaName="nguongoc" />
        </x-accordion>
        <x-accordion title="Mục đích sử dụng">
            <x-checkbox tableName="phanloaichinh" viTableName="Phân loại chính" schemaName="mucdichsd" />
            <x-checkbox tableName="phanloaiphu" viTableName="Phân loại phụ" schemaName="mucdichsd" />
        </x-accordion>
        <x-accordion title="Tình trạng">
            <x-checkbox tableName="thanhrung" viTableName="Tình trạng thành rừng" schemaName="tinhtrang" />
            <x-checkbox tableName="lapdia" viTableName="Tình trạng lập địa" schemaName="tinhtrang" />
            <x-checkbox tableName="tranhchap" viTableName="Tình trạng tranh chấp" schemaName="tinhtrang" />
            <x-checkbox tableName="quyensudungdat" viTableName="Tình trạng quyền sừ dụng đất" schemaName="tinhtrang" />
            <x-checkbox tableName="khoanbaoverung" viTableName="Tình trạng khoán bảo vệ rừng" schemaName="tinhtrang" />
            <x-checkbox tableName="quyhoach" viTableName="Tình trạng quy hoạch" schemaName="tinhtrang" />
            <x-checkbox tableName="nguyensinh" viTableName="Tình trạng nguyên sinh" schemaName="tinhtrang" />
        </x-accordion>
    </x-sidebar>

    <x-spinner />

    <div class="bg-gray-200 fixed right-0 z-40 h-[calc(100%-4.5rem)] w-4/5 px-3 pt-4 transition-all duration-500" id="intro">
        <!-- Thông tin giới thiệu hiển thị khi trang vừa tải -->
        <div id="intro-message" class="p-12 flex flex-col items-center">
            <img src="{{ Vite::asset('resources/images/apple-touch-icon.png') }}" alt="Table Icon">
            <div class="text-center">
                <p class="text-lg text-gray-800 font-semibold">Khám phá thông tin chi tiết về rừng Đăk Lăk</p>
                <p class="text-gray-600">Chọn một lớp dữ liệu bạn quan tâm để xem thông tin chi tiết.</p>
            </div>
        </div>
    </div>
    <div class="fixed right-0 z-40 h-[calc(100%-4.5rem)] w-4/5 px-3 pt-4 transition-all duration-500 hidden"
        id="table">
        <!-- Tabs -->
        <x-tab>
            <x-tab-item href="#info" active="true">Thông tin</x-tab-item>
            {{--  <x-tab-item href="#static" active="">Thống kê</x-tab-item> --}}
            {{-- <x-tab-item href="#import" active="">Nhập liệu</x-tab-item> --}}
        </x-tab>

        <!-- Tab Contents -->
        <div id="tab-contents">
            <div id="info" class="p-4">
                <div id="info-content" class="h-full px-4">
                    <!-- component -->
                    <div class="container top-0">
                        <div class="flex flex-item items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <h2 id="table-name" class="text-lg font-semibold leading-tight uppercase"></h2>
                                <button id="add-new-btn" class="flex items-center font-semibold group">
                                    <img src="{{ Vite::asset('resources/images/plus.png') }}" width="20"
                                        height="20" alt="add--v1"
                                        class="transform transition-transform duration-300 group-hover:rotate-180" />
                                </button>
                            </div>

                            {{-- <x-search /> --}}
                        </div>

                        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2">
                            <div class="inline-block w-full shadow rounded-lg">
                                <div id="table-container" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <!-- Bảng dữ liệu sẽ được tạo ra ở đây -->
                                </div>
                                <!-- Container để chứa form chỉnh sửa -->
                                <div id="edit-form-container" class="hidden overflow-y-auto max-h-[70vh]">
                                </div>
                                <div id="pagination-container"
                                    class="sticky bottom-4 left-0 transform -translate-x-1/2 z-10 bg-white shadow-lg">
                                    <!-- Pagination sẽ được tạo ra ở đây -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <x-modal id="advanced-search-modal">
                    <h3 class="text-lg font-semibold mb-4">Tìm kiếm nâng cao</h3>
                    <div>
                        <label class="block mb-2">Điều kiện 1:</label>
                        <input type="text" class="block w-full mb-4 px-3 py-2 border border-gray-300 rounded" />
                        <label class="block mb-2">Điều kiện 2:</label>
                        <input type="text" class="block w-full mb-4 px-3 py-2 border border-gray-300 rounded" />
                        <button
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-700">
                            Tìm kiếm
                        </button>
                    </div>
                </x-modal>
                <!-- Modal -->
                <x-modal id="confirm-modal">
                    <h3 class="text-lg font-semibold mb-4">Xác nhận xóa</h3>
                    <p class="mb-4">Bạn có chắc chắn muốn xóa mục này?</p>
                    <div class="flex justify-end">
                        <button id="confirm-delete-btn"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Xóa</button>
                        <button id="cancel-delete-btn"
                            class="ml-2 bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">Hủy</button>
                    </div>
                </x-modal>
                {{-- <div id="confirm-modal"
                    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                        <h3 class="text-lg font-semibold mb-4">Xác nhận xóa</h3>
                        <p class="mb-4">Bạn có chắc chắn muốn xóa mục này?</p>
                        <div class="flex justify-end">
                            <button id="confirm-delete-btn"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Xóa</button>
                            <button id="cancel-delete-btn"
                                class="ml-2 bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">Hủy</button>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div id="static" class="hidden p-4">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div> --}}
            <div id="import" class="hidden p-4">
                <div id="intro-message" class="p-12 flex flex-col items-center">
                    <x-import-form />
                </div>
            </div>
        </div>
    </div>

    <x-toast />

</x-layout>

<script>
    $(document).ready(function() {
        // Khi checkbox được chọn
        $('input[type="checkbox"]').on('change', function() {
            // Nếu có checkbox nào được chọn
            if ($('input[type="checkbox"]:checked').length > 0) {
                // Ẩn thông báo giới thiệu và hiển thị bảng
                $('#intro').addClass('hidden');
                $('#table').removeClass('hidden');
            } else {
                // Nếu không có checkbox nào được chọn, hiển thị lại thông báo
                $('#intro').removeClass('hidden');
                $('#table').addClass('hidden');
            }
        });
    });

    /* Chuyển tab */
    let tabsContainer = document.querySelector("#tabs");
    let tabTogglers = tabsContainer.querySelectorAll("#tabs a");

    tabTogglers.forEach(function(toggler) {
        toggler.addEventListener("click", function(e) {
            e.preventDefault();

            let tabName = this.getAttribute("href");
            let tabContents = document.querySelector("#tab-contents");

            for (let i = 0; i < tabContents.children.length; i++) {
                tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l",
                    "-mb-px", "bg-white");
                tabContents.children[i].classList.remove("hidden");
                if ("#" + tabContents.children[i].id === tabName) {
                    continue;
                }
                tabContents.children[i].classList.add("hidden");
            }
            e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px",
                "bg-white");

        });
    });

    /* Bật tắt modal tìm kiếm */
    $(document).ready(function() {
        // Hiển thị modal khi nhấn nút "Advanced Search"
        $('#advanced-search-btn').on('click', function() {
            $('#advanced-search-modal').removeClass('hidden');
        });

        // Ẩn modal khi nhấn nút đóng
        $('#close-modal-btn').on('click', function() {
            $('#advanced-search-modal').addClass('hidden');
        });

        // Ẩn modal khi nhấn ra ngoài modal (optional)
        $('#advanced-search-modal').on('click', function(e) {
            if ($(e.target).is('#advanced-search-modal')) {
                $('#advanced-search-modal').addClass('hidden');
            }
        });
    });
</script>
