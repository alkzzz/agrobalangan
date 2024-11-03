<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agropolitan Kabupaten Balangan</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicons/site.webmanifest') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- MapLibre CSS -->
    <link href="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <!-- Navbar -->
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
                        <a class="nav-link" href="#">Beranda</a>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeIn">Selamat Datang di Agropolitan Balangan
            </h1>
            <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s">Mendukung Pertumbuhan Pertanian
                Berkelanjutan di Kabupaten Balangan</p>
            <a href="#peta-interaktif"
                class="btn btn-success btn-lg animate__animated animate__fadeIn animate__delay-2s">
                <i class="fas fa-map-marker-alt me-2"></i> Jelajahi Peta
            </a>
        </div>
    </section>

    <!-- Featured Stats -->
    <section class="py-5 bg-light">
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

    <!-- Interactive Map Section -->
    <section id="peta-interaktif" class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-center mb-5">Peta Interaktif Agropolitan</h2>
            <div id="map" class="shadow mb-4"></div>
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                <button class="btn btn-success" onclick="goToCropArea('corn')">
                    Area Jagung
                </button>
                <button class="btn btn-warning" onclick="goToCropArea('palm')">
                    Area Kelapa Sawit
                </button>
                <button class="btn btn-primary" onclick="goToCropArea('rice')">
                    Area Padi
                </button>
                <button class="btn btn-secondary" onclick="resetZoom()">
                    <i class="fas fa-redo-alt me-2"></i>Reset
                </button>
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

    <!-- MapLibre JavaScript -->
    <script src="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js"></script>

    <!-- Map Initialization and Interaction Logic -->
    <script>
        var administrasiDesaUrl = "{{ asset('geojson/Administrasi_Desa.json') }}";

        var map = new maplibregl.Map({
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
            zoom: 13
        });

        map.addControl(new maplibregl.NavigationControl());

        var cropAreas = {
            'corn': {
                "type": "Feature",
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [
                        [
                            [115.480, -2.320],
                            [115.485, -2.320],
                            [115.485, -2.315],
                            [115.480, -2.315],
                            [115.480, -2.320]
                        ]
                    ]
                },
                "properties": {
                    "name": "Area Jagung"
                }
            },
            'palm': {
                "type": "Feature",
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [
                        [
                            [115.500, -2.310],
                            [115.505, -2.310],
                            [115.505, -2.305],
                            [115.500, -2.305],
                            [115.500, -2.310]
                        ]
                    ]
                },
                "properties": {
                    "name": "Area Kelapa Sawit"
                }
            },
            'rice': {
                "type": "Feature",
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [
                        [
                            [115.490, -2.320],
                            [115.495, -2.320],
                            [115.495, -2.315],
                            [115.490, -2.315],
                            [115.490, -2.320]
                        ]
                    ]
                },
                "properties": {
                    "name": "Area Padi"
                }
            }
        };

        var currentPopup = null;

        map.on('load', function() {
            map.addSource('crop-areas', {
                'type': 'geojson',
                'data': {
                    "type": "FeatureCollection",
                    "features": Object.values(cropAreas)
                }
            });

            map.addLayer({
                'id': 'crop-areas-layer',
                'type': 'fill',
                'source': 'crop-areas',
                'paint': {
                    'fill-color': ['match', ['get', 'name'], 'Area Jagung', '#34D399', 'Area Kelapa Sawit',
                        '#FF8800', 'Area Padi', '#1E90FF', '#CCCCCC'
                    ],
                    'fill-opacity': 0.6
                }
            });

            map.addLayer({
                'id': 'crop-areas-borders',
                'type': 'line',
                'source': 'crop-areas',
                'paint': {
                    'line-color': '#FF0000',
                    'line-width': 1.5
                }
            });

            map.addSource('administrasi-desa', {
                'type': 'geojson',
                'data': administrasiDesaUrl
            });

            map.addLayer({
                'id': 'administrasi-desa-fill',
                'type': 'fill',
                'source': 'administrasi-desa',
                'paint': {
                    'fill-color': '#FFFFFF',
                    'fill-opacity': 0.1
                }
            });

            map.addLayer({
                'id': 'administrasi-desa-borders',
                'type': 'line',
                'source': 'administrasi-desa',
                'paint': {
                    'line-color': '#000000',
                    'line-width': 0.5
                }
            });

            map.on('click', 'administrasi-desa-fill', function(e) {
                var properties = e.features[0].properties;

                if (currentPopup) {
                    currentPopup.remove();
                }

                var popupContent = `
                    <div style="font-family: Arial, sans-serif;">
                        <p style="margin: 0; color:green; font-weight:bold">${properties.DESA}</p>
                    </div>
                `;

                currentPopup = new maplibregl.Popup({
                        offset: 15,
                        closeButton: false,
                        closeOnClick: false
                    })
                    .setLngLat(e.lngLat)
                    .setHTML(popupContent)
                    .addTo(map);
            });

            map.getCanvas().addEventListener('contextmenu', function(e) {
                e.preventDefault();
                if (currentPopup) {
                    currentPopup.remove();
                    currentPopup = null;
                }
            });

            map.on('mouseenter', 'administrasi-desa-fill', function() {
                map.getCanvas().style.cursor = 'pointer';
            });

            map.on('mouseleave', 'administrasi-desa-fill', function() {
                map.getCanvas().style.cursor = '';
            });
        });

        function goToCropArea(crop) {
            var cropArea = cropAreas[crop];
            var coordinates = cropArea.geometry.coordinates[0][0];
            map.flyTo({
                center: coordinates,
                zoom: 15,
                speed: 0.7,
                curve: 1.5
            });
        }

        function resetZoom() {
            map.flyTo({
                center: [115.497, -2.308],
                zoom: 13,
                speed: 0.7,
                curve: 1.5
            });
        }
    </script>
</body>

</html>
