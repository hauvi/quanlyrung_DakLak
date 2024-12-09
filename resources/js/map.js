import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import L from 'leaflet';
import 'leaflet.markercluster';
import 'leaflet-geoserver-request';


let polygonsLayer, rghuyenLayer, rgxaLayer, lorungLayer, lorung_xaLayer;

/* Create map */
const baselayers = {
    "ESRI": L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; <a href="http://www.esri.com/">Esri</a>',
        maxZoom: 18
    }),
};

const map = L.map('map', {
    center: [12.7748685, 108.084071],
    zoom: 9,
    minZoom: 9,
    layers: [L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; <a href="http://www.esri.com/">Esri</a>',
        maxZoom: 18
    })],
    zoomControl: false
});

/* End create map */


function fetchAndDisplayData(url, displayFunction) {
    toggleSpinner(true);
    fetch(url)
        .then(response => response.json())
        .then(data => displayFunction(data))
        .catch(error => console.error('Error:', error))
        .finally(() => toggleSpinner(false));
}

function displayRgHuyen(data) {
    if (rghuyenLayer) map.removeLayer(rghuyenLayer);
    rghuyenLayer = L.geoJSON(data, {
        style: () => ({ color: '#fff', weight: 2, fillOpacity: 0 }),
    }).addTo(map);
    rghuyenLayer.bringToFront();
}

function displayRXa(data) {
    if (rgxaLayer) map.removeLayer(rgxaLayer);

    rgxaLayer = L.geoJSON(data, {
        style: (feature) => ({
            color: '#fff', // Màu viền
            weight: 1,
            fillColor: generateColorByMahuyen(feature.properties.mahuyen, feature.properties.maxa),
            fillOpacity: 1 // Độ trong suốt của nền
        }),
        onEachFeature: (feature, layer) => {
            // Thêm tên huyện vào popup
            const popupContent = `<strong>Xã:</strong> ${feature.properties.tenxa}<br>
                                  <strong>Huyện:</strong> ${feature.properties.tenhuyen}`;
            layer.bindPopup(popupContent);
        }
    }).addTo(map);
}

// Tạo màu sắc riêng cho các xã trong cùng một huyện
const colorCache = {}; // Lưu trữ mã màu cho từng `mahuyen`
const colorPalette = ['#FF7F50', '#87CEFA', '#32CD32', '#FFD700', '#DA70D6', '#6A5ACD', '#FF4500'];

function generateColorByMahuyen(mahuyen, maxa) {
    if (!colorCache[mahuyen]) {
        colorCache[mahuyen] = {};
    }

    if (!colorCache[mahuyen][maxa]) {
        const colorIndex = Object.keys(colorCache[mahuyen]).length % colorPalette.length;
        colorCache[mahuyen][maxa] = colorPalette[colorIndex];
    }

    return colorCache[mahuyen][maxa];
}

function displayxaLorung(data) {
    if (lorung_xaLayer) map.removeLayer(lorung_xaLayer);
    lorung_xaLayer = L.geoJSON(data, {
        style: () => ({ color: '#fff', weight: 1, fillColor: '#a4e39d', fillOpacity: 1 }),
    }).addTo(map);
    // Zoom đến lớp lorungLayer sau khi thêm vào bản đồ
    if (lorung_xaLayer.getBounds().isValid()) {
        const bounds = lorung_xaLayer.getBounds();
        const paddingBottom = map.getSize().y / 3;
        const paddingLeft = map.getSize().x / 5;

        map.fitBounds(bounds, {
            paddingTopLeft: [paddingLeft, 0],
            paddingBottomRight: [0, paddingBottom]
        });
    } else {
        console.warn("Lớp lorung_xaLayer không có dữ liệu geometry hợp lệ để zoom.");
    }
}

