@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('css')
    <link href="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css" rel="stylesheet" />
    <style>
        /* Card Styling */
        .card {
            border: none;
            border-radius: 6px;
            background-color: #f8f9fa;
            padding: 1px;
        }

        /* Map Styling */
        #map {
            width: 100%;
            height: 500px;
        }

        /* Dropdown Container Styling */
        #dropdown-container {
            max-height: 500px;
            overflow-y: auto;
        }

        /* List Group Item Styling */
        .list-group-item {
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .list-group-item:hover,
        .list-group-item.active {
            background-color: #28a745;
            color: white;
        }

        /* Reset Button Styling */
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

        /* Label Styling */
        .form-check-label {
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Label Colors */
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

        /* Custom Checkbox Styles using icheck-bootstrap */
        .icheck-primary input#toggle-borders:checked+label::before {
            background-color: #000000;
            border-color: #000000;
            color: white;
        }

        .icheck-primary input#toggle-rivers:checked+label::before {
            background-color: #1E90FF;
            border-color: #1E90FF;
            color: white;
        }

        .icheck-primary input#toggle-soil:checked+label::before {
            background-color: #A0522D;
            border-color: #A0522D;
            color: white;
        }

        .icheck-primary input#toggle-irrigation:checked+label::before {
            background-color: #0E7490;
            border-color: #0E7490;
            color: white;
        }

        .icheck-primary input#toggle-roads:checked+label::before {
            background-color: #D22B2B;
            border-color: #D22B2B;
            color: white;
        }

        .icheck-primary input#toggle-land-ownership:checked+label::before {
            background-color: #32CD32;
            border-color: #32CD32;
            color: white;
        }
    </style>
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
                            console.log(properties)
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
@stop
