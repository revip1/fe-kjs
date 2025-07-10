@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Tambah Jasa</h2>

        <form method="POST" action="{{ route('services.update', $service) }}">
        @csrf @method('PUT')

        <select name="categories_id" class="form-control">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $service->categories_id == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                </option>
            @endforeach
        </select>

        <input type="text" name="nama" value="{{ $service->nama }}" class="form-control" required>
        <input type="number" name="harga" value="{{ $service->harga }}" class="form-control" required>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

</div>
@endsection