/* Fetch polygon */
function displayPolygons(data) {
    if (polygonsLayer) map.removeLayer(polygonsLayer);

    // Tạo một bản sao của dữ liệu để không ảnh hưởng đến bảng
    const mapData = JSON.parse(JSON.stringify(data));

    // Tạo một danh sách các huyện từ lớp rghuyen
    const huyenList = [];
    const huyenGeometryMap = {};

    // Lấy thông tin huyện từ rghuyenLayer
    rghuyenLayer.eachLayer(layer => {
        huyenList.push(layer.feature.properties.tenhuyen);
        huyenGeometryMap[layer.feature.properties.tenhuyen] = layer.feature.geometry;
    });

    // Kiểm tra huyện nào chưa có trong dữ liệu dự báo
    huyenList.forEach(huyen => {
        if (!data.features.some(feature => feature.properties.tenhuyen === huyen)) {
            mapData.features.push({
                type: "Feature",
                properties: {
                    tenhuyen: huyen,
                    dubaochay: "N/A",
                    nhietdo: "N/A",
                    doam: "N/A",
                    luongmua: "N/A",
                    capdubao: "N/A",
                    ngay: "N/A"
                },
                geometry: huyenGeometryMap[huyen]
            });
        }
    });

    // Hàm lấy màu dựa trên cấp dự báo
    const getColor = (capdubao) => {
        switch (capdubao) {
            case 'I': return '#EE7C6B';
            case 'II': return '#E54646';
            case 'III': return '#DF0029';
            case 'IV': return '#B2001F';
            case 'V': return '#8B0016';
            default: return '#FCDAD5';
        }
    };

    polygonsLayer = L.geoJSON(mapData, { // Sử dụng mapData cho polygonsLayer
        style: feature => ({
            color: "#fff",
            fillColor: feature.properties.capdubao ? getColor(feature.properties.capdubao) : getColorForArea(parseFloat(feature.properties.total_area)),
            weight: 2,
            fillOpacity: 1
        }),
        onEachFeature: (feature, layer) => {
            const popupContent = `
                <div class="flex items-center justify-between p-2 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-black">
                        Thông tin dự báo ${feature.properties.tenhuyen}
                    </h3>
                </div>
                <div class="px-2">
                    ${feature.properties.nhietdo ? `
                        <p class="text-base leading-relaxed text-black">
                            <strong>Nhiệt độ (℃):</strong> ${feature.properties.nhietdo} <br>
                            <strong>Độ ẩm (%):</strong> ${feature.properties.doam} <br>
                            <strong>Lượng mưa (mm):</strong> ${feature.properties.luongmua} <br>
                            <strong>Cấp dự báo:</strong> ${feature.properties.capdubao} <br>
                            <strong>Thời gian dự báo:</strong> ${feature.properties.ngay}
                        </p>
                    ` : `
                        <p class="text-base leading-relaxed text-black">
                            Không có thông tin
                        </p>
                    `}
                </div>`;
            layer.bindPopup(popupContent);
        }
    }).addTo(map);
    //map.fitBounds(polygonsLayer.getBounds());
}
/* End fetch polygon */

