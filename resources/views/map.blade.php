@vite(['resources/js/map.js', 'resources/js/chart.js'])
<x-layout class="fixed w-screen">
    <x-sidebar>
        <x-accordion title="Bản đồ nền">
            <x-checkbox tableName="rgxa" viTableName="Ranh giới xã" schemaName="geom" />
            {{-- <x-checkbox tableName="thuyhe" viTableName="Thuỷ hệ" schemaName="public" /> --}}
        </x-accordion>
        <x-accordion title="Bản đồ chuyên đề">
            <x-checkbox tableName="lorung" viTableName="Hiện trạng lô rừng" schemaName="lamnghiep" />
            <x-checkbox tableName="dubaochay" viTableName="Cảnh báo cháy rừng" schemaName="geom" />
            {{-- <x-checkbox tableName="biendong_dtrung" viTableName="Biến động diện tích rừng" schemaName="lamnghiep" />
            <x-checkbox tableName="" viTableName="Bản đồ CTDVMTR" schemaName="lamnghiep" /> --}}
        </x-accordion>
        {{-- <x-accordion title="Công tác">
            <x-checkbox tableName="" viTableName="Kế hoạch tuần tra và kiểm kê rừng" schemaName="geom" />
            <x-checkbox tableName="" viTableName="Vi phạm hành chính trong lâm nghiệp" schemaName="geom" />
        </x-accordion> --}}
    </x-sidebar>

    <div class="w-screen h-full sm:translate-x-0">

        <div id="map" class="h-full px-3 pb-4 overflow-y-auto"></div>
    </div>
    <!-- Spinner -->
    <x-spinner />
    <aside id="table"
        class="fixed right-0 z-40 w-4/5 h-[calc((100%-4.5rem)/3)] -bottom-58 transition-all duration-500 bg-white border-t border-gray-200"
        aria-label="Sidebar">
        <div class="flex">
            <div id="showcontainer" class="hidden">
                <button aria-label="open-tab" id="open-tab" onclick="showTab(true)"
                    class="border relative bottom-8 bg-white w-8 h-8 rounded-tr-lg items-center p-1">
                    <img width="32" height="32" src="{{ Vite::asset('resources/images/islide-up.png') }}"
                        alt="circled-chevron-up" />
                </button>
                <button aria-label="close-tab" id="close-tab" onclick="showTab(true)"
                    class="hidden border relative bottom-8 bg-white w-8 h-8 rounded-tr-lg items-center p-1">
                    <img width="32" height="32" src="{{ Vite::asset('resources/images/down-button.png') }}"
                        alt="circled-chevron-down" />
                </button>
            </div>
            <div id="showtab" class="hidden">
                <button aria-label="static-tab" id="static-tab"
                    class="border relative bottom-8 bg-white w-8 h-8 rounded-t-lg items-center p-1">
                    <img width="32" height="32" src="{{ Vite::asset('resources/images/graph.png') }}"
                        alt="external-Graph-virtual-keyboard-others-inmotus-design-2" />
                </button>
            </div>
            <div class="absolute w-full h-full">
                <div id="table-container" class="relative w-full h-full">
                    <div class="flex flex-item items-center justify-between p-2 h-10">
                        <h4 id="table-name" class="text-sm font-semibold leading-tight uppercase"></h4>
                        <button id="refresh" title="Xóa lựa chọn" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:shadow transition ease-in-out duration-150 border">Làm mới</button>
                        <div id="dubaochay-tool" class="flex space-x-2 hidden h-9">
                            <!-- Nút "Nhập Excel" luôn nằm ở đáy -->
                            <div class="flex justify-center truncate rounded-lg px-2">
                                <x-button href="{{ route('import.form') }}">Nhập Excel</x-button>
                            </div>
                            <select id="ngay" name="ngay"
                                class="border border-gray-300 text-sm rounded-lg leading-tight focus:outline block w-full p-2 text-wrap">
                                <option value="" disabled selected>Chọn ngày</option>
                                @foreach ($ngayList as $item)
                                    <option value="{{ str_replace('/', '-', $item) }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="lorung-tool" class="flex space-x-2 hidden h-9">
                            <select id="xa" name="xa"
                                class="border border-gray-300 text-sm rounded-lg leading-tight focus:outline block w-full p-2 text-wrap hidden">
                            </select>
                            
                            <select id="huyen" name="huyen"
                                class="border border-gray-300 text-sm rounded-lg leading-tight focus:outline block w-full p-2 text-wrap">
                                <option value="" disabled selected>Chọn Huyện</option>
                                @foreach ($huyenList as $item)
                                    <option value="{{ $item->mahuyen }}">{{ $item->tenhuyen }}</option>
                                @endforeach
                            </select>
                            <div id="searchForm" class="block relative">
                                <form class="flex items-center m-0 w-40 h-9 rounded-lg border block border-gray-300"
                                    method="GET" action="{{ route('lorung.index') }}">
                                    <input
                                        class="appearance-none ms-1 p-1 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"
                                        type="text" name="search" placeholder="Nhập số tờ, số lô,..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="h-full inset-y-0 right-0 flex items-center p-1">
                                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-white-500">
                                            <path
                                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="tables-container" class="overflow-y-auto h-[calc(100%-2.5rem)]">
                        <!-- Các bảng động sẽ được thêm vào đây -->
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Modal nổi bên ngoài -->
    <div id="modal"
        class="fixed right-0 top-12 bottom-6 bg-black bg-opacity-50 flex justify-start items-start hidden w-1/3 h-[calc((100%-4.5rem))] transition-all duration-500">
        <div class="bg-white p-5 rounded relative w-full h-full flex flex-col">
            <button id="close-modal" class="absolute top-2 right-2 text-gray-600">✖</button>
            <div class="flex justify-between items-center mt-4 space-x-2">
                <select id="chart-type"
                    class="flex border border-gray-300 text-sm rounded-lg leading-tight focus:outline-none  w-full p-2">
                    {{-- <option value="" disabled selected>Chọn Biểu đồ thống kê</option> --}}
                    <option value="dientich" selected>Biểu đồ Diện tích Lô Rừng</option>
                    <option value="soluong">Biểu đồ Số lượng Lô Rừng</option>
                </select>
                <select id="select-huyen"
                    class="flex border border-gray-300 text-sm rounded-lg leading-tight focus:outline  w-full p-2 text-wrap">
                    <option value="" disabled selected>Chọn Huyện</option>
                    @foreach ($huyenList as $item)
                        <option value="{{ $item->mahuyen }}">{{ $item->tenhuyen }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative w-full h-full">
                <canvas id="chart-canvas"></canvas>
            </div>
        </div>
    </div>

    <x-toast></x-toast>

    <script>
        let showcontainer = document.getElementById("showcontainer");
        let showtab = document.getElementById("showtab");
        let opentab = document.getElementById("open-tab");
        let closetab = document.getElementById("close-tab");
        let statictab = document.getElementById("static-tab");
        let tableContainer = document.getElementById("table-container");
        let modal = document.getElementById("modal");
        let closeModal = document.getElementById("close-modal");

        // Hàm xử lý đóng/mở container
        const showTab = (flag) => {
            if (flag) {
                Table.classList.toggle("-translate-y-full")
                opentab.classList.toggle("hidden");
                closetab.classList.toggle("hidden");

                if (modal.classList.contains("h-[calc((100%-4.5rem))]")) {
                    modal.classList.remove("h-[calc((100%-4.5rem))]");
                    modal.classList.add("h-[calc((100%-4.5rem)*2/3)]");
                } else {
                    modal.classList.remove("h-[calc((100%-4.5rem)*2/3)]");
                    modal.classList.add("h-[calc((100%-4.5rem))]");
                }
            }

        };

        // Hàm để mở modal khi nhấn static-tab
        const openModal = () => {
            modal.classList.toggle("hidden");
        };

        // Gán sự kiện click cho nút static-tab
        statictab.addEventListener('click', openModal);

        // Gán sự kiện click cho nút đóng modal
        closeModal.addEventListener('click', () => {
            modal.classList.add("hidden");
        });

        // Đóng modal khi nhấn ra ngoài modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });
    </script>
</x-layout>
