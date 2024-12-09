@props(['vinameMap'])
<aside id="sidebar"
    class="fixed left-0 top-12 z-40 w-1/5 h-[calc(100%-4.5rem)] transform transition-transform duration-500 border-r border-gray-200"
    aria-label="Sidebar">
    <div class="h-full px-5 overflow-y-auto bg-white pt-3">
        @if (request()->is('map'))
            <!--sidebar trang map -->
            <div class="transition rounded-md my-2 border border-black">
                <!-- header -->
                <div
                    class="accordion-header cursor-pointer transition flex items-center h-8 space-x-1 bg-[#BEC2C5] rounded-md border-1 hover:bg-zinc-300">
                    <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                    <h3 class="font-semibold text-sm">Bản đồ nền</h3>
                </div>
                <!-- Content -->
                <div class="accordion-content px-6 pt-0 overflow-hidden max-h-28 space-y-2" style="max-height: 136px">
                    <div class="flex items-center">
                        <input id="rghanhchinh-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="rghanhchinh-checkbox" class="ms-2 text-sm font-medium">Ranh giới hành chính</label>
                    </div>
                    <div class="flex items-center">
                        <input id="thuyhe-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="thuyhe-checkbox" class="ms-2 text-sm font-medium">Thuỷ hệ</label>
                    </div>
                    <div class="flex items-center pb-2">
                        <input id="thuyhe-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="thuyhe-checkbox" class="ms-2 text-sm font-medium">Giao thông</label>
                    </div>
                </div>
            </div>
            <div class="transition rounded-md my-2 border border-black">
                <!-- header -->
                <div
                    class="accordion-header cursor-pointer transition flex items-center h-8 space-x-1 bg-[#BEC2C5] rounded-md border-1 hover:bg-zinc-300">
                    <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                    <h3 class="font-semibold text-sm">Bản đồ chuyên đề</h3>
                </div>
                <!-- Content -->
                <div class="accordion-content px-6 pt-0 overflow-hidden max-h-28 space-y-2" style="max-height: 136px">
                    <div class="flex items-center">
                        <input id="lorung-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="lorung-checkbox" class="ms-2 text-sm font-medium">Lô rừng</label>
                    </div>
                    <div class="flex items-center">
                        <input id="landsat-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="landsat-checkbox" class="ms-2 text-sm font-medium">Landsat</label>
                    </div>
                    <div class="flex items-center">
                        <input id="diemchay-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="diemchay-checkbox" class="ms-2 text-sm font-medium">Điểm cháy</label>
                    </div>
                </div>
            </div>
        @elseif(request()->is('data'))
            <!-- sidebar trang data -->
            @foreach ($vinameMap as $schemaName => $schemaData)
                <div class="transition rounded-md my-2">
                    <!-- Header -->
                    <div
                        class="accordion-header cursor-pointer transition flex items-center h-8 space-x-1 bg-[#BEC2C5] rounded-md border-1 hover:bg-zinc-300">
                        <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                        <h3 class="font-semibold text-sm">{{ $schemaData['vi_name'] }}</h3>
                    </div>
                    <!-- Content -->
                    <div class="accordion-content px-5 py-0 overflow-hidden max-h-0 space-y-2">
                        @foreach ($schemaData['tables'] as $tableName => $viTableName)
                            <div class="flex items-center">
                                <input id="{{ $tableName }}-checkbox" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded"
                                    data-schema="{{ $schemaName }}" data-table="{{ $tableName }}">
                                <label for="{{ $tableName }}-checkbox"
                                    class="ms-2 text-sm font-medium">{{ $viTableName }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @elseif(request()->is('admin'))
            <!-- Sidebar trang admin -->
            <div class="transition rounded-md my-2 border border-black">
                <!-- header -->
                <div
                    class="accordion-header cursor-pointer transition flex items-center h-8 space-x-1 bg-[#BEC2C5] rounded-md border-1 hover:bg-zinc-300">
                    <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                    <h3 class="font-semibold text-sm">Quản lý người dùng</h3>
                </div>
                <!-- Content -->
                <div class="accordion-content px-6 pt-0 overflow-hidden max-h-28 space-y-2" style="max-height: 136px">
                    <div class="flex items-center">
                        <input id="rghanhchinh-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="rghanhchinh-checkbox" class="ms-2 text-sm font-medium">Phòng ban</label>
                    </div>
                    <div class="flex items-center">
                        <input id="thuyhe-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="thuyhe-checkbox" class="ms-2 text-sm font-medium">Người dùng</label>
                    </div>
                    <div class="flex items-center pb-2">
                        <input id="thuyhe-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="thuyhe-checkbox" class="ms-2 text-sm font-medium">Phân quyền</label>
                    </div>
                </div>
            </div>
           {{--  <x-schema>Quản lý người dùng</x-schema>
            <ul id="dropdown-example" class=" pace-y-2">
                <x-sidebar-link>Phòng ban</x-sidebar-link>
                <x-sidebar-link>Người dùng</x-sidebar-link>
                <x-sidebar-link>Phân quyền</x-sidebar-link>
            </ul> --}}
        @endif
    </div>
</aside>
<script>
    const accordionHeader = document.querySelectorAll(".accordion-header");
    accordionHeader.forEach((header) => {
        header.addEventListener("click", function() {
            const accordionContent = header.parentElement.querySelector(".accordion-content");
            let accordionMaxHeight = accordionContent.style.maxHeight;

            // Condition handling
            if (accordionMaxHeight == "0px" || accordionMaxHeight.length == 0) {
                accordionContent.style.maxHeight = `${accordionContent.scrollHeight + 32}px`;
                header.parentElement.classList.add("border");
                header.parentElement.classList.add("border-black");
            } else {
                accordionContent.style.maxHeight = `0px`;
                header.parentElement.classList.remove("border");
                header.parentElement.classList.remove("border-black");
            }
        });
    });
</script>