/* Create header */
const lorungHeaderMapping = {
    'tenhuyen': { 'label': 'Tên Huyện', 'visible': true },
    'tenxa': { 'label': 'Tên Xã', 'visible': true },
    'matieukhu': { 'label': 'Mã Tiểu Khu', 'visible': true },
    'mathuadat': { 'label': 'Mã Thửa Đất', 'visible': true },
    'malo': { 'label': 'Mã Lô', 'visible': true },
    'malocu': { 'label': 'Mã Lô cũ', 'visible': true },
    'makhoanh': { 'label': 'Mã Khoanh', 'visible': true },
    'soto': { 'label': 'Số Tờ', 'visible': true },
    'sothua': { 'label': 'Số Thửa', 'visible': true },
    'diadanh': { 'label': 'Địa Danh', 'visible': true },
    'dientich': { 'label': 'Diện Tích', 'visible': true },
    'nguongoc_rung': { 'label': 'Nguồn Gốc Rừng', 'visible': true },
    'nguongoc_rungtrong': { 'label': 'Nguồn Gốc Rừng Trồng', 'visible': true },
    'phanloai_rung': { 'label': 'Phân Loại Rừng', 'visible': true },
    'loaicay': { 'label': 'Loại cây', 'visible': true },
    'namtrong': { 'label': 'Năm Trồng', 'visible': true },
    'captuoi': { 'label': 'Cấp Tuổi', 'visible': true },
    'nkheptan': { 'label': 'Năm khép tán', 'visible': true },
    'tinhtrang_thanhrung': { 'label': 'Tình trạng thành rừng', 'visible': true },
    'truluong_go': { 'label': 'Trụ Lượng Gỗ', 'visible': true },
    'truluong_tre': { 'label': 'Trụ Lượng Tre', 'visible': true },
    'truluonglo_go': { 'label': 'Trụ Lượng Lô Gỗ', 'visible': true },
    'truluonglo_tre': { 'label': 'Trụ Lượng Lô Tre', 'visible': true },
    'tinhtrang_lapdia': { 'label': 'Tình trạng Lập địa', 'visible': true },
    'mdsd_chinh': { 'label': 'Mục dích sử dụng chính', 'visible': true },
    'mdsd_phu': { 'label': 'Mục dích sử dụng phụ', 'visible': true },
    'quyuoc_mdsd': { 'label': 'Quy ước mục dích sử dụng', 'visible': true },
    'doituong': { 'label': 'Đối tượng', 'visible': true },
    'churung': { 'label': 'Chữ Rừng', 'visible': true },
    'tinhtrang_tranhchap': { 'label': 'Tình trạng Tranh Chấp', 'visible': true },
    'tinhtrang_quyensudung': { 'label': 'Tình trạng Quyền Sử Dụng đất', 'visible': true },
    'thoihansd': { 'label': 'Thời hạn sử dụng', 'visible': true },
    'tinhtrang_khoanbaoverung': { 'label': 'Tình trạng Khóa Bảo vệ Rừng', 'visible': true },
    'tinhtrang_quyhoach': { 'label': 'Tình trạng Quy Hoạch', 'visible': true },
    'nguoiky': { 'label': 'Người ký', 'visible': true },
    'nguoichiutn': { 'label': 'Ngưới chịu trách nhiệm', 'visible': true },
    'tinhtrang_nguyensinh': { 'label': 'Tình trạng nguy cơ sinh', 'visible': true },
};

const dubaochayHeaderMapping = {
    'tenhuyen': { 'label': 'Tên Huyện', 'visible': true },
    'nhietdo': { 'label': 'Nhiệt Độ', 'visible': true },
    'doam': { 'label': 'Độ Ẩm', 'visible': true },
    'luongmua': { 'label': 'Lượng Mưa', 'visible': true },
    'capdubao': { 'label': 'Cấp Dự Báo', 'visible': true },
    'ngay': { 'label': 'Ngày Dự Báo', 'visible': true }
};
/* End create header */

