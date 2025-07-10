@extends('layouts.master')

@section('content')
<div class="container">
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h2>HPS Header</h2>
        <form class="row">
            @csrf
            <div class="col-md-3 mb-3">
                <label class="form-label">Nama Cargo</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->cargo_name }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Consignee</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->consignee }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Vessel Name</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->vessel_name }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Tonase</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->tonase }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jumlah Gang</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->jumlah_gang }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">L/D Rate</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->ldrate }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Hari</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->hari }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Shift</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->shift }}" readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jam</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->jam }}" readonly>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h2>Pricelist</h2>

            @forelse($hpsHeader->pricelists as $index => $pricelist)
        <div class="row mb-3 border p-3 rounded bg-light">
            <div class="col-md-2 mb-3">
                <label class="form-label">Jasa</label>
                <input type="text" class="form-control form-control-sm" value="{{ $pricelist->service->nama ?? 'N/A' }}" readonly>
            </div>
            <div class="col-md-1 mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control form-control-sm" value="{{ $pricelist->qty }}" readonly>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Pemakaian</label>
                <input type="number" class="form-control form-control-sm" value="{{ $pricelist->jml_pemakaian }}" readonly>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Tarif</label>
                <input type="text" class="form-control form-control-sm" value="Rp {{ number_format($pricelist->price, 0, ',', '.') }}" readonly>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" class="form-control form-control-sm" value="{{ $pricelist->satuan }}" readonly>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Total</label>
                <input type="text" class="form-control form-control-sm" value="Rp {{ number_format($pricelist->total, 0, ',', '.') }}" readonly>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">Tidak ada data pricelist.</div>
    @endforelse


        <div class="mt-4">
            <a href="{{ route('hps.index') }}" class="btn btn-secondary">Kembali ke Daftar HPS</a>
        </div>
    </div>
</div>

@endsection