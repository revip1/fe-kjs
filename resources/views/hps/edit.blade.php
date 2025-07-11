@extends('layouts.master')

@section('content')
<div class="container">
    <form action="{{ route('hps.update', $hpsHeader->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- === HPS Header Section === -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>HPS Header</h2>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nama Cargo</label>
                        <input type="text" name="cargo_name" class="form-control form-control-sm" value="{{ $hpsHeader->cargo_name }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Consignee</label>
                        <input type="text" name="consignee" class="form-control form-control-sm" value="{{ $hpsHeader->consignee }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Vessel Name</label>
                        <input type="text" name="vessel_name" class="form-control form-control-sm" value="{{ $hpsHeader->vessel_name }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tonase</label>
                        <input type="text" name="tonase" class="form-control form-control-sm" value="{{ $hpsHeader->tonase }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jumlah Gang</label>
                        <input type="text" name="jumlah_gang" class="form-control form-control-sm" value="{{ $hpsHeader->jumlah_gang }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">L/D Rate</label>
                        <input type="text" name="ldrate" class="form-control form-control-sm" value="{{ $hpsHeader->ldrate }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Hari</label>
                        <input type="text" name="hari" class="form-control form-control-sm" value="{{ $hpsHeader->hari }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Shift</label>
                        <input type="text" name="shift" class="form-control form-control-sm" value="{{ $hpsHeader->shift }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jam</label>
                        <input type="text" name="jam" class="form-control form-control-sm" value="{{ $hpsHeader->jam }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- === Pricelist Section === -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>Pricelist</h2>

                @forelse($hpsHeader->pricelists as $index => $pricelist)
                    <div class="row mb-3 border p-3 rounded bg-light">
                        <input type="hidden" name="pricelists[{{ $index }}][id]" value="{{ $pricelist->id }}">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Jasa</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $pricelist->service->nama ?? 'N/A' }}">
                            <input type="hidden" name="pricelists[{{ $index }}][service_id]" value="{{ $pricelist->service_id }}">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="pricelists[{{ $index }}][qty]" class="form-control form-control-sm" value="{{ $pricelist->qty }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Pemakaian</label>
                            <input type="number" name="pricelists[{{ $index }}][jml_pemakaian]" class="form-control form-control-sm" value="{{ $pricelist->jml_pemakaian }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Tarif</label>
                            <input type="number" name="pricelists[{{ $index }}][price]" class="form-control form-control-sm" value="{{ $pricelist->price }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="pricelists[{{ $index }}][satuan]" class="form-control form-control-sm" value="{{ $pricelist->satuan }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Total</label>
                            <input type="number" name="pricelists[{{ $index }}][total]" class="form-control form-control-sm" value="{{ $pricelist->total }}">
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">Tidak ada data pricelist.</div>
                @endforelse

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
