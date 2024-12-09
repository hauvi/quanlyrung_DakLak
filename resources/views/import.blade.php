<x-layout class="fixed w-screen">
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form id="import-form" class="max-w-lg mx-auto">
        @csrf
        <div class="relative mt-12 flex flex-col items-center space-y-3">
            <label class="block mb-2 text-lg font-medium text-gray-900 font-md" for="user_avatar">Nhập dữ liệu Cảnh báo
                cháy rừng</label>
            <input id="file-upload" type="file" name="file" accept=".xlsx, .csv" class="hidden"
                onchange="updateFileName()">
            <div
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
                <button type="button" onclick="document.getElementById('file-upload').click()"
                    class="cursor-pointer bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-l-lg">
                    Chọn tệp
                </button>
                <span id="file-name" class="ml-4 text-gray-500">Chưa có tệp nào được chọn</span>
            </div>
            <div class="mt-1 text-md">Chọn tệp Excel (.xlsx) hoặc CSV để nhập dữ liệu</div>
        </div>
        <div class="flex justify-center mt-4">
            <button type="button" onclick="previewFile()"
                class="bg-emerald-600 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Xem trước
            </button>
        </div>
    </form>

    {{-- Spinner --}}
    <x-spinner />

    <!-- Modal -->
    <div id="preview-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg max-w-4xl w-full"> <!-- Tăng chiều rộng của modal -->
            <h3 class="text-lg font-medium">Dữ liệu sẽ được nhập:</h3>
            <div class="max-h-96 overflow-y-auto">
                <table id="preview-table" class="min-w-full border border-gray-300 mt-4">
                    <thead>
                        <tr>
                            <th class="border">Tỉnh</th>
                            <th class="border">Huyện</th>
                            <th class="border">Nhiệt độ</th>
                            <th class="border">Độ ẩm</th>
                            <th class="border">Lượng mưa</th>
                            <th class="border">Cấp dự báo</th>
                            <th class="border">Ngày</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="flex justify-end mt-4">
                <button onclick="closeModal()"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Đóng
                </button>
                <button type="button" id="confirm-import"
                    class="ml-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
                    onclick="confirmImport()">
                    Xác nhận nhập
                </button>
            </div>
        </div>
    </div>
    <x-toast />
    <script>
        function updateFileName() {
            const input = document.getElementById('file-upload');
            const fileNameDisplay = document.getElementById('file-name');

            if (input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Chưa có tệp nào được chọn';
            }
        }

        function previewFile() {
            const formData = new FormData(document.getElementById('import-form'));
            // Hiển thị spinner
            toggleSpinner(true);

            fetch("{{ route('import.preview') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Gửi token CSRF
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    //console.log(data); // Kiểm tra dữ liệu
                    const tbody = document.querySelector('#preview-table tbody');
                    tbody.innerHTML = ""; // Xóa nội dung cũ
                    // Ẩn spinner
                    toggleSpinner(false);

                    const dataArray = data[0] || []; // Lấy mảng con đầu tiên, hoặc một mảng rỗng nếu không có

                    // Duyệt qua dữ liệu và thêm vào bảng
                    dataArray.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                    <td class="border">${row.tinh || ''}</td>
                    <td class="border">${row.huyen || ''}</td>
                    <td class="border">${row.nhiet_do || ''}</td>
                    <td class="border">${row.do_am || ''}</td>
                    <td class="border">${row.luong_mua || ''}</td>
                    <td class="border">${row.cap_du_bao || ''}</td>
                    <td class="border">${row.ngay || ''}</td>
                `;
                        tbody.appendChild(tr);
                    });

                    if (dataArray.length === 0) {
                        const tr = document.createElement('tr');
                        tr.innerHTML =
                            `<td colspan="7" class="border text-center">Không có dữ liệu nào để hiển thị</td>`;
                        tbody.appendChild(tr);
                    }

                    // Hiển thị modal
                    document.getElementById('preview-modal').classList.remove('hidden');
                    showToast('Tải lên dữ liệu thành công!', 'bg-green-500');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Đã xảy ra lỗi khi tải lên dữ liệu!', 'bg-red-500');
                    // Ẩn spinner
                    toggleSpinner(false);
                });
        }

        function closeModal() {
            document.getElementById('preview-modal').classList.add('hidden');
        }

        function confirmImport() {
            const formData = new FormData(document.getElementById('import-form'));

            fetch("{{ route('import') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Nếu phản hồi không phải JSON, sẽ bị lỗi ở đây
                })
                .then(data => {
                    showToast('Nhập dữ liệu thành công!', 'bg-green-500');
                    location.reload(); // Tải lại trang sau khi thành công
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Nhập dữ liệu thất bại!', 'bg-green-500');
                });
        }
    </script>
</x-layout>
