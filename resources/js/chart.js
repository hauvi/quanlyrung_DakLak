import { Chart } from 'chart.js/auto';

let myChart; // Declare chart variable globally

function formatNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function generateGreenColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const hue = Math.floor(120 + (i * (60 / count))); // Generates shades from 120 to 180
        const saturation = Math.floor(50 + Math.random() * 50); // Vary saturation a bit
        const lightness = Math.floor(40 + Math.random() * 30); // Vary lightness a bit
        colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
    }
    return colors;
}

// Fetch data based on chart type and huyen (if needed)
async function fetchData(chartType, maHuyen = null) { // Add maHuyen parameter
    let url = `/api/static/lorung?chart_type=${chartType}`;
    if (maHuyen) {
        url += `&mahuyen=${maHuyen}`;
    }
    const response = await fetch(url);
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    const data = await response.json();
    return data.data;
}


// Function to process data and update the chart
async function updateChart(chartType, maHuyen = null) {
    toggleSpinner(true);
    const apiData = await fetchData(chartType, maHuyen); // Pass maHuyen here
    const labels = apiData.map(item =>
        maHuyen
            ? item.tenxa.replace('Xã ', '').replace('Phường ', 'P. ').replace('Thị trấn ', 'Tt. ')
            : item.tenhuyen.replace('Huyện ', '').replace('Thành phố ', 'Tp. ').replace('Thị Xã ', 'Tx. ')
    );
    let dataValues;
    let chartLabel;

    if (chartType === 'dientich') {
        dataValues = apiData.map(item => parseFloat(item.tong_dientich).toFixed(1));
        chartLabel = 'Diện tích lô rừng (ha)';

    } else if (chartType === 'soluong') {
        dataValues = apiData.map(item => parseInt(item.tong_lorung));
        chartLabel = 'Tổng số lô rừng';

    } else { // Add a default or error case if needed
        toggleSpinner(false);
        return; // Or handle other chart types
    }
    toggleSpinner(false);

    const formattedValues = dataValues.map(formatNumberWithCommas);
    const colors = generateGreenColors(labels.length);

    // Lấy tên huyện từ selectbox nếu có maHuyen
    const tenHuyen = maHuyen ? huyenSelect.options[huyenSelect.selectedIndex]?.text : null;

    const data = {
        labels: labels,
        datasets: [{
            label: chartLabel,
            data: dataValues,
            backgroundColor: colors,
            borderWidth: 1
        }]
    };


    // Update chart if it exists, otherwise create a new one
    if (myChart) {
        myChart.data = data;
        myChart.options.plugins.title.text = maHuyen
            ? `Biểu đồ ${chartLabel} ${tenHuyen}`
            : `Biểu đồ ${chartLabel} tỉnh Đắk Lắk`;
        myChart.options.scales.y.title.text = chartType === 'dientich' ? 'Diện tích (ha)' : 'Số lượng (lô)'; // Update y-axis label
        myChart.options.scales.x.title.text = maHuyen ? 'Xã' : 'Huyện';
        myChart.options.plugins.tooltip.callbacks.label = (tooltipItem) => {  // Update tooltip
            return `${chartLabel}: ${formattedValues[tooltipItem.dataIndex]} ${chartType === 'dientich' ? 'ha' : 'lô'}`;
        };
        //myChart.type = chartType === 'dientich' || chartType === 'soluong' ? 'bar' : 'pie'; 
        myChart.update();
    } else {
        const ctx = document.getElementById('chart-canvas').getContext('2d'); // Use a single canvas

        myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true, // Hiển thị tiêu đề
                        text: maHuyen
                            ? `Biểu đồ ${chartLabel} huyện ${tenHuyen}`
                            : `Biểu đồ ${chartLabel} tỉnh Đắk Lắk`,
                        font: { size: 16 }, // Kích thước font tiêu đề
                        padding: { top: 10, bottom: 30 }, // Khoảng cách trên/dưới
                    },
                    tooltip: {
                        callbacks: {
                            label: (tooltipItem) => {
                                return `${chartLabel}: ${formattedValues[tooltipItem.dataIndex]} ${chartType === 'dientich' ? 'ha' : 'lô'}`;
                            }
                        }
                    },
                    legend: {
                        display: false, // Tắt Legend (Chú thích)
                    },
                },
                scales: {
                    y: {
                        title: {
                            display: true, // Hiển thị nhãn trục Y
                            text: chartType === 'dientich' ? 'Diện tích (ha)' : 'Số lượng (lô)',
                            font: { size: 14 },
                        },
                        beginAtZero: true,
                    },
                    x: {
                        title: {
                            display: true, // Hiển thị nhãn trục X
                            text: maHuyen ? 'Xã' : 'Huyện',
                            font: { size: 14 },
                        },
                    },
                }
            }
        });
    }
}

const chartTypeSelect = document.getElementById('chart-type');
const huyenSelect = document.getElementById('select-huyen'); // Get huyen select element


chartTypeSelect.addEventListener('change', () => {
    const selectedChartType = chartTypeSelect.value;
    const selectedMaHuyen = huyenSelect.value || null; // Get selected huyen or null if not selected
    updateChart(selectedChartType, selectedMaHuyen);
});


// Initial chart load (you can set a default chart type)
updateChart('dientich'); // Or 'soluong', or whatever your default is


// Add an event listener for the "huyen" select if you need filtering:
huyenSelect.addEventListener('change', () => {
    const selectedChartType = chartTypeSelect.value;
    const selectedMaHuyen = huyenSelect.value;
    updateChart(selectedChartType, selectedMaHuyen);
});