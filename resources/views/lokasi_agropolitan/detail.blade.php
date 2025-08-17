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
                            {{-- Link Dokumentasi --}}
                            <a href="{{ route('lokasi.dokumentasi.tanah', $lokasi->id) }}" target="_blank"
                                class="btn btn-outline-success float-right">
                                <i class="fas fa-images mr-1"></i> Lihat Dokumentasi
                            </a>
                            <h4>Data Analisis Tanah</h4>
                            @if ($analisisTanah)
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-striped" style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <th style="width: 30%;">Tekstur</th>
                                                <td>{{ $analisisTanah->tekstur ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>pH</th>
                                                <td>{{ $analisisTanah->ph ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>C-Organik (%)</th>
                                                <td>{{ $analisisTanah->c_organik ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>N-Total (%)</th>
                                                <td>{{ $analisisTanah->n_total ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>P-Potensial (Mg/100g)</th>
                                                <td>{{ $analisisTanah->p_potensial ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>K-Potensial (Mg/100g)</th>
                                                <td>{{ $analisisTanah->k_potensial ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>KTK (Cmol(+)/kg)</th>
                                                <td>{{ $analisisTanah->ktk ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kejenuhan Basa (%)</th>
                                                <td>{{ $analisisTanah->kejenuhan_basa ?? '-' }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th colspan="2" class="text-center">Kesesuaian Lahan</th>
                                            </tr>
                                            <tr>
                                                <th>Kesesuaian Aktual</th>
                                                <td>{{ $analisisTanah->kesesuaian_aktual ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Faktor Pembatas</th>
                                                <td>{{ $analisisTanah->faktor_pembatas ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kesesuaian Potensial</th>
                                                <td>{{ $analisisTanah->kesesuaian_potensial ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-right mt-3">
                                        <button type="button" class="btn btn-warning btn-edit-analisis" data-toggle="modal"
                                            data-target="#modalEditAnalisisTanah"
                                            data-update-url="{{ route('analisis-tanah.update', $analisisTanah->id) }}"
                                            data-analisis='{{ json_encode($analisisTanah) }}'>
                                            <i class="fas fa-edit mr-1"></i> Edit Data
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="icon fas fa-info"></i> Data analisis tanah untuk lokasi ini belum tersedia.
                                </div>
                            @endif
                        </div>

                        {{-- Tab Pane untuk Kepemilikan Lahan --}}
                        <div class="tab-pane fade" id="tab-kepemilikan" role="tabpanel"
                            aria-labelledby="tab-kepemilikan-link">
                            {{-- Link Dokumentasi --}}
                            <a href="{{ route('lokasi.dokumentasi.kepemilikan', $lokasi->id) }}" target="_blank"
                                class="btn btn-outline-success float-right">
                                <i class="fas fa-images mr-1"></i> Lihat Dokumentasi
                            </a>
                            <h4>Data Kepemilikan Lahan</h4>
                            <table id="table-kepemilikan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Pemilik</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kepemilikanList as $i => $k)
                                        <tr>
                                            <td width="5%">{{ $i + 1 }}</td>
                                            <td>{{ $k['nama_pemilik'] }}</td>
                                            <td>{{ $k['keterangan'] }}</td>
                                            <td width="25%">
                                                {{-- Tombol untuk zoom ke lokasi persil --}}
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="zoomToParcel({{ $k['id'] }})">
                                                    <i class="fas fa-fw fa-map-pin"></i> Zoom ke Lokasi
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning btn-edit-kepemilikan"
                                                    data-id="{{ $k['id'] }}" data-nama="{{ $k['nama_pemilik'] }}"
                                                    data-keterangan="{{ $k['keterangan'] }}">
                                                    <i class="fas fa-fw fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('kepemilikan-lahan.destroy', $k['id']) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-fw fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Tab Pane untuk Irigasi --}}
                        <div class="tab-pane fade" id="tab-irigasi" role="tabpanel" aria-labelledby="tab-irigasi-link">
                            {{-- Link Dokumentasi --}}
                            <a href="{{ route('lokasi.dokumentasi.irigasi', $lokasi->id) }}" target="_blank"
                                class="btn btn-outline-success float-right">
                                <i class="fas fa-images mr-1"></i> Lihat Dokumentasi
                            </a>
                            <h4>Data Jaringan Irigasi</h4>
                            <p>Informasi mengenai saluran irigasi primer, sekunder, dan tersier yang ada.</p>
                            {{-- TODO: Tampilkan data irigasi di sini --}}
                            <table class="table table-bordered">
                                {{-- ... tabel data irigasi ... --}}
                            </table>
                        </div>

                        {{-- Tab Pane untuk Transportasi --}}
                        <div class="tab-pane fade" id="tab-jalan" role="tabpanel" aria-labelledby="tab-jalan-link">
                            {{-- Link Dokumentasi --}}
                            <a href="{{ route('lokasi.dokumentasi.jalan', $lokasi->id) }}" target="_blank"
                                class="btn btn-outline-success float-right">
                                <i class="fas fa-images mr-1"></i> Lihat Dokumentasi
                            </a>
                            <h4>Data Infrastruktur Jalan</h4>
                            <p>Daftar jalan usaha tani, jalan produksi, dan akses jalan utama ke lokasi.</p>
                            {{-- TODO: Tampilkan data transportasi di sini --}}
                            <table class="table table-bordered">
                                {{-- ... tabel data transportasi ... --}}
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Modal Edit Kepemilikan --}}
                <div class="modal fade" id="modalEditKepemilikan" tabindex="-1" role="dialog"
                    aria-labelledby="modalEditTitle" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <form id="formEditKepemilikan" method="POST" action="#">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditTitle"><i
                                            class="fas fa-user-check mr-2"></i>Edit Kepemilikan Lahan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="inpNamaPemilik">Nama Pemilik <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama_pemilik" id="inpNamaPemilik"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="inpKeterangan">Keterangan</label>
                                        <textarea name="keterangan" id="inpKeterangan" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                            class="fas fa-ban mr-1"></i> Batal</button>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>Simpan
                                        Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="modalEditAnalisisTanah" tabindex="-1" role="dialog"
                    aria-labelledby="modalEditAnalisisTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form id="formEditAnalisisTanah" method="POST" action="#">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditAnalisisTitle"><i
                                            class="fas fa-vial mr-2"></i>Edit Data Analisis Tanah</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="tekstur">Tekstur</label>
                                            <input type="text" name="tekstur" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="ph">pH</label>
                                            <input type="number" step="0.01" name="ph" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="c_organik">C-Organik (%)</label>
                                            <input type="number" step="0.01" name="c_organik" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="n_total">N-Total (%)</label>
                                            <input type="number" step="0.01" name="n_total" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="p_potensial">P-Potensial (Mg/100g)</label>
                                            <input type="number" step="0.01" name="p_potensial"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="k_potensial">K-Potensial (Mg/100g)</label>
                                            <input type="number" step="0.01" name="k_potensial"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="ktk">KTK (Cmol(+)/kg)</label>
                                            <input type="number" step="0.01" name="ktk" class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="kejenuhan_basa">Kejenuhan Basa (%)</label>
                                            <input type="number" step="0.01" name="kejenuhan_basa"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Kesesuaian Lahan</h5>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="kesesuaian_aktual">Kesesuaian Aktual</label>
                                            <input type="text" name="kesesuaian_aktual" class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="kesesuaian_potensial">Kesesuaian Potensial</label>
                                            <input type="text" name="kesesuaian_potensial" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="faktor_pembatas">Faktor Pembatas</label>
                                        <textarea name="faktor_pembatas" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                            class="fas fa-ban mr-1"></i>Batal</button>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                        Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const lokasiGeoJson = {!! json_encode($geoJsonData) !!};
        const parcelGeoJson = {!! json_encode($kepemilikanGeoJson) !!};

        const map = new maplibregl.Map({
            container: 'map',
            style: {
                version: 8,
                glyphs: 'https://demotiles.maplibre.org/font/{fontstack}/{range}.pbf',
                sources: {
                    osm: {
                        type: 'raster',
                        tiles: ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
                        tileSize: 256
                    }
                },
                layers: [{
                    id: 'osm-tiles',
                    type: 'raster',
                    source: 'osm'
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
                    duration: 1000
                });
            }
        }

        function toggleParcelLayers(visible) {
            if (!map.getLayer('persil-fill')) {
                return;
            }
            const visibility = visible ? 'visible' : 'none';
            map.setLayoutProperty('persil-fill', 'visibility', visibility);
            map.setLayoutProperty('persil-line', 'visibility', visibility);
            map.setLayoutProperty('persil-label', 'visibility', visibility);
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
                        'fill-color': '#00EE00',
                        'fill-opacity': 0.9
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

                if (parcelGeoJson && parcelGeoJson.features && parcelGeoJson.features.length) {
                    map.addSource('persil', {
                        type: 'geojson',
                        data: parcelGeoJson
                    });

                    map.addLayer({
                        id: 'persil-fill',
                        type: 'fill',
                        source: 'persil',
                        paint: {
                            'fill-color': '#FF8C00',
                            'fill-opacity': 0.8
                        }
                    });
                    map.addLayer({
                        id: 'persil-line',
                        type: 'line',
                        source: 'persil',
                        paint: {
                            'line-color': '#4B2D0A',
                            'line-width': 1.5
                        }
                    });
                    map.addLayer({
                        id: 'persil-label',
                        type: 'symbol',
                        source: 'persil',
                        layout: {
                            'text-field': ['get', 'nama_pemilik'],
                            'text-size': 12
                        },
                        paint: {
                            'text-halo-width': 1,
                            'text-halo-color': '#ffffff'
                        }
                    });

                    toggleParcelLayers(false);

                    map.on('click', 'persil-fill', (e) => {
                        const p = e.features[0].properties;
                        new maplibregl.Popup()
                            .setLngLat(e.lngLat)
                            .setHTML(`<strong>${p.nama_pemilik}</strong><br>ID: ${p.id}`)
                            .addTo(map);
                    });
                    map.on('mouseenter', 'persil-fill', () => map.getCanvas().style.cursor = 'pointer');
                    map.on('mouseleave', 'persil-fill', () => map.getCanvas().style.cursor = '');
                }
            } else {
                document.getElementById('map').innerHTML =
                    '<div class="alert alert-danger m-3">Data Peta untuk lokasi ini tidak ditemukan.</div>';
            }
        });

        window.zoomToParcel = function(id) {
            if (!parcelGeoJson || !parcelGeoJson.features) return;
            const feature = parcelGeoJson.features.find(f => Number(f.properties.id) === Number(id));
            if (!feature) return;

            toggleParcelLayers(true);
            $('#tab-kepemilikan-link').tab('show');
            fitMapToBounds(map, feature.geometry);

            document.getElementById('map').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        };
    </script>
    <script>
        $(function() {
            const commonOpts = {
                responsive: true,
                autoWidth: false,
                language: {
                    url: '{{ asset('js/id.json') }}'
                }
            };

            const tableOptsWithButtons = {
                ...commonOpts,
                lengthChange: true,
                ordering: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible:not(:last-child)',
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    'colvis'
                ]
            };

            $('#table-kepemilikan, #table-tanah, #table-irigasi, #table-transportasi').DataTable(
                tableOptsWithButtons);

            $('a[data-toggle="pill"]').on('shown.bs.tab', function(event) {
                const activeTabId = $(event.target).attr('id');

                if (activeTabId === 'tab-kepemilikan-link') {
                    toggleParcelLayers(true);
                } else {
                    toggleParcelLayers(false);
                }
                map.resize();
            });
        });
    </script>
    <script>
        $(function() {
            const updateUrlTemplate = "{{ route('kepemilikan-lahan.update', ':id') }}";

            $(document).on('click', '.btn-edit-kepemilikan', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const ket = $(this).data('keterangan');

                $('#formEditKepemilikan').attr('action', updateUrlTemplate.replace(':id', id));
                $('#formEditKepemilikan [name="nama_pemilik"]').val(nama);
                $('#formEditKepemilikan [name="keterangan"]').val(ket);

                $('#modalEditKepemilikan').modal('show');
            });

            $('#modalEditKepemilikan').on('shown.bs.modal', function() {
                $(this).find('input[name="nama_pemilik"]').trigger('focus');
            });

            $(document).on('submit', '.form-delete', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Konfirmasi Penghapusan Data',
                    text: "Apakah Anda yakin ingin menghapus data ini? Data yang telah dihapus tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash mr-1"></i> Hapus Data',
                    cancelButtonText: '<i class="fas fa-ban mr-1"></i> Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        $(document).on('click', '.btn-edit-analisis', function() {
            const updateUrl = $(this).data('update-url');
            const data = $(this).data('analisis');

            const form = $('#formEditAnalisisTanah');

            form.attr('action', updateUrl);

            form.find('[name="tekstur"]').val(data.tekstur);
            form.find('[name="ph"]').val(data.ph);
            form.find('[name="c_organik"]').val(data.c_organik);
            form.find('[name="n_total"]').val(data.n_total);
            form.find('[name="p_potensial"]').val(data.p_potensial);
            form.find('[name="k_potensial"]').val(data.k_potensial);
            form.find('[name="ktk"]').val(data.ktk);
            form.find('[name="kejenuhan_basa"]').val(data.kejenuhan_basa);
            form.find('[name="kesesuaian_aktual"]').val(data.kesesuaian_aktual);
            form.find('[name="faktor_pembatas"]').val(data.faktor_pembatas);
            form.find('[name="kesesuaian_potensial"]').val(data.kesesuaian_potensial);
        });


        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json(session('success')),
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        @endif
    </script>
@stop
