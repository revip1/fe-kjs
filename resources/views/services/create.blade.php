@extends('layouts.master')

@section('content')
<div class="container d-flex mt-4">
    <div class="card shadow-sm" style="width: 100%; max-width: 600px;">
        <div class="card-body">
            <h1 class="mb-4">Tambah Jasa</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('services.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="categories_id">Kategori</label>
                    <div class="d-flex">
                        <select name="categories_id" id="kategoriSelect" class="form-control mr-2" required style="flex: 1;">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#kategoriModal">
                            +
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Jasa</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" required>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success mt-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addCategoryAjaxForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="kategoriModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaKategoriBaru">Nama Kategori</label>
                        <input type="text" name="nama" id="namaKategoriBaru" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#addCategoryAjaxForm').on('submit', function (e) {
            e.preventDefault();

            let nama = $('#namaKategoriBaru').val().trim();
            if (!nama) {
                alert('Nama kategori tidak boleh kosong.');
                return;
            }

            $.ajax({
                url: '{{ route("categories.services") }}',
                method: 'POST',
                data: {
                    nama: nama,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        $('#kategoriSelect').append(`<option value="${response.category.id}" selected>${response.category.nama}</option>`);
                        $('#kategoriModal').modal('hide');
                        $('#namaKategoriBaru').val('');
                    } else {
                        alert('Gagal menambah kategori: ' + (response.message || 'Unknown error.'));
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan saat menambah kategori.');
                }
            });
        });
    });
</script>
@endsection