@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="width: 100%; max-width: 600px;">
        <div class="card-body">
            <h2>Daftar Jasa</h2>
            <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Tambah Jasa</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->nama }}</td>
                        <td>{{ $service->category->nama }}</td>
                        <td>Rp {{ number_format($service->harga) }}</td>
                        <td>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
