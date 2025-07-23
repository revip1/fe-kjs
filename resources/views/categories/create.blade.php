@extends('layouts.master')

@section('content')
<div class="container">
    {{-- Card utama --}}
    <div class="card shadow-sm" style="width: 100%; max-width: 600px;">
        <div class="card-body">
            
            {{-- Judul halaman --}}
            <h1>Tambah Kategori</h1>
            
            {{-- Form tambah kategori --}}
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                
                {{-- Input nama kategori --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                
                {{-- Tombol simpan --}}
                <div class="text-right">
                    <button type="submit" class="btn btn-success mt-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
