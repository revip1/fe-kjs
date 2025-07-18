@extends('layouts.master')

@section('content')
<div class="container d-flex mt-4">
    <div class="card shadow-sm" style="width: 100%; max-width: 1000px;">
        <div class="card-body">
            <h1 class="mb-4">Edit Kategori</h1>

            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control" value="{{ $category->nama }}" required>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary ml-2">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
