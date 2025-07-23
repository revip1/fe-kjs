@extends('layouts.master')

@section('content')
<div class="container d-flex mt-4 justify-content-center">
    <div class="card shadow-sm" style="width: 100%; max-width: 600px;">
        <div class="card-body">
            <h2 class="mb-4">Tambah Jasa</h2>

            {{-- Notifikasi sukses setelah submit --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form untuk menambah jasa baru --}}
            <form action="{{ route('services.store') }}" method="POST">
                @csrf

                {{-- Dropdown untuk memilih kategori + tombol tambah kategori (modal) --}}
                <div class="form-group mb-3">
                    <label for="categories_id">Kategori</label>
                    <div class="d-flex gap-2">
                        <select name="categories_id" id="kategoriSelect" class="form-control" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#kategoriModal">+</button>
                    </div>
                </div>

                {{-- Input nama jasa --}}
                <div class="form-group mb-3">
                    <label for="nama">Nama Jasa</label>
                    <input type="text" name="nama" id="nama" class="form-control" required placeholder="Masukkan nama jasa" autofocus>
                </div>

                {{-- Input harga jasa --}}
                <div class="form-group mb-3">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" required placeholder="Rp" min="0">
                </div>

                {{-- Tombol simpan jasa --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success mt-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal untuk menambahkan kategori baru tanpa reload halaman --}}
<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            {{-- Form kategori AJAX --}}
            <form id="addCategoryAjaxForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Input kategori baru --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaKategoriBaru">Nama Kategori</label>
                        <input type="text" name="nama" id="namaKategoriBaru" class="form-control" placeholder="Contoh: Bongkar Muat" required>
                    </div>
                    <div class="text-danger small mt-2 d-none" id="kategoriError"></div>
                </div>

                {{-- Tombol aksi --}}
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
{{-- jQuery untuk menangani AJAX tambah kategori --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Ketika form modal disubmit
        $('#addCategoryAjaxForm').on('submit', function (e) {
            e.preventDefault();

            const nama = $('#namaKategoriBaru').val().trim(); // Ambil nilai input
            const errorDiv = $('#kategoriError'); // Element untuk pesan error

            // Validasi jika kosong
            if (!nama) {
                errorDiv.text('Nama kategori tidak boleh kosong.').removeClass('d-none');
                return;
            }

            errorDiv.addClass('d-none'); // Sembunyikan error jika ada sebelumnya

            // AJAX POST ke route Laravel
            $.ajax({
                url: '{{ route("categories.services") }}', // Route untuk store kategori
                method: 'POST',
                data: {
                    nama: nama,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        // Tambahkan kategori baru ke select dan pilih langsung
                        $('#kategoriSelect').append(`<option value="${response.category.id}" selected>${response.category.nama}</option>`);
                        $('#kategoriModal').modal('hide'); // Tutup modal
                        $('#namaKategoriBaru').val(''); // Reset input
                    } else {
                        // Tampilkan pesan error jika gagal
                        errorDiv.text(response.message || 'Terjadi kesalahan.').removeClass('d-none');
                    }
                },
                error: function () {
                    // Tampilkan error jika AJAX gagal
                    errorDiv.text('Gagal menambah kategori.').removeClass('d-none');
                }
            });
        });
    });
</script>
@endsection
