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
            <form method="GET" action="{{ route('hps.overview') }}" class="row mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari cargo, consignee, vessel..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>

            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Cargo</th>
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
                        <td>{{ $loop->iteration + ($hpsHeaders->currentPage() - 1) * $hpsHeaders->perPage() }}</td>
                        <td>{{ $header->cargo_name }}</td>
                        <td>{{ $header->consignee }}</td>
                        <td>{{ $header->vessel_name }}</td>
                        <td>{{ number_format($header->tonase, 0, ',', '.') }}</td>
                        <td>{{ fmod($header->tgd, 1) == 0 ? number_format($header->tgd, 0, ',', '.') : number_format($header->tgd, 2, ',', '.') }}</td>
                        <td>{{ fmod($header->hari, 1) == 0 ? number_format($header->hari, 0, ',', '.') : number_format($header->hari, 2, ',', '.') }}</td>
                        <td>{{ fmod($header->jam, 1) == 0 ? number_format($header->jam, 0, ',', '.') : number_format($header->jam, 2, ',', '.') }}</td>
                        <td>{{ fmod($header->shift, 1) == 0 ? number_format($header->shift, 0, ',', '.') : number_format($header->shift, 2, ',', '.') }}</td>

                        <td>
                            <a href="{{ route('hps.show', $header->id) }}" class="btn btn-sm btn-info mb-1">
                                Detail
                            </a>
                            <a href="{{ route('hps.pdf', $header->id) }}" class="btn btn-sm btn-danger mb-1" target="_blank">
                                PDF
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
            <div class="d-flex justify-content-end">
                {{ $hpsHeaders->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
