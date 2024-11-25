@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <!-- Interactive Map -->
    <div id="map" class="shadow mb-4"></div>
    <div class="button-container d-flex flex-wrap justify-content-center my-3"></div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/back.css') }}">
    <!-- MapLibre CSS -->
    <link href="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css" rel="stylesheet" />
@stop

@section('js')
    <!-- MapLibre JS -->
    <script src="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var agropolitanUrl = "{{ asset('geojson/Agropolitan.json') }}";
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
                center: [115.497, -2.308], // Adjust to your desired coordinates
                zoom: 11
            });

            map.addControl(new maplibregl.NavigationControl());

            let currentHighlightedButton = null;

            fetch(agropolitanUrl)
                .then(response => response.json())
                .then(data => {
                    map.addSource('agropolitan-areas', {
                        'type': 'geojson',
                        'data': data
                    });

                    map.addLayer({
                        'id': 'agropolitan-areas-layer',
                        'type': 'fill',
                        'source': 'agropolitan-areas',
                        'paint': {
                            'fill-color': '#00FF00',
                            'fill-opacity': 0.5
                        }
                    });

                    map.addLayer({
                        'id': 'agropolitan-areas-borders',
                        'type': 'line',
                        'source': 'agropolitan-areas',
                        'paint': {
                            'line-color': '#008000',
                            'line-width': 2
                        }
                    });

                    var buttonContainer = document.querySelector('.button-container');

                    data.features.forEach(feature => {
                        const areaId = feature.id;
                        const desaName = feature.properties.Desa;
                        const coordinates = feature.geometry.coordinates[0][0];

                        var button = document.createElement('button');
                        button.id = `area-button-${areaId}`;
                        button.textContent = `${areaId} - ${desaName}`;
                        button.classList.add('btn', 'btn-outline-success', 'm-2');

                        button.onclick = () => {
                            map.flyTo({
                                center: coordinates,
                                zoom: 14,
                                speed: 0.5,
                                curve: 1.5
                            });

                            highlightButton(button);
                        };

                        buttonContainer.appendChild(button);
                    });

                    var popup = new maplibregl.Popup({
                        closeButton: false,
                        closeOnClick: false
                    });

                    function highlightButton(button) {
                        if (currentHighlightedButton) {
                            currentHighlightedButton.classList.remove('highlighted');
                        }
                        button.classList.add('highlighted');
                        currentHighlightedButton = button;
                    }

                    map.on('click', 'agropolitan-areas-layer', function(e) {
                        var properties = e.features[0].properties;
                        var desaName = properties.Desa;
                        var areaId = e.features[0].id;
                        var kecamatan = properties.Kecamatan;
                        var klsLereng = properties.Kls_lereng;
                        var irigasi = properties.Irigasi;

                        popup.setLngLat(e.lngLat)
                            .setHTML(`
                                <strong>${areaId} - ${desaName}</strong><br>
                                <strong>Kecamatan:</strong> ${kecamatan}<br>
                                <strong>Kelas Lereng:</strong> ${klsLereng}<br>
                                <strong>Irigasi:</strong> ${irigasi}
                            `)
                            .addTo(map);

                        var button = document.getElementById(`area-button-${areaId}`);
                        if (button) {
                            highlightButton(button);
                        }
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', 'agropolitan-areas-layer', function() {
                        map.getCanvas().style.cursor = '';
                    });
                });

            fetch(administrasiDesaUrl)
                .then(response => response.json())
                .then(data => {
                    map.addSource('administrasi-desa', {
                        'type': 'geojson',
                        'data': data
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
                });
        });
    </script>
@stop
