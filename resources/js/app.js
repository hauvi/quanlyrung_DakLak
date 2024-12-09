import './bootstrap';

import.meta.glob([
    '../images/**'
]);

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css'; // Import the CSS

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import 'leaflet-draw/dist/leaflet.draw.css';
import 'leaflet-draw';
import 'leaflet-arrowheads';

/* import { initializeMapPage } from './map/mapPage';
const urlPath = window.location.pathname;
let page = '';

if (urlPath.includes('/map')) {
    page = 'map';
}

// Sau đó có thể dùng `page` để kiểm tra và tải các script cần thiết
if (page === 'map') {
    initializeMapPage();
} */