/* Gen table */
function updateTable(data, dataType) {
    // Tìm bảng tương ứng với dataType, nếu chưa có thì tạo mới
    let table = document.getElementById(`${dataType}-table`);
    if (!table) {
        table = document.createElement('table');
        table.id = `${dataType}-table`;
        table.className = 'min-w-full bg-white border mb-4 truncate';

        // Tạo tiêu đề bảng
        const caption = dataType === 'lorung' ? 'Thông tin Lô rừng' : 'Thông tin dự báo cháy rừng';
        $('#table-name').text(caption);

        document.getElementById('tables-container').appendChild(table);
    }
    // Xóa nội dung cũ
    table.innerHTML = '';
    const tableHeader = table.createTHead().insertRow();
    const tableBody = table.createTBody();

    // Thêm class "stick" vào header
    tableHeader.classList.add('sticky', 'top-0', 'bg-gray-100', 'z-10');

    // Lấy header mapping tương ứng với dataType
    const headerMapping = dataType === 'lorung' ? lorungHeaderMapping : dubaochayHeaderMapping;

    // Tạo header nếu có dữ liệu
    if (data?.features?.length) {
        // Tạo header động dựa trên headerMapping
        for (const key in headerMapping) {
            if (headerMapping[key].visible) {
                const headerCell = document.createElement("th");
                headerCell.className = "px-4 py-1 border-b-2 border-gray-200 border-r  text-sm font-semibold text-gray-600 truncate tracking-wide";
                headerCell.textContent = headerMapping[key].label;
                tableHeader.appendChild(headerCell);
            }
        }

        // Thêm dữ liệu vào bảng
        data.features.forEach(feature => {
            const row = tableBody.insertRow();
            for (const key in headerMapping) {
                if (headerMapping[key].visible) {
                    const cell = row.insertCell();
                    cell.className = "px-4 py-2 border text-center text-sm";
                    cell.textContent = feature.properties[key] ?? (feature.properties[key] === 0 ? "0" : "-");
                }
            }
            // Gắn sự kiện double-click vào hàng
            row.addEventListener('dblclick', () => {
                const featureId = feature.properties.id; // Lấy ID của đối tượng
                let bounds = L.latLngBounds(); // Tạo bounds để zoom
                let found = false; // Biến kiểm tra nếu tìm thấy layer tương ứng

                lorung_xaLayer.eachLayer(layer => {
                    // Reset style cho tất cả các layer
                    layer.setStyle({ color: '#fff', weight: 1, fillColor: '#a4e39d', fillOpacity: 1 });

                    // Tìm layer trùng với featureId
                    if (layer.feature.properties.id === featureId) {
                        found = true;

                        // Highlight đối tượng
                        layer.setStyle({ color: 'red', weight: 3 });

                        // Tạo popup với thông tin từ thuộc tính của đối tượng
                        const popupContent = `
                <div>
                    <h4>Thông tin đối tượng</h4>
                    <p><strong>Mã thửa đất:</strong> ${layer.feature.properties.mathuadat}</p>
                    <p><strong>Mã lô:</strong> ${layer.feature.properties.malo}</p>
                    <p><strong>Số tờ:</strong> ${layer.feature.properties.soto}</p>
                    <p><strong>Số thửa:</strong> ${layer.feature.properties.sothua}</p>
                    <p><strong>Tên chủ rừng:</strong> ${layer.feature.properties.churung}</p>
                </div>`;
                        layer.bindPopup(popupContent).openPopup();

                        // Thêm bounds cho đối tượng
                        bounds.extend(layer.getBounds ? layer.getBounds() : L.latLngBounds(layer.getLatLng()));
                    }
                });

                // Zoom đến đối tượng nếu tìm thấy
                if (found && bounds.isValid()) {
                    const paddingBottom = map.getSize().y / 3;
                    const paddingLeft = map.getSize().x / 5;
                    map.fitBounds(bounds, {
                        paddingTopLeft: [paddingLeft, 0],
                        paddingBottomRight: [0, paddingBottom],
                    });
                } else {
                    console.warn('Không tìm thấy layer tương ứng với ID:', featureId);
                    showToast('Không tìm thấy đối tượng trên bản đồ.', 'bg-yellow-500');
                }
            });
        });
        $(`#${dataType}-table tbody tr`).on('mouseover', function () {
            $(this).addClass('cursor-pointer');
        }).on('mouseout', function () {
            $(this).removeClass('cursor-pointer');
        });
        if (data?.links?.length > 3) { // Sử dụng optional chaining
            let paginationHTML = '<nav class="sticky left-0 flex my-2 text-sm pagination">';
            paginationHTML += data.links.map(link => {
                const linkText = (link.label === 'Next &raquo;') ? '&raquo;' : ((link.label === '&laquo; Previous') ? '&laquo;' : link.label);
                return `<a href="${link.url}" class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 mx-1">${linkText}</a>`;
            }).join('');
            paginationHTML += '</nav>';
            tableContainer.append(paginationHTML);
        }
    } else {
        const row = tableBody.insertRow();
        const cell = row.insertCell();
        cell.className = "px-4 py-2 border text-center text-sm";
        cell.colSpan = Object.keys(data?.features[0]?.properties || {}).length;
        cell.textContent = "Không có thông tin";
    }
}
/* End gen table */

function clearTable(dataType) { // Thêm tham số dataType
    const table = document.getElementById(`${dataType}-table`); // Tìm bảng dựa trên dataType
    if (table) {
        table.remove(); // Xóa toàn bộ bảng
    }
}

