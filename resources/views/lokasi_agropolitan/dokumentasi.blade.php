@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>
        {{ $headerTitle }}: <strong>{{ $lokasi->kecamatan->name }}</strong>
    </h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
@stop

@section('content')

    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-between">
            <a href="{{ route('lokasi-agropolitan.detail', $lokasi->id) }}" class="btn btn-success">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahMedia">
                <i class="fas fa-plus mr-1"></i> Tambah Dokumentasi
            </button>
        </div>
    </div>

    <p style="font-style: italic;font-size: 12px;color:blue">*Klik gambar untuk memperbesar</p>
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                @forelse ($mediaList as $media)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">

                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <a href="{{ $media->url }}" data-toggle="lightbox"
                                            data-title="{{ $media->caption ?? 'Dokumentasi' }}" data-gallery="gallery">
                                            <img src="{{ $media->url }}" alt="{{ $media->caption }}" class="img-fluid"
                                                style="height: 200px; width: auto; object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <p class="text-muted mb-0">
                                            <b>Keterangan: </b> {{ $media->caption ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button class="btn btn-sm btn-warning btn-edit-media" data-id="{{ $media->id }}"
                                        data-caption="{{ $media->caption }}"
                                        data-update-url="{{ route('media.update', $media->id) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('media.destroy', $media->id) }}" method="POST"
                                        class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle mr-2"></i> Belum ada dokumentasi yang diunggah.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalTambahMedia" tabindex="-1" role="dialog" aria-labelledby="modalTambahMediaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('lokasi.dokumentasi.store', $lokasi->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="collection" value="{{ $collectionName }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahMediaLabel"><i class="fas fa-images mr-2"></i>Tambah
                            Dokumentasi Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="files">Pilih Gambar (Bisa lebih dari satu)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    {{-- Input file dengan atribut 'multiple' untuk bulk upload --}}
                                    <input type="file" class="custom-file-input" name="files[]" id="files" multiple
                                        required>
                                    <label class="custom-file-label" for="files">Pilih file...</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Unggah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalEditMedia" tabindex="-1" role="dialog" aria-labelledby="modalEditMediaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="formEditMedia" method="POST" action="#">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditMediaLabel"><i class="fas fa-edit mr-2"></i>Edit Keterangan
                            Gambar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="caption">Keterangan</label>
                            <textarea name="caption" id="caption" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>Simpan
                            Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            // Handler untuk tombol EDIT
            $('.btn-edit-media').on('click', function() {
                const updateUrl = $(this).data('update-url');
                const caption = $(this).data('caption');

                $('#formEditMedia').attr('action', updateUrl);
                $('#formEditMedia #caption').val(caption);

                $('#modalEditMedia').modal('show');
            });

            $('.form-delete').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Dokumentasi yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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
