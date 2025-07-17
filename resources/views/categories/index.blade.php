@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="width: 100%; max-width: 1000px;">
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

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


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td>{{ $category->nama }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
                {{ $categories->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
