@extends('layouts.master')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3">Daftar HPS</h2>
            <a href="{{ route('hps.create') }}" class="btn btn-primary mb-3">Tambah HPS</a>

            <table class="table table-bordered text-center align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Cargo</th>
                        <th>Consignee</th>
                        <th>Vessel</th>
                        <th>Ton/Gang/Day</th>
                        <th>Tonase</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Shift</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hpsHeaders as $index => $header)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $header->cargo_name }}</td>
                        <td>{{ $header->consignee }}</td>
                        <td>{{ $header->vessel_name }}</td>
                        <td>{{ $header->tgd }}</td>
                        <td>{{ $header->tonase }}</td>
                        <td>{{ number_format($header->hari, 3, ',', '.') }}</td>
                        <td>{{ number_format($header->jam, 3, ',', '.') }}</td>
                        <td>{{ number_format($header->shift, 3, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('hps.show', $header->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('hps.edit', $header->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('hps.destroy', $header->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                    {{-- Baris Collapse untuk Pricelist --}}
                    <tr class="collapse" id="pricelist-{{ $header->id }}">
                        <td colspan="10">
                            <div class="card card-body">
                                <h5 class="mb-3">Pricelist: {{ $header->cargo_name }}</h5>
                                <table class="table table-sm table-bordered text-center align-middle">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Jasa</th>
                                            <th>Qty</th>
                                            <th>Jumlah Pemakaian</th>
                                            <th>Price</th>
                                            <th>Satuan</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($header->pricelists as $i => $pl)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $pl->service->nama ?? '-' }}</td>
                                            <td>{{ $pl->qty }}</td>
                                            <td>{{ $pl->jml_pemakaian }}</td>
                                            <td>{{ number_format($pl->price, 0, ',', '.') }}</td>
                                            <td>{{ $pl->satuan }}</td>
                                            <td>{{ number_format($pl->total, 0, ',', '.') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Tidak ada data pricelist.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    document.addEventListener("DOMContentLoaded", function(){
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

@endsection
