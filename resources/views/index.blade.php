<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agropolitan Kabupaten Balangan</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/regular.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/solid.min.css') }}">

    <!-- MapLibre CSS -->
    <link href="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontmap.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('favicons/favicon-32x32.png') }}" alt="Logo" class="me-2" width="32"
                    height="32">
                <span class="fw-bold text-success">Agropolitan Balangan</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero-section">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#peta-interaktif">Peta Interaktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#informasi-umum">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero-section" class="hero-section d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeIn">Selamat Datang di Agropolitan Balangan
            </h1>
            <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s">Mendukung Pertumbuhan Pertanian
                Berkelanjutan di Kabupaten Balangan</p>
            <a href="#peta-interaktif"
                class="btn btn-success btn-lg animate__animated animate__fadeIn animate__delay-2s">
                <i class="fa-solid fa-location-dot"></i> Jelajahi Peta
            </a>
        </div>
    </section>

    <!-- Interactive Map Section -->
    <section id="peta-interaktif" class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-center mb-5">Peta Interaktif Agropolitan</h2>
            <div class="row">
                <div class="col-md-3">
                    <div id="dropdown-container" class="list-group shadow-sm">
                        <a href="#" id="reset-button"
                            class="list-group-item list-group-item-action text-center bg-danger text-white">
                            Reset Zoom
                        </a>
                        <!-- Dynamic Dropdown Items -->
                    </div>
                </div>
                <!-- Map and Layer Controls -->
                <div class="col-md-9">
                    <div id="map" class="shadow mb-3"></div>
                    <!-- Layer Controls -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div id="layer-controls" class="mt-3">
                                <div class="form-check-wrapper">
                                    <label class="form-check-label" for="toggle-borders" id="label-borders">
                                        <input type="checkbox" class="form-check-input" id="toggle-borders" checked>
                                        Batas Kecamatan
                                    </label>
                                </div>
                                <div class="form-check-wrapper">
                                    <label class="form-check-label" for="toggle-rivers" id="label-rivers">
                                        <input type="checkbox" class="form-check-input" id="toggle-rivers">
                                        Sungai
                                    </label>
                                </div>
                                <div class="form-check-wrapper">
                                    <label class="form-check-label" for="toggle-soil" id="label-soil">
                                        <input type="checkbox" class="form-check-input" id="toggle-soil">
                                        Jenis Tanah
                                    </label>
                                </div>
                                <div class="form-check-wrapper">
                                    <label class="form-check-label" for="toggle-land-cover" id="label-land-cover">
                                        <input type="checkbox" class="form-check-input" id="toggle-land-cover">
                                        Tutupan Lahan
                                    </label>
                                </div>
                                <div class="form-check-wrapper">
                                    <label class="form-check-label" for="toggle-irrigation" id="label-irrigation">
                                        <input type="checkbox" class="form-check-input" id="toggle-irrigation">
                                        Irigasi
                                    </label>
                                </div>
                                <div class="form-check-wrapper">
                                    <label class="form-check-label" for="toggle-roads" id="label-roads">
                                        <input type="checkbox" class="form-check-input" id="toggle-roads">
                                        Jalan Pendukung
                                    </label>
                                </div>
                                <div class="form-check-wrapper">
                                    <label class="form-check-label" for="toggle-land-ownership"
                                        id="label-land-ownership">
                                        <input type="checkbox" class="form-check-input" id="toggle-land-ownership">
                                        Kepemilikan Lahan
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Informasi Umum -->
    <section id="informasi-umum" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Informasi Umum Agropolitan</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <p class="lead text-muted">
                        Kabupaten Balangan merupakan wilayah agropolitan yang memiliki potensi besar dalam pengembangan
                        komoditas pertanian, seperti padi, kelapa sawit, dan jagung. Kami berkomitmen untuk mendukung
                        pengelolaan lahan secara berkelanjutan melalui inovasi teknologi dan infrastruktur yang
                        mendukung
                        pertumbuhan ekonomi lokal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-center">Kontak Kami</h2>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <i class="fas fa-building text-success fa-3x mb-3"></i>
                                <h3 class="h4">Dinas Ketahanan Pangan, Pertanian dan Perikanan Kabupaten Balangan
                                </h3>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-map-marker-alt text-success me-2"></i>
                                    Jalan Jend. A. Yani No.Km.4 5, Batu Piring, Paringin Selatan, Balangan Regency,
                                    South Kalimantan 71618
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    (0526) 2029499
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-envelope text-success me-2"></i>
                                    <a href="mailto:distan.balangankab@gmail.com" class="text-decoration-none">
                                        distan.balangankab@gmail.com
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">© 2024 Agropolitan Kabupaten Balangan. Seluruh hak cipta dilindungi
                        undang-undang.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="https://dkppp.balangankab.go.id/portal/index.php" target="_blank"
                        class="text-white me-3"><i class="fab fa-internet-explorer"></i></a>
                    <a href="https://www.instagram.com/dkppp_balangan_/" target="_blank" class="text-white"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@CeritaTani-bu6vy" target="_blank" class="text-white ms-3"><i
                            class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agropolitanUrl = "{{ route('lokasi-agropolitan.geojson') }}";
            const batasKecamatan = "{{ asset('geojson/batas_kecamatan_balangan.geojson') }}";
            const sungaiUrl = "{{ asset('geojson/Sungai.json') }}";
            const tanahUrl = "{{ asset('geojson/Tanah.json') }}";
            const tutupanLahanUrl = "{{ asset('geojson/tutupan_lahan.json') }}";

            const kepemilikanLahanUrl = "{{ route('kepemilikan-lahan.geojson') }}";

            const map = new maplibregl.Map({
                container: 'map',
                style: {
                    "version": 8,
                    "glyphs": "https://demotiles.maplibre.org/font/{fontstack}/{range}.pbf",
                    "sources": {
                        "osm": {
                            "type": "raster",
                            "tiles": ["https://tile.openstreetmap.org/{z}/{x}/{y}.png"],
                            "tileSize": 256
                        }
                    },
                    "layers": [{
                        "id": "osm-tiles",
                        "type": "raster",
                        "source": "osm",
                        "minzoom": 0,
                        "maxzoom": 19
                    }]
                },
                center: [115.497, -2.308],
                zoom: 11
            });

            map.addControl(new maplibregl.NavigationControl());

            class SoilLegendControl {
                onAdd(map) {
                    this._container = document.createElement('div');
                    this._container.id = 'soil-legend-on-map';
                    this._container.className = 'map-legend maplibregl-ctrl';
                    this._container.style.display = 'none';
                    this._container.innerHTML = `
            <h6>Legenda Jenis Tanah</h6>
            <ul class="list-unstyled">
                <li><span class="legend-color" style="background-color: #BDBDBD;"></span>Batuan Permukaan</li>
                <li><span class="legend-color" style="background-color: #8FBC8F;"></span>Tanah Aluvial Rawa</li>
                <li><span class="legend-color" style="background-color: #A0522D;"></span>Tanah Aluvial Subur</li>
                <li><span class="legend-color" style="background-color: #594640;"></span>Tanah Gambut (Organik)</li>
                <li><span class="legend-color" style="background-color: #BC8F8F;"></span>Tanah Tropis Lapuk</li>
                <li><span class="legend-color" style="background-color: #F4A460;"></span>Tanah Podsolik Merah-Kuning</li>
            </ul>
        `;
                    return this._container;
                }

                onRemove() {
                    if (this._container && this._container.parentNode) {
                        this._container.parentNode.removeChild(this._container);
                    }
                }
            }

            class LandCoverLegendControl {
                onAdd(map) {
                    this._container = document.createElement('div');
                    this._container.id = 'landcover-legend-on-map';
                    this._container.className = 'map-legend maplibregl-ctrl';
                    this._container.style.display = 'none';
                    this._container.innerHTML = `
                <h6>Legenda Tutupan Lahan</h6>
                <ul class="list-unstyled">
                    <li><span class="legend-color" style="background-color: #4575b4;"></span>Badan Air</li>
                    <li><span class="legend-color" style="background-color: #c7e9c0;"></span>Belukar</li>
                    <li><span class="legend-color" style="background-color: #7fcdbb;"></span>Belukar Rawa</li>
                    <li><span class="legend-color" style="background-color: #1a9641;"></span>Hutan Lahan Kering Primer</li>
                    <li><span class="legend-color" style="background-color: #a1d99b;"></span>Hutan Lahan Kering Sekunder</li>
                    <li><span class="legend-color" style="background-color: #66c2a5;"></span>Hutan Tanaman</li>
                    <li><span class="legend-color" style="background-color: #fdae61;"></span>Perkebunan</li>
                    <li><span class="legend-color" style="background-color: #d7191c;"></span>Permukiman</li>
                    <li><span class="legend-color" style="background-color: #A020F0;"></span>Pertambangan</li>
                    <li><span class="legend-color" style="background-color: #fef0d9;"></span>Pertanian Lahan Kering</li>
                    <li><span class="legend-color" style="background-color: #fee08b;"></span>Pertanian Lahan Kering Campur</li>
                    <li><span class="legend-color" style="background-color: #ffffbf;"></span>Sawah</li>
                    <li><span class="legend-color" style="background-color: #964B00;"></span>Tanah Terbuka</li>
                </ul>
            `;
                    return this._container;
                }
                onRemove() {
                    this._container.parentNode.removeChild(this._container);
                }
            }

            const soilLegendControl = new SoilLegendControl();
            map.addControl(soilLegendControl, 'top-left');

            const landCoverLegendControl = new LandCoverLegendControl();
            map.addControl(landCoverLegendControl, 'top-left');

            const resetZoom = () => {
                map.flyTo({
                    center: [115.497, -2.308],
                    zoom: 11,
                    speed: 0.5,
                    curve: 1.5
                });
            };

            document.getElementById('reset-button').addEventListener('click', function(event) {
                event.preventDefault();
                resetZoom();
            });

            let popup = new maplibregl.Popup();

            map.on('load', () => {
                fetch(agropolitanUrl)
                    .then(response => response.json())
                    .then(data => {
                        map.addSource('agropolitan', {
                            type: 'geojson',
                            data
                        });

                        map.addLayer({
                            id: 'agropolitan-layer',
                            type: 'fill',
                            source: 'agropolitan',
                            paint: {
                                'fill-color': '#00EE00',
                                'fill-opacity': 0.9
                            }
                        });

                        map.addLayer({
                            id: 'agropolitan-borders',
                            type: 'line',
                            source: 'agropolitan',
                            paint: {
                                'line-color': '#FFD700',
                                'line-width': 2,
                                'line-opacity': 0.9
                            }
                        });

                        map.addLayer({
                            id: 'agropolitan-border-casing',
                            type: 'line',
                            source: 'agropolitan',
                            paint: {
                                'line-color': '#000000',
                                'line-width': 3,
                                'line-opacity': 0.7
                            }
                        });

                        const dropdownContainer = document.getElementById('dropdown-container');

                        data.features.forEach((feature, index) => {
                            const {
                                kecamatan
                            } = feature.properties;
                            let coordinates;

                            if (feature.geometry.type === "Polygon") {
                                coordinates = feature.geometry.coordinates[0][0];
                            } else if (feature.geometry.type === "MultiPolygon") {
                                coordinates = feature.geometry.coordinates[0][0][0];
                            } else {
                                console.error("Unsupported geometry type:", feature.geometry
                                    .type);
                                return;
                            }

                            const listItem = document.createElement('a');
                            listItem.classList.add('list-group-item', 'list-group-item-action');
                            listItem.textContent = `${index + 1} - ${kecamatan}`;
                            listItem.href = '#';

                            listItem.onclick = (e) => {
                                e.preventDefault();
                                map.flyTo({
                                    center: coordinates,
                                    zoom: 13,
                                    speed: 0.5,
                                    curve: 1.5
                                });
                            };

                            dropdownContainer.appendChild(listItem);
                        });


                        map.on('click', 'agropolitan-layer', function(e) {
                            const coordinates = e.lngLat;
                            const properties = e.features[0].properties;
                            const info = `
                                <strong>Kecamatan:</strong> ${properties.kecamatan}<br>
                                <strong>Kls Lereng:</strong> ${properties.kls_lereng || 'N/A'}<br>
                                <strong>Irigasi:</strong> ${properties.irigasi || 'N/A'}
                            `;
                            popup.setLngLat(coordinates).setHTML(info).addTo(map);
                        });

                        map.on('contextmenu', () => {
                            popup.remove();
                        });
                    })
                    .catch(error => {
                        console.error('Error loading Agropolitan data:', error);
                    });

                fetch(batasKecamatan)
                    .then(response => response.json())
                    .then(data => {
                        map.addSource('administrasi', {
                            type: 'geojson',
                            promoteId: 'NAME_3',
                            data
                        });

                        map.addLayer({
                            id: 'administrasi-layer',
                            type: 'fill',
                            source: 'administrasi',
                            paint: {
                                'fill-color': '#FFFFFF',
                                'fill-opacity': 0.1
                            }
                        });

                        map.addLayer({
                            id: 'administrasi-borders',
                            type: 'line',
                            source: 'administrasi',
                            paint: {
                                'line-color': '#000000',
                                'line-width': 1
                            }
                        });

                        map.addLayer({
                            id: 'administrasi-labels',
                            type: 'symbol',
                            source: 'administrasi',
                            layout: {
                                'text-field': ['get',
                                    'NAME_3'
                                ],
                                'text-size': 16,
                                'text-allow-overlap': false
                            },
                            paint: {
                                'text-color': '#000000',
                                'text-halo-color': '#FFFFFF',
                                'text-halo-width': 1,
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error loading data batas desa:', error);
                    });

                fetch(sungaiUrl)
                    .then(response => response.json())
                    .then(data => {
                        map.addSource('sungai', {
                            type: 'geojson',
                            data
                        });

                        map.addLayer({
                            id: 'sungai-layer',
                            type: 'line',
                            source: 'sungai',
                            layout: {
                                'visibility': 'none'
                            },
                            paint: {
                                'line-color': '#0000FF',
                                'line-width': 2
                            }
                        });
                    })
                    .catch(error => console.error('Error loading data sungai:', error));

                fetch(tanahUrl)
                    .then(response => response.json())
                    .then(data => {
                        map.addSource('tanah', {
                            type: 'geojson',
                            data
                        });

                        map.addLayer({
                            id: 'tanah-layer',
                            type: 'fill',
                            source: 'tanah',
                            layout: {
                                'visibility': 'none'
                            },
                            paint: {
                                'fill-color': [
                                    'match',
                                    ['get',
                                        'TANAH1'
                                    ],
                                    'ROC', '#BDBDBD',
                                    'Typic Endoaquepts',
                                    '#8FBC8F',
                                    'Typic Eutrudepts',
                                    '#A0522D',
                                    'Typic Haplosaprists',
                                    '#594640',
                                    'Typic Hapludox',
                                    '#BC8F8F',
                                    'Typic Hapludults',
                                    '#F4A460',
                                    'No Data', '#E0E0E0',
                                    '#CCCCCC'
                                ],
                                'fill-opacity': 0.5
                            }
                        });

                        map.addLayer({
                            id: 'tanah-border-layer',
                            type: 'line',
                            source: 'tanah',
                            layout: {
                                'visibility': 'none'
                            },
                            paint: {
                                'line-color': '#000000',
                                'line-width': 1
                            }
                        });
                    })
                    .catch(error => console.error('Error loading data tanah:', error));

                fetch(tutupanLahanUrl)
                    .then(response => response.json())
                    .then(data => {
                        map.addSource('landcover', {
                            type: 'geojson',
                            data: data
                        });

                        map.addLayer({
                            id: 'landcover-layer',
                            type: 'fill',
                            source: 'landcover',
                            layout: {
                                'visibility': 'none'
                            },
                            // ...
                            paint: {
                                'fill-color': [
                                    'match',
                                    ['get', 'PENUTUP_LH'],
                                    'Badan Air', '#4575b4',
                                    'Belukar', '#c7e9c0',
                                    'Belukar Rawa', '#7fcdbb',
                                    'Hutan Lahan Kering Primer', '#1a9641',
                                    'Hutan Lahan Kering Sekunder', '#a1d99b',
                                    'Hutan Tanaman', '#66c2a5',
                                    'Perkebunan', '#fdae61',
                                    'Permukiman', '#d7191c',
                                    'Pertambangan', '#A020F0',
                                    'Pertanian Lahan Kering', '#fef0d9',
                                    'Pertanian Lahan Kering Campur', '#fee08b',
                                    'Sawah', '#ffffbf',
                                    'Tanah Terbuka', '#964B00',
                                    '#cccccc'
                                ],
                                'fill-opacity': 0.5
                            }
                        });

                        map.addLayer({
                            id: 'landcover-border-layer',
                            type: 'line',
                            source: 'landcover',
                            layout: {
                                'visibility': 'none'
                            },
                            paint: {
                                'line-color': '#000000',
                                'line-width': 0.5
                            }
                        });
                    })
                    .catch(error => console.error('Error loading land cover data:', error));

                fetch(kepemilikanLahanUrl)
                    .then(response => response.json())
                    .then(data => {
                        map.addSource('kepemilikan-lahan', {
                            type: 'geojson',
                            data: data
                        });

                        map.addLayer({
                            id: 'kepemilikan-lahan',
                            type: 'fill',
                            source: 'kepemilikan-lahan',
                            layout: {
                                'visibility': 'none'
                            },
                            paint: {
                                'fill-color': '#FF8C00',
                                'fill-outline-color': '#4B2D0A',
                                'fill-opacity': 0.8
                            }
                        });
                    })
                    .catch(error => console.error('Error loading new layer:', error));

                if (map.getLayer('agropolitan-layer')) {
                    map.moveLayer('agropolitan-layer');
                }
                if (map.getLayer('agropolitan-border-casing')) {
                    map.moveLayer('agropolitan-border-casing');
                }
                if (map.getLayer('agropolitan-borders')) {
                    map.moveLayer('agropolitan-borders');
                }
            });

            const toggleLayer = (checkboxId, layerIds) => {
                const isChecked = document.getElementById(checkboxId).checked;
                layerIds.forEach(layerId => {
                    map.setLayoutProperty(layerId, 'visibility', isChecked ? 'visible' : 'none');
                });
            };

            document.getElementById('toggle-borders').addEventListener('change', () => {
                toggleLayer('toggle-borders', ['administrasi-layer', 'administrasi-borders',
                    'administrasi-labels'
                ]);
            });

            document.getElementById('toggle-rivers').addEventListener('change', () => {
                toggleLayer('toggle-rivers', ['sungai-layer']);
            });

            document.getElementById('toggle-soil').addEventListener('change', (e) => {
                const isChecked = e.target.checked;
                const soilLegend = document.getElementById('soil-legend-on-map');

                ['tanah-layer', 'tanah-border-layer'].forEach(id => {
                    if (map.getLayer(id)) map.setLayoutProperty(id, 'visibility', isChecked ?
                        'visible' : 'none');
                });
                if (soilLegend) soilLegend.style.display = isChecked ? 'block' : 'none';

                if (isChecked) {
                    const landCoverCheckbox = document.getElementById('toggle-land-cover');
                    if (landCoverCheckbox.checked) {
                        landCoverCheckbox.checked = false;
                        landCoverCheckbox.dispatchEvent(new Event('change'));
                    }
                }
            });

            document.getElementById('toggle-land-cover').addEventListener('change', (e) => {
                const isChecked = e.target.checked;
                const landCoverLegend = document.getElementById('landcover-legend-on-map');

                ['landcover-layer', 'landcover-border-layer'].forEach(id => {
                    if (map.getLayer(id)) map.setLayoutProperty(id, 'visibility', isChecked ?
                        'visible' : 'none');
                });
                if (landCoverLegend) landCoverLegend.style.display = isChecked ? 'block' : 'none';

                if (isChecked) {
                    const soilCheckbox = document.getElementById('toggle-soil');
                    if (soilCheckbox.checked) {
                        soilCheckbox.checked = false;
                        soilCheckbox.dispatchEvent(new Event('change'));
                    }
                }
            });

            document.getElementById('toggle-land-ownership').addEventListener('change', () => {
                toggleLayer('toggle-land-ownership', [
                    'kepemilikan-lahan'
                ]);
            });

        });
    </script>
</body>

</html>
