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
        <div class="card-header">
            {{-- Tombol Tambah Data (akan berfungsi nanti saat method create & store dibuat) --}}
            <a href="{{ route('lokasi-agropolitan.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Lokasi
            </a>
        </div>
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
                            <td>{{ $lokasi->luas_ha }}</td>
                            <td>{{ $lokasi->irigasi }}</td>
                            <td>{{ $lokasi->kls_lereng }}</td>
                            <td>
                                {{-- Tombol Aksi (Lihat, Edit, Hapus) --}}
                                <a href="{{ route('lokasi-agropolitan.show', $lokasi->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('lokasi-agropolitan.edit', $lokasi->id) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('lokasi-agropolitan.destroy', $lokasi->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
