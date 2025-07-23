@extends('layouts.master')

@section('content')
<div class="container">
    {{-- Card utama --}}
    <div class="card shadow-sm" style="width: 100%; max-width: 1000px;">
        <div class="card-body">

            {{-- Flash message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            {{-- Header: title, tombol tambah, dan search bar --}}
            <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap">
                <div class="mb-2">
                    <h2 class="mb-2">Daftar Kategori</h2>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
                </div>
                <form method="GET" action="{{ route('categories.index') }}" style="max-width: 250px; width: 100%;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control me-3" placeholder="Cari Kategori" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>

            {{-- Tabel kategori --}}
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                        <td>{{ $category->nama }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Edit Kategori">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted">Belum ada kategori yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end p-3">
            {{ $categories->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
