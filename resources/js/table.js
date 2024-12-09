$(document).ready(function () {
    var currentSchema = null;
    var currentTable = null;

    $(document).on('change', 'input[type="checkbox"]', function () {
        $('input[type="checkbox"]').not(this).prop('checked', false);
        if (this.checked) {
            currentSchema = $(this).data('schema');
            currentTable = $(this).data('table');
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
                var data = response.data;
                var fieldNameMap = response.field_names;
                var tableName = response.table_name.tableName;

                var tableContainer = $('#table-container').empty();
                $('#table-name').text(tableName);

                const headers = (data?.data?.length) ? Object.keys(data.data[0]) : (fieldNameMap ? Object.keys(fieldNameMap) : []); // Sử dụng optional chaining và mặc định là mảng rỗng
                let headerRow = headers.length
                    ? '<tr><th class="sticky left-0 px-2 py-1 border-b-2 border-gray-200 border-r bg-gray-100 text-left text-sm font-semibold text-gray-600 truncate tracking-wide w-24 ">Tuỳ chọn</th>'
                    : '';
                headerRow += headers.map(header => `<th class="px-2 py-1 border-b-2 border-gray-200 border-r bg-gray-100 text-left text-sm font-semibold text-gray-600 truncate tracking-wider">${fieldNameMap[header] || header}</th>`).join('');
                headerRow += '</tr>';

                let tableHTML = `<table class="w-full text-sm text-left min-w-full leading-normal"><thead class="text-xs text-gray-700 uppercase">${headerRow}</thead><tbody>`;
                if (data?.data?.length) {
                    tableHTML += data.data.map(item => {
                        const id = item['id'];
                        const updateLink = `/api/${schema}/${table}/${id}`;
                        const deleteLink = `/api/${schema}/${table}/${id}`;
                        return `<tr class="border-b hover:bg-gray-50">
                      <td class="sticky left-0 px-2 py-1 border-b border-r border-gray-200 text-sm truncate bg-gray-100">
                          <div class="flex items-center space-x-2">
                              <button class="update-link flex items-center font-semibold group" data-update-link="${updateLink}">
                                  <img class="transform transition-transform duration-300 group-hover:skew-x-12 group-hover:translate-x-0.5 origin-top-right" width="16" height="16" src="https://img.icons8.com/material/24/edit--v1.png" alt="edit--v1"/>
                              </button>
                              <span>|</span>
                              <button class="delete-link flex items-center font-semibold group text-red-500" data-delete-link="${deleteLink}">
                                  <img class="transform transition-transform duration-300 group-hover:-skew-y-12 origin-top-left" width="16" height="16" src="https://img.icons8.com/material-rounded/20/waste.png" alt="waste"/>        
                              </button>
                          </div>
                      </td>
                      ${headers.map(header => `<td class="px-2 py-1 border-b border-r border-gray-200 text-sm truncate"><p class="text-gray-900 whitespace-no-wrap">${item[header] || ''}</p></td>`).join('')}
                    </tr>`;
                    }).join('');
                } else {
                    tableHTML += `<tr><td colspan="${headers.length + 1}" class="text-center text-gray-500 py-2">Không có dữ liệu phù hợp</td></tr>`;
                }
                tableHTML += '</tbody></table>';
                tableContainer.html(tableHTML);

                if (data?.links?.length > 3) { // Sử dụng optional chaining
                    let paginationHTML = '<nav class="sticky left-0 flex my-2 text-sm pagination">';
                    paginationHTML += data.links.map(link => {
                        const linkText = (link.label === 'Next &raquo;') ? '&raquo;' : ((link.label === '&laquo; Previous') ? '&laquo;' : link.label);
                        return `<a href="${link.url}" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 mx-1">${linkText}</a>`;
                    }).join('');
                    paginationHTML += '</nav>';
                    tableContainer.append(paginationHTML);
                }
                $('#edit-form-container').addClass('hidden');
                $('#info-content').removeClass('hidden');
            },
            error: function () {
                toggleSpinner(false);
            }
        });
    }

    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        if (url) {
            fetchData(url, currentSchema, currentTable);
        }
    });

    let deleteUrl;

    $(document).on('click', '.delete-link', function (event) {
        event.preventDefault();
        deleteUrl = $(this).data('delete-link');
        $('#confirm-modal').removeClass('hidden');
    });

    $('#confirm-delete-btn').on('click', async () => {
        try {
            const response = await $.ajax({
                url: deleteUrl,
                method: 'DELETE',
            });
            showToast('Xóa thành công!', 'bg-green-500');
            $('#confirm-modal').addClass('hidden');
            fetchData(`/api/${currentSchema}/${currentTable}`, currentSchema, currentTable);
        } catch (error) {
            showToast('Có lỗi xảy ra khi xóa.', 'bg-red-500');
            $('#confirm-modal').addClass('hidden');
            console.error(error); // In ra lỗi cụ thể cho việc debug
        }
    });

    $('#cancel-delete-btn').on('click', () => {
        $('#confirm-modal').addClass('hidden');
    });

    $(document).on('click', '.update-link', (event) => {
        event.preventDefault();
        var updateUrl = $(this).data('update-link');
        var url = new URL(updateUrl, window.location.origin);
        var schema = url.pathname.split('/')[2];
        var table = url.pathname.split('/')[3];
        clearTableAndFetchEditForm(updateUrl, schema, table);
    });

    async function clearTableAndFetchEditForm(url, schema, table) {
        $('#table-container').empty();
        toggleSpinner(true);
        try {
            const response = await $.ajax({
                url: url,
                method: 'GET',
            });

            toggleSpinner(false);

            if (!response.data || !response.field_names) {
                alert("Dữ liệu chỉnh sửa không khả dụng.");
                return;
            }

            populateEditForm(response.data, response.field_names, schema, table);
            $('#table-container').addClass('hidden');
            $('#edit-form-container').removeClass('hidden');
        } catch (error) {
            toggleSpinner(false);
            alert("Có lỗi xảy ra khi lấy dữ liệu chỉnh sửa.");
            console.error(error); // In ra lỗi cụ thể cho việc debug
        }
    }

    function populateEditForm(data, fieldNames, schema, table) {
        if (!data || !fieldNames) {
            showToast('Dữ liệu để chỉnh sửa không khả dụng.', 'bg-orange-500');
            return;
        }

        const formActionUrl = `/api/${schema}/${table}/${data.id}`;
        let formHTML = `<form id="edit-form" method="POST" action="${formActionUrl}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">`;

        for (const field in data) {
            if (field === 'id' || field === 'geom' || field === 'updated_at' || field === 'created_at') {
                continue; // Bỏ qua các trường không cần chỉnh sửa
            }

            const fieldName = fieldNames[field] || field;
            const fieldValue = data[field] || '';

            formHTML += `<div class="flex m-2">
                <label for="${field}" class="flex items-center justify-center flex-shrink-0 text-gray-700 text-sm font-bold bg-gray-200 w-48 rounded-l-lg px-2">${fieldName}</label>
                <input type="text" id="${field}" name="${field}" value="${fieldValue}" class="border border-gray-300 text-gray-900 text-sm rounded-r-lg leading-tight focus:outline-none focus:border-gray-200 focus:ring-1 focus:ring-gray-500 block w-full p-2">
            </div>`;
        }
        formHTML += `<div id="edit-form-container" class="flex justify-center py-2">
            <button type="submit" class="bg-emerald-600 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Cập nhật</button>
            <span class="border-s-2 m-2 border-black"></span>
            <button type="button" id="cancel-btn" class="bg-gray-200 border-s font-bold py-2 px-4 rounded hover:bg-stone-300">Hủy</button></div>
        </form>`;
        $('#edit-form-container').html(formHTML);

        $('#edit-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var formActionUrl = $(this).attr('action');

            $.ajax({
                url: formActionUrl,
                method: 'PUT',
                data: formData,
                success: function (response) {
                    showToast('Cập nhật thành công!', 'bg-green-500');
                    $('#edit-form-container').addClass('hidden');
                    $('#table-container').removeClass('hidden');
                    if (currentSchema && currentTable) {
                        fetchData(`/api/${currentSchema}/${currentTable}`, currentSchema, currentTable);
                    }
                },
                error: function () {
                    showToast('Có lỗi xảy ra khi cập nhật.', 'bg-red-500');
                }
            });
        });
    }

    $(document).on('click', '#add-new-btn', () => {
        var schema = $('input[type="checkbox"]:checked').data('schema');
        var table = $('input[type="checkbox"]:checked').data('table');
        var formActionUrl = `/api/${schema}/${table}`;
        $('#table-container').addClass('hidden');
        $('#edit-form-container').removeClass('hidden');
        clearTableAndFetchAddForm(formActionUrl);
    });

    async function clearTableAndFetchAddForm(formActionUrl) {
        $('#table-container').empty();
        toggleSpinner(true);
        try {
            const response = await $.ajax({
                url: formActionUrl,
                method: 'GET',
            });

            toggleSpinner(false);

            if (!response.field_names) { // Kiểm tra trực tiếp response.field_names
                alert("Không tìm thấy trường dữ liệu");
                return;
            }
            populateAddForm(response.field_names, formActionUrl);
            $('#table-container').addClass('hidden');
            $('#edit-form-container').removeClass('hidden');
        } catch (error) {
            toggleSpinner(false);
            alert("Có lỗi xảy ra khi lấy trường dữ liệu.");
            console.error(error); // In ra lỗi cụ thể cho việc debug
        }
    }

    function populateAddForm(fieldNames, formActionUrl) {
        var formHTML = `<form id="add-form" method="POST" action="${formActionUrl}"><input type="hidden" name="_method" value="POST"><input type="hidden" name="_token" value="{{ csrf_token() }}">`;
        for (const field in fieldNames) {
            if (field === 'id' || field === 'geom' || field === 'updated_at' || field === 'created_at') {
                continue; // Bỏ qua các trường không cần thiết
            }

            const fieldName = fieldNames[field];
            formHTML += `
            <div class="flex m-2">
                <label class="flex items-center justify-center flex-shrink-0 text-gray-700 text-sm font-bold bg-gray-200 w-48 rounded-l-lg px-2">${fieldName}:</label>
                <input type="text" name="${field}" class="border border-gray-300 text-gray-900 text-sm rounded-r-lg leading-tight focus:outline-none focus:border-gray-200 focus:ring-1 focus:ring-gray-500 block w-full p-2">
            </div>`;
        }

        formHTML += `
       <div id="edit-form-container" class="flex justify-center py-2">
         <button type="submit" class="bg-emerald-600 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Thêm mới</button>
            <span class="border-s-2 m-2 border-black"></span>
            <button type="button" id="cancel-btn" class="bg-gray-200 border-s font-bold py-2 px-4 rounded hover:bg-stone-300">Hủy</button></div>
        </form>`;

        $('#edit-form-container').html(formHTML);

        $('#add-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var formActionUrl = $(this).attr('action');

            $.ajax({
                url: formActionUrl,
                method: 'POST',
                data: formData,
                success: function (response) {
                    showToast('Thêm mới thành công!', 'bg-green-500');
                    $('#edit-form-container').addClass('hidden');
                    $('#table-container').removeClass('hidden');
                    if (currentSchema && currentTable) {
                        fetchData(`/api/${currentSchema}/${currentTable}`, currentSchema, currentTable);
                    }
                },
                error: function () {
                    showToast('Có lỗi xảy ra khi thêm mới.', 'bg-red-500');
                }
            });
        });
    }

    $(document).on('click', '#cancel-btn', function () {
        $('#edit-form-container', '#add-form-container').addClass('hidden');
        $('#table-container').removeClass('hidden');
        if (currentSchema && currentTable) {
            fetchData(`/api/${currentSchema}/${currentTable}`, currentSchema, currentTable);
        }
    });

    $('#table-container').hide();
    $('#edit-form').addClass('hidden');
});