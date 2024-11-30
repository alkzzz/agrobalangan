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

    <style>
        #map {
            width: 100%;
            height: 500px;
        }

        #dropdown-container {
            max-height: 500px;
            overflow-y: auto;
        }

        .list-group-item {
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .list-group-item:hover,
        .list-group-item.active {
            background-color: #28a745;
            color: white;
        }

        #reset-button {
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        #reset-button:hover {
            background-color: #dc3545;
            color: white;
        }

        #layer-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: center;
        }

        .form-check-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check-label {
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 2px;
            cursor: pointer;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            appearance: none;
            outline: none;
            cursor: pointer;
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }

        .form-check-input:checked {
            background-color: #000000;
        }

        #toggle-rivers:checked {
            background-color: #1E90FF;
        }

        #toggle-soil:checked {
            background-color: #A0522D;
        }

        #toggle-irrigation:checked {
            background-color: #0E7490;
        }

        #toggle-roads:checked {
            background-color: #D22B2B;
        }

        #toggle-land-ownership:checked {
            background-color: #32CD32;
        }

        #label-borders {
            color: #000000;
        }

        #label-rivers {
            color: #1E90FF;
        }

        #label-soil {
            color: #A0522D;
        }

        #label-irrigation {
            color: #0E7490;
        }

        #label-roads {
            color: #D22B2B;
        }

        #label-land-ownership {
            color: #32CD32;
        }

        .card {
            border: none;
            border-radius: 6px;
            background-color: #f8f9fa;
            padding: 1px;
        }
    </style>
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
                        <a class="nav-link" href="#statistik">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#informasi-umum">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
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
                                        Batas Desa
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
    </section>

    <!-- Featured Stats -->
    <section id="statistik" class="py-5 bg-light">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="feature-card card h-100 p-4 text-center">
                        <div class="card-body">
                            <i class="fas fa-leaf text-success fa-3x mb-3"></i>
                            <h3 class="card-title h4 mb-3">Lahan Pertanian</h3>
                            <p class="card-text text-muted">50,000+ Hektar</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card h-100 p-4 text-center">
                        <div class="card-body">
                            <i class="fas fa-users text-success fa-3x mb-3"></i>
                            <h3 class="card-title h4 mb-3">Petani Aktif</h3>
                            <p class="card-text text-muted">10,000+ Petani</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card h-100 p-4 text-center">
                        <div class="card-body">
                            <i class="fas fa-seedling text-success fa-3x mb-3"></i>
                            <h3 class="card-title h4 mb-3">Komoditas</h3>
                            <p class="card-text text-muted">15+ Jenis Tanaman</p>
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
                                <h3 class="h4">Dinas Pertanian Kabupaten Balangan</h3>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-map-marker-alt text-success me-2"></i>
                                    Jl. Raya Utara No.123, Kabupaten Balangan
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    (0511) 123-4567
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-envelope text-success me-2"></i>
                                    <a href="mailto:info@dinaspertanianbalangan.go.id" class="text-decoration-none">
                                        info@dinaspertanianbalangan.go.id
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
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agropolitanUrl = "{{ route('potential-area.geojson') }}";
            const administrasiDesaUrl = "{{ asset('geojson/Administrasi_Desa.json') }}";

            const map = new maplibregl.Map({
                container: 'map',
                style: {
                    "version": 8,
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
                                'fill-color': '#00FF00',
                                'fill-opacity': 0.5
                            }
                        });

                        map.addLayer({
                            id: 'agropolitan-borders',
                            type: 'line',
                            source: 'agropolitan',
                            paint: {
                                'line-color': '#008000',
                                'line-width': 2
                            }
                        });

                        const dropdownContainer = document.getElementById('dropdown-container');
                        data.features.forEach((feature, index) => {
                            const {
                                desa,
                                kecamatan
                            } = feature.properties;
                            const coordinates = feature.geometry.coordinates[0][0];
                            const listItem = document.createElement('a');
                            listItem.classList.add('list-group-item', 'list-group-item-action');
                            listItem.textContent = `${index + 1} - ${desa} (${kecamatan})`;
                            listItem.href = '#';

                            listItem.onclick = (e) => {
                                e.preventDefault();
                                map.flyTo({
                                    center: coordinates,
                                    zoom: 14,
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
                                <strong>Desa:</strong> ${properties.desa}<br>
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

                fetch(administrasiDesaUrl)
                    .then(response => response.json())
                    .then(data => {
                        map.addSource('administrasi', {
                            type: 'geojson',
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
                                'line-width': 0.5
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error loading Administrasi Desa data:', error);
                    });
            });

            const toggleLayer = (checkboxId, layerIds) => {
                const isChecked = document.getElementById(checkboxId).checked;
                layerIds.forEach(layerId => {
                    map.setLayoutProperty(layerId, 'visibility', isChecked ? 'visible' : 'none');
                });
            };

            document.getElementById('toggle-borders').addEventListener('change', () => {
                toggleLayer('toggle-borders', ['administrasi-layer', 'administrasi-borders']);
            });
        });
    </script>
</body>

</html>
