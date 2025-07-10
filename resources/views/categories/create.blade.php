@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="width: 100%; max-width: 600px;">
        <div class="card-body">
        <h1>Tambah Kategori</h1>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="text-right">
                    <button type="submit" class="btn btn-success mt-3">Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
