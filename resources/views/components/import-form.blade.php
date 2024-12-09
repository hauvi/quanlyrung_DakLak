<form id="import-form" class="max-w-lg mx-auto">
    @csrf
    <div class="mt-12 flex flex-col items-center space-y-3">
        <label id="table-name-label" class="block mb-2 text-lg font-medium text-gray-900 font-md uppercase"></label>
        <input id="file-upload" type="file" name="file" accept=".xlsx, .csv" class="hidden"
            onchange="updateFileName()">
        <div class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
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

<script>
$(document).on('change', 'input[type="checkbox"]', function () {
    $('input[type="checkbox"]').not(this).prop('checked', false);
    if (this.checked) {
        var currentSchema = $(this).data('schema');
        var currentTable = $(this).data('table');
        fetchData(`/api/${currentSchema}/${currentTable}`, currentSchema, currentTable);
        $('#table-container').show();
        $('#edit-form-container').addClass('hidden');
    } else {
        $('#table-container').empty().hide();
    }
});

function fetchData(endpoint, schema, table) {
    toggleSpinner(true);
    $.ajax({
        url: endpoint,
        method: 'GET',
        success: function (response) {
            toggleSpinner(false);
            console.log(response); // Kiểm tra dữ liệu trả về
            var data = response.data;
            var fieldNameMap = response.field_names;
            var tableName = response.table_name.tableName; // Lấy tableName

            $('#table-name-label').text(`Nhập ${tableName}`); // Hiển thị tableName trong label
        },
        error: function () {
            toggleSpinner(false);
        }
    });
}
</script>