/* Gen lengend */
let legend; // Khai báo biến legend ở phạm vi toàn cục
// Thêm hàm tạo legend
function createLegend(dataType) {
    // Kiểm tra xem legend đã tồn tại chưa và xóa nó nếu có
    if (legend) map.removeControl(legend);
    legend = L.control({ position: 'bottomright' });

    legend.onAdd = function () {
        const div = L.DomUtil.create('div', 'bg-white p-2 rounded shadow-md');
        const labels = [];

        if (dataType === 'dubaochay') {
            // Tạo legend cho lớp dự báo cháy
            const colors = {
                'N/A': '#FCDAD5',
                'Cấp I': '#EE7C6B',
                'Cấp II': '#E54646',
                'Cấp III': '#DF0029',
                'Cấp IV': '#B2001F',
                'Cấp V': '#8B0016'
            };

            for (const [grade, color] of Object.entries(colors)) {
                labels.push(
                    `<div class="flex items-center mb-1">` +
                    `<div style="background:${color};" class="w-4 h-4 mr-2"></div>` +
                    `<span class="text-sm">${grade}</span>` +
                    `</div>`
                );
            }
        }

        div.innerHTML = labels.join('');
        return div;
    };

    legend.addTo(map);
}
/* End gen lengend */

/* Fetch geoserver */
function addLorungLayerToMap() {
    toggleSpinner(true);
    fetch('api/geom/lorung_geom')
        .then(response => response.json())
        .then(data => {
            // Tạo một lớp GeoJSON với dữ liệu nhận được và tô màu
            if (data && data.features && data.features.length > 0) {
                lorungLayer = L.geoJSON(data, {
                    style: {
                        color: 'none',
                        weight: 2,
                        fillColor: '#fffc8f',
                        fillOpacity: 0.8
                    }
                }).addTo(map);
                //map.fitBounds(lorungLayer.getBounds());
            } else {
                console.warn("Không có dữ liệu lô rừng để hiển thị.");
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => toggleSpinner(false));

}
/* End fetch geoserver */

function resetvalue({ xaSelect, huyenSelect, formId, lorung_xaLayer, lorungLayer, polygonsLayer, selectBoxId }) {
    if (lorung_xaLayer) map.removeLayer(lorung_xaLayer);
    if (lorungLayer) map.removeLayer(lorungLayer);
    if (polygonsLayer) map.removeLayer(polygonsLayer);
    // Xóa giá trị đã chọn trong các ô select
    if (xaSelect) xaSelect.value = '';
    if (huyenSelect) huyenSelect.value = '';
    if (selectBoxId) {
        const selectBox = document.getElementById(selectBoxId);
        if (selectBox) selectBox.value = ''; // Đặt lại giá trị của select về rỗng
    }
    // Xóa giá trị trong các input của form
    if (formId) {
        const form = document.getElementById(formId);
        if (form) {
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = ''; // Đặt giá trị của từng input về rỗng
            });
        }
    }
    map.setView([12.7748685, 108.084071], 9);
}

