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
        <form method="GET" action="{{ route('hps.overview') }}" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari cargo, consignee, vessel..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Cargo Name</th>
                        <th>Consignee</th>
                        <th>Vessel</th>
                        <th>Tonase</th>
                        <th>Ton/Gang/Day</th>
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
                        <td>{{ $header->tonase }}</td>
                        <td>{{ $header->tgd }}</td>
                        <td>{{ $header->hari }}</td>
                        <td>{{ $header->jam }}</td>
                        <td>{{ $header->shift }}</td>
                        <td>
                        <a href="{{ route('hps.show', $header->id) }}" class="btn btn-sm btn-info">
                            Lihat Detail
                        </a>
                        </td>
                    </tr>
                    <tr class="collapse" id="pricelist-{{ $header->id }}">
                        <td colspan="8">
                            <div class="card card-body">
                                <h5 class="mb-3">Pricelist untuk HPS: {{ $header->cargo_name }}</h5>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Qty</th>
                                            <th>Jumlah Pemakaian</th>
                                            <th>Price</th>
                                            <th>Satuan</th>
                                            <th>Total</th>
                                            <th>Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($header->pricelists as $i => $pl)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $pl->nama }}</td>
                                            <td>{{ $pl->qty }}</td>
                                            <td>{{ $pl->jml_pemakaian }}</td>
                                            <td>{{ number_format($pl->price, 0, ',', '.') }}</td>
                                            <td>{{ $pl->satuan }}</td>
                                            <td>{{ number_format($pl->total, 0, ',', '.') }}</td>
                                            <td>{{ $pl->service->nama ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data pricelist.</td>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection