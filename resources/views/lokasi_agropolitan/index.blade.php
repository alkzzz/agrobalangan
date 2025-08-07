@extends('adminlte::page')

@section('title', 'Lokasi Agropolitan')

@section('content_header')
    <h1>Lokasi Agropolitan</h1>
@stop

@section('css')
    {{-- Tambahkan CSS untuk DataTables jika belum ada di layout utama --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="lokasiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Luas (Ha)</th>
                        <th>Irigasi</th>
                        <th>Kelas Lereng</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data dari controller --}}
                    @foreach ($lokasiAgropolitan as $lokasi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lokasi->kecamatan->name }}</td>
                            <td>{{ number_format($lokasi->luas_ha, 2, ',', '.') }}</td>
                            <td>{{ $lokasi->irigasi }}</td>
                            <td>{{ $lokasi->kls_lereng }}</td>
                            <td>
                                <a href="{{ route('lokasi-agropolitan.detail', $lokasi->id) }}" class="btn btn-danger"><i
                                        class="fas fa-list-ul"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    {{-- Tambahkan JS untuk DataTables jika belum ada --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#lokasiTable').DataTable();
        });
    </script>
@stop