/* Checkbox event */
function setupEventListeners() {
    const lorungCheckbox = document.getElementById('lorung-checkbox');
    const dubaochayCheckbox = document.getElementById('dubaochay-checkbox');
    const rgxaCheckbox = document.getElementById('rgxa-checkbox');
    const dubaochayTool = document.getElementById('dubaochay-tool');
    const lorungTool = document.getElementById('lorung-tool');
    const huyenSelect = document.getElementById('huyen');
    const xaSelect = document.getElementById('xa');
    const refreshaButton = document.getElementById('refresh');
    const searchForm = document.querySelector('#lorung-tool form');

    //Lấy danh sách xã theo huyện
    huyenSelect.addEventListener('change', (event) => {
        const mahuyen = event.target.value;

        // Xóa các option cũ của select "Xã"
        xaSelect.innerHTML = '<option value="" disabled selected>Chọn Xã</option>';

        // Gửi AJAX request để lấy danh sách xã
        toggleSpinner(true);
        fetch(`/xa-by-huyen?mahuyen=${mahuyen}`)
            .then(response => response.json())
            .then(xaList => {
                xaList.forEach(xa => {
                    const option = document.createElement('option');
                    option.value = xa.maxa;
                    option.text = xa.tenxa;
                    xaSelect.add(option);
                    xaSelect.classList.remove('hidden')
                });
            })
            .finally(() => toggleSpinner(false));
    });

    xaSelect.addEventListener('change', (event) => {
        const maxa = event.target.value;
        if (lorungLayer) map.removeLayer(lorungLayer);
        fetchAndDisplayData(`api/geom/lorung/${maxa}`, data => { displayxaLorung(data); clearTable('lorung'); updateTable(data, 'lorung'); });
    });

    refreshaButton.addEventListener('click', () => {
        if (lorungCheckbox.checked) {
            resetvalue({
                xaSelect,        // Dropdown chọn xã
                huyenSelect , // Dropdown chọn huyện
                formId: 'searchForm',      // ID của form cần reset
                lorung_xaLayer,
                lorungLayer
            });
            fetchAndDisplayData('api/geom/lorung', data => updateTable(data, 'lorung'));
            addLorungLayerToMap();
            xaSelect.classList.add('hidden')
        }
        if (dubaochayCheckbox.checked) {
            resetvalue({
                polygonsLayer,
                selectBoxId: 'ngay'
            });
            fetchAndDisplayData(`api/geom/dubaochay`, data => {
                displayPolygons(data);
                updateTable(data, 'dubaochay');
            });
        }
    });

    searchForm.addEventListener('submit', async function (e) {
        e.preventDefault(); // Prevent default form submission

        if (lorungLayer) map.removeLayer(lorungLayer);
        const formData = new FormData(this);
        const searchParams = new URLSearchParams(formData);
        // Kiểm tra xem xaSelect đã được chọn hay chưa
        if (xaSelect.value) {
            searchParams.append('xa', xaSelect.value);
        }

        fetchAndDisplayData(`api/search/lorung?${searchParams.toString()}`, data => {
            // Kiểm tra nếu data không có features hoặc rỗng
            if (!data || !data.features || data.features.length === 0) {
                showToast('Không tìm thấy dữ liệu', 'bg-yellow-500');
                return; // Dừng thực thi các lệnh phía sau
            }
            if (!xaSelect.value) {
                displayxaLorung(data);
            }
            clearTable('lorung'); updateTable(data, 'lorung');
            let bounds = L.latLngBounds(); // Tạo một bounds rỗng

            lorung_xaLayer.eachLayer(layer => {
                layer.setStyle({ color: '#fff', weight: 1, fillColor: '#a4e39d', fillOpacity: 1 });

                // Tìm đối tượng trong dữ liệu trả về có id trùng với id của layer
                const matchingFeature = data.features.find(f => f.properties.id === layer.feature.properties.id);

                if (matchingFeature) {
                    // Thêm bounds cho đối tượng
                    bounds.extend(layer.getBounds ? layer.getBounds() : L.latLngBounds(layer.getLatLng()));

                    // Highlight đối tượng
                    layer.setStyle({
                        color: 'red',
                        weight: 3,
                    });

                    // Tạo popup với thông tin từ thuộc tính của đối tượng
                    const popupContent = `
                        <div>
                            <h4>Thông tin đối tượng</h4>
                            <p><strong>Mã thửa đất:</strong> ${matchingFeature.properties.mathuadat}</p>
                            <p><strong>Mã lô:</strong> ${matchingFeature.properties.malo}</p>
                            <p><strong>Số tờ:</strong> ${matchingFeature.properties.soto}</p>
                            <p><strong>Số thửa:</strong> ${matchingFeature.properties.sothua}</p>
                            <p><strong>Tên chủ rừng:</strong> ${matchingFeature.properties.churung}</p>
                        </div>`;

                    layer.bindPopup(popupContent);
                }
            });
            // Zoom đến tất cả các đối tượng trong bounds
            if (bounds.isValid()) {
                const paddingBottom = map.getSize().y / 3;
                const paddingLeft = map.getSize().x / 5;
                map.fitBounds(bounds, {
                    paddingTopLeft: [paddingLeft, 0],
                    paddingBottomRight: [0, paddingBottom],
                });
            } else {
                showToast('Không tìm thấy đối tượng trên bản đồ.', 'bg-yellow-500');
            }
        });
    });

    //Lọc dữ liệu báo cháy theo ngày được chọn
    $(document).ready(function () {
        $('#ngay').on('change', function () {
            const selectedDate = $(this).val();
            const schema = $('input[type="checkbox"]:checked').data('schema');
            const table = $('input[type="checkbox"]:checked').data('table');

            // Gọi API để tải lại dữ liệu
            fetchAndDisplayData(`/api/${schema}/${table}/${selectedDate}`, data => {
                clearTable(`${table}`);
                if (polygonsLayer) map.removeLayer(polygonsLayer);
                if (legend) legend.remove();
                displayPolygons(data);
                updateTable(data, `${table}`);
                createLegend(`${table}`);
            });
        });
    });

    // Hàm kiểm tra xem có checkbox nào đang được chọn hay không
    const isAnyCheckboxChecked = () => lorungCheckbox.checked || dubaochayCheckbox.checked;

    // Hàm cập nhật trạng thái hiển thị của showcontainer
    const updateOpenTabButtonVisibility = () => {
        showcontainer.classList.toggle('hidden', !isAnyCheckboxChecked());
    };

    const handleLorungCheckboxChange = () => {
        if (lorungCheckbox.checked) {
            // Tắt các layer khác
            dubaochayCheckbox.checked = false;
            rgxaCheckbox.checked = false;
            showtab.classList.remove("hidden");
            clearTable('dubaochay');
            if (rgxaLayer) map.removeLayer(rgxaLayer);
            if (polygonsLayer) map.removeLayer(polygonsLayer);
            if (legend) legend.remove();
            dubaochayTool.classList.add('hidden');
            lorungTool.classList.remove('hidden');
            addLorungLayerToMap();
            // Fetch dữ liệu lorung và cập nhật bảng
            fetchAndDisplayData('api/geom/lorung', data => updateTable(data, 'lorung'));
        } else {
            clearTable('lorung');
            xaSelect.value = "";
            huyenSelect.value = "";
            clearXaButton.style.display = 'none';
            if (lorungLayer) map.removeLayer(lorungLayer);
            if (lorung_xaLayer) map.removeLayer(lorung_xaLayer);
            lorungTool.classList.add('hidden');
            showtab.classList.add("hidden");
            Table.classList.remove("-translate-y-full");
            modal.classList.add('hidden');
        }
        // Cập nhật trạng thái hiển thị của button "open-tab"
        updateOpenTabButtonVisibility();
    };

    const handleDubaoChayCheckboxChange = () => {
        if (dubaochayCheckbox.checked) {
            lorungCheckbox.checked = false;
            rgxaCheckbox.checked = false;
            showtab.classList.add("hidden");
            clearTable('lorung');
            modal.classList.add('hidden');
            if (lorungLayer) map.removeLayer(lorungLayer);
            if (rgxaLayer) map.removeLayer(rgxaLayer);
            fetchAndDisplayData(`api/geom/dubaochay`, data => {
                displayPolygons(data);
                updateTable(data, 'dubaochay');
                createLegend('dubaochay');
            });
            dubaochayTool.classList.remove('hidden');
            lorungTool.classList.add('hidden');
        } else {
            clearTable('dubaochay');
            if (polygonsLayer) map.removeLayer(polygonsLayer);
            if (legend) legend.remove();
            dubaochayTool.classList.add('hidden');
            Table.classList.remove("-translate-y-full")
        }
        updateOpenTabButtonVisibility();
    };

    const handleRgxaCheckboxChange = () => {
        if (rgxaCheckbox.checked) {
            dubaochayCheckbox.checked = false;
            lorungCheckbox.checked = false;
            if (lorungLayer) map.removeLayer(lorungLayer);
            if (lorung_xaLayer) map.remove(lorung_xaLayer);
            if (polygonsLayer) map.removeLayer(polygonsLayer);
            if (legend) legend.remove();
            showtab.classList.add("hidden");
            Table.classList.remove("-translate-y-full");
            modal.classList.add('hidden');
            fetchAndDisplayData('api/geom/rgxa', displayRXa);
        } else {
            if (rgxaLayer) map.removeLayer(rgxaLayer);
        }
        updateOpenTabButtonVisibility();
    };

    lorungCheckbox.addEventListener('change', handleLorungCheckboxChange);
    dubaochayCheckbox.addEventListener('change', handleDubaoChayCheckboxChange);
    rgxaCheckbox.addEventListener('change', handleRgxaCheckboxChange);
}
/* End checkbox event */

function initialize() {
    fetchAndDisplayData('api/geom/rghuyen', displayRgHuyen);
    setupEventListeners();
}

initialize();
