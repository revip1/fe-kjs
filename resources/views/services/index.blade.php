@extends('layouts.master')

@section('content')
<div class="container">
    {{-- Card utama --}}
    <div class="card shadow-sm" style="width: 100%; max-width: 1000px;">
        <div class="card-body">

            {{-- Header: Judul, tombol tambah jasa, dan search bar --}}
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h2 class="mb-2">Daftar Jasa</h2>
                    <a href="{{ route('services.create') }}" class="btn btn-primary">Tambah Jasa</a>
                </div>

                {{-- Form pencarian jasa --}}
                <form method="GET" action="{{ route('services.index') }}" style="max-width: 250px; width: 100%;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control me-3" placeholder="Cari Jasa" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>

            {{-- Flash message jika sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Tabel daftar jasa --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        {{-- Penomoran sesuai halaman --}}
                        <td>{{ $loop->iteration + ($services->currentPage() - 1) * $services->perPage() }}</td>
                        <td>{{ $service->nama }}</td>
                        <td>{{ $service->category->nama }}</td>
                        <td>Rp {{ number_format($service->harga) }}</td>
                        <td>
                            {{-- Tombol edit --}}
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>

                            {{-- Tombol hapus dengan konfirmasi --}}
                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end">
            {{ $services->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
