@extends('adminlte::page')

@section('title', 'Area Potensial')

@section('content_header')
    <h1>Area Potensial</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success" data-toggle="modal" data-target="#addAreaModal">
                <i class="fas fa-plus"></i> Tambah Area Potensial
            </button>
        </div>
        <div class="card-body">
            <table id="areaPotensialTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th>Luas</th>
                        <th>Irigasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $area)
                        <tr>
                            <td>{{ $area->desa }}</td>
                            <td>{{ $area->kecamatan }}</td>
                            <td>{{ $area->luas }}</td>
                            <td>{{ $area->irigasi }}</td>
                            <td>
                                <a href="{{ route('potential-area.show', $area->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <button class="btn btn-primary btn-sm editBtn" data-id="{{ $area->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $area->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addAreaModal" tabindex="-1" role="dialog" aria-labelledby="addAreaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addAreaForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAreaModalLabel">Tambah Area Potensial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="desa">Desa</label>
                            <input type="text" class="form-control" id="desa" name="desa" required>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                        </div>
                        <div class="form-group">
                            <label for="luas">Luas</label>
                            <input type="number" step="0.01" class="form-control" id="luas" name="luas">
                        </div>
                        <div class="form-group">
                            <label for="irigasi">Irigasi</label>
                            <input type="text" class="form-control" id="irigasi" name="irigasi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#areaPotensialTable').DataTable();

            $('#addAreaForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('potential-area.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            $('.editBtn').on('click', function() {
                let id = $(this).data('id');
                // Fetch data and populate modal
            });

            $('.deleteBtn').on('click', function() {
                let id = $(this).data('id');
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: `/area-potensial/${id}`,
                        method: 'DELETE',
                        success: function(response) {
                            location.reload();
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    </script>
@stop
