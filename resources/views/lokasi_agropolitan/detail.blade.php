@extends('adminlte::page')

@section('title', 'Detail Lokasi Agropolitan')

@section('content_header')
    {{-- Judul halaman dinamis sesuai nama kecamatan dari data --}}
    <h1>Detail Lokasi: {{ $lokasi->kecamatan->name }}</h1>
@stop

@section('css')
    {{-- CSS untuk MapLibre GL JS --}}
    <link href="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css" rel="stylesheet" />
    <style>
        /* Style untuk map container */
        #map {
            width: 100%;
            height: 450px;
            border-radius: .25rem;
        }
    </style>
@stop

@section('content')
    {{-- BARIS 1: PETA LOKASI & INFO UTAMA --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-map-marked-alt mr-1"></i> Peta Lokasi Agropolitan</h3>
                </div>
                <div class="card-body">
                    {{-- Container untuk peta --}}
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 2: STATISTIK UTAMA (INFO-BOX) --}}
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-ruler-combined"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Luas Area</span>
                    <span class="info-box-number">{{ number_format($lokasi->luas_ha, 2, ',', '.') }} Ha</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-water"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Status Irigasi</span>
                    <span class="info-box-number">{{ $lokasi->irigasi }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-mountain"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kelas Lereng</span>
                    <span class="info-box-number">{{ $lokasi->kls_lereng }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 3: DATA RINCI DENGAN TABS --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-success card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-tanah-link" data-toggle="pill" href="#tab-tanah"
                                role="tab" aria-controls="tab-tanah" aria-selected="true"><i
                                    class="fas fa-vial mr-1"></i> Analisis Tanah</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-kepemilikan-link" data-toggle="pill" href="#tab-kepemilikan"
                                role="tab" aria-controls="tab-kepemilikan" aria-selected="false"><i
                                    class="fas fa-user-check mr-1"></i> Kepemilikan Lahan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-irigasi-link" data-toggle="pill" href="#tab-irigasi" role="tab"
                                aria-controls="tab-irigasi" aria-selected="false"><i class="fas fa-tint mr-1"></i> Data
                                Irigasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-transportasi-link" data-toggle="pill" href="#tab-transportasi"
                                role="tab" aria-controls="tab-transportasi" aria-selected="false"><i
                                    class="fas fa-road mr-1"></i> Infrastruktur Jalan</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        {{-- Tab Pane untuk Analisis Tanah --}}
                        <div class="tab-pane fade show active" id="tab-tanah" role="tabpanel"
                            aria-labelledby="tab-tanah-link">
                            <h4>Data Analisis Tanah</h4>
                            <p>Tabel atau daftar hasil analisis sampel tanah di lokasi ini. Contoh: pH, kandungan N, P, K,
                                dll.</p>
                            {{-- TODO: Tampilkan data analisis tanah di sini, bisa menggunakan DataTable --}}
                            <table class="table table-bordered">
                                {{-- ... tabel data tanah ... --}}
                            </table>
                        </div>

                        {{-- Tab Pane untuk Kepemilikan Lahan --}}
                        <div class="tab-pane fade" id="tab-kepemilikan" role="tabpanel"
                            aria-labelledby="tab-kepemilikan-link">
                            <h4>Data Kepemilikan Lahan</h4>
                            <p>Daftar persil lahan, nama pemilik, luas, dan status sertifikat.</p>
                            {{-- TODO: Tampilkan data kepemilikan lahan di sini --}}
                            <table class="table table-bordered">
                                {{-- ... tabel data kepemilikan ... --}}
                            </table>
                        </div>

                        {{-- Tab Pane untuk Irigasi --}}
                        <div class="tab-pane fade" id="tab-irigasi" role="tabpanel" aria-labelledby="tab-irigasi-link">
                            <h4>Data Jaringan Irigasi</h4>
                            <p>Informasi mengenai saluran irigasi primer, sekunder, dan tersier yang ada.</p>
                            {{-- TODO: Tampilkan data irigasi di sini --}}
                            <table class="table table-bordered">
                                {{-- ... tabel data irigasi ... --}}
                            </table>
                        </div>

                        {{-- Tab Pane untuk Transportasi --}}
                        <div class="tab-pane fade" id="tab-transportasi" role="tabpanel"
                            aria-labelledby="tab-transportasi-link">
                            <h4>Data Infrastruktur Transportasi</h4>
                            <p>Daftar jalan usaha tani, jalan produksi, dan akses jalan utama ke lokasi.</p>
                            {{-- TODO: Tampilkan data transportasi di sini --}}
                            <table class="table table-bordered">
                                {{-- ... tabel data transportasi ... --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js"></script>
    <script>
        const lokasiGeoJson = {!! json_encode($geoJsonData) !!};

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
                    "source": "osm"
                }]
            },
            center: [115.497, -2.308],
            zoom: 10
        });

        map.addControl(new maplibregl.NavigationControl(), 'top-right');

        function fitMapToBounds(map, geometry) {
            const bounds = new maplibregl.LngLatBounds();

            const processCoordinates = (coords) => {
                if (Array.isArray(coords) && coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
                    bounds.extend(coords);
                }
            };

            if (geometry.type === 'Polygon') {
                geometry.coordinates[0].forEach(processCoordinates);
            } else if (geometry.type === 'MultiPolygon') {
                geometry.coordinates.forEach(polygon => {
                    polygon[0].forEach(processCoordinates);
                });
            }

            if (!bounds.isEmpty()) {
                map.fitBounds(bounds, {
                    padding: 50,
                    duration: 2000
                });
            }
        }

        map.on('load', () => {
            if (lokasiGeoJson && lokasiGeoJson.features && lokasiGeoJson.features.length > 0 && lokasiGeoJson
                .features[0].geometry) {
                map.addSource('lokasi-agropolitan', {
                    'type': 'geojson',
                    'data': lokasiGeoJson
                });
                map.addLayer({
                    id: 'agropolitan-layer',
                    type: 'fill',
                    source: 'lokasi-agropolitan',
                    paint: {
                        'fill-color': '#00FF00',
                        'fill-opacity': 0.7
                    }
                });

                map.addLayer({
                    id: 'agropolitan-borders',
                    type: 'line',
                    source: 'lokasi-agropolitan',
                    paint: {
                        'line-color': '#FFD700',
                        'line-width': 2,
                        'line-opacity': 0.9
                    }
                });

                map.addLayer({
                    id: 'agropolitan-border-casing',
                    type: 'line',
                    source: 'lokasi-agropolitan',
                    paint: {
                        'line-color': '#000000',
                        'line-width': 3,
                        'line-opacity': 0.7
                    }
                });

                fitMapToBounds(map, lokasiGeoJson.features[0].geometry);
            } else {
                document.getElementById('map').innerHTML =
                    '<div class="alert alert-danger m-3">Data Peta untuk lokasi ini tidak ditemukan.</div>';
            }
        });
    </script>
@stop
