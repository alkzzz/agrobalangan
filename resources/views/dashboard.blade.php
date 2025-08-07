@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('css')
    <link href="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/backmap.css') }}">
@stop

@section('content')
    <!-- Dashboard Layout -->
    <div class="row">
        <div class="col-md-3">
            <!-- Dropdown Container -->
            <div id="dropdown-container" class="list-group shadow-sm mb-3">
                <a href="#" id="reset-button"
                    class="list-group-item list-group-item-action text-center bg-danger text-white">
                    Reset Zoom
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Interactive Map -->
            <div id="map" class="shadow mb-3" style="height: 500px;"></div>
            <!-- Layer Controls -->
            <!-- Layer Controls -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div id="layer-controls" class="mt-3">
                        <div class="icheck-primary">
                            <input type="checkbox" id="toggle-borders" checked>
                            <label for="toggle-borders" id="label-borders">Batas Desa</label>
                        </div>
                        <div class="icheck-primary">
                            <input type="checkbox" id="toggle-rivers">
                            <label for="toggle-rivers" id="label-rivers">Sungai</label>
                        </div>
                        <div class="icheck-danger">
                            <input type="checkbox" id="toggle-soil">
                            <label for="toggle-soil" id="label-soil">Jenis Tanah</label>
                        </div>
                        <div class="icheck-danger">
                            <input type="checkbox" id="toggle-land-cover">
                            <label for="toggle-land-cover" id="label-land-cover">Tutupan Lahan</label>
                        </div>
                        <div class="icheck-primary">
                            <input type="checkbox" id="toggle-irrigation">
                            <label for="toggle-irrigation" id="label-irrigation">Irigasi</label>
                        </div>
                        <div class="icheck-primary">
                            <input type="checkbox" id="toggle-roads">
                            <label for="toggle-roads" id="label-roads">Jalan Pendukung</label>
                        </div>
                        <div class="icheck-primary">
                            <input type="checkbox" id="toggle-land-ownership">
                            <label for="toggle-land-ownership" id="label-land-ownership">Kepemilikan Lahan</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agropolitanUrl = "{{ route('lokasi-agropolitan.geojson') }}";
            const batasKecamatan = "{{ asset('geojson/batas_kecamatan.geojson') }}";
            const sungaiUrl = "{{ asset('geojson/Sungai.json') }}";
            const tanahUrl = "{{ asset('geojson/Tanah.json') }}";
            const tutupanLahanUrl = "{{ asset('geojson/tutupan_lahan.json') }}";

            const newLayerUrl = "{{ asset('geojson/kepemilikan_lahan/lahan_bungur_batumandi.geojson') }}";

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
                    this._container.style.display = 'none'; // Sembunyikan secara default
                    // Isi HTML legenda sesuai dengan gambar Peta Penutupan Lahan
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
                                'fill-color': '#008000',
                                'fill-opacity': 0.7
                            }
                        });

                        // Layer untuk garis batas poligon
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
                                // desa,
                                kecamatan
                            } = feature.properties;
                            let coordinates;

                            // Handle both Polygon and MultiPolygon types
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
                                'line-width': 0.7
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
                                    ], // Properti yang digunakan untuk mencocokkan

                                    // ===== PALET WARNA BARU =====
                                    'ROC', '#BDBDBD', // Batuan Permukaan (Abu-abu muda)
                                    'Typic Endoaquepts',
                                    '#8FBC8F', // Tanah Aluvial Rawa (Hijau keabuan)
                                    'Typic Eutrudepts',
                                    '#A0522D', // Tanah Aluvial Subur (Coklat subur)
                                    'Typic Haplosaprists',
                                    '#594640', // Tanah Gambut/Organik (Coklat sangat gelap)
                                    'Typic Hapludox',
                                    '#BC8F8F', // Tanah Tropis Lapuk (Coklat kemerahan)
                                    'Typic Hapludults',
                                    '#F4A460', // Tanah Podsolik Merah-Kuning (Kuning pasir)
                                    'No Data', '#E0E0E0', // Untuk properti 'No Data'
                                    '#CCCCCC'
                                ],
                                'fill-opacity': 0.8 // Opacity bisa disesuaikan agar terlihat lebih solid
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
                                'visibility': 'none' // Sembunyikan secara default
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
                                    '#cccccc' // Warna default jika tidak ada yang cocok
                                ],
                                'fill-opacity': 0.7
                            }
                            //...
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

                fetch(newLayerUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Add new source
                        map.addSource('new-layer', {
                            type: 'geojson',
                            data: data
                        });

                        map.addLayer({
                            id: 'new-layer',
                            type: 'fill',
                            source: 'new-layer',
                            layout: {
                                'visibility': 'none'
                            },
                            paint: {
                                'fill-color': '#FF0000',
                                'fill-opacity': 0.5
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
                toggleLayer('toggle-borders', ['administrasi-layer', 'administrasi-borders']);
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
                        // Picu event 'change' secara manual untuk menonaktifkan layer & legenda Tutupan Lahan
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
                    'new-layer'
                ]);
            });

        });
    </script>
@stop
