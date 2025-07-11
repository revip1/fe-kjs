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
                <label class="form-label">Ton/Gang/Day</label>
                <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->tgd }}" readonly>
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

<form>
    @csrf

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2>Pricelist</h2>

            @if($hpsHeader->pricelists->isEmpty())
                <div class="alert alert-warning">Tidak ada data pricelist.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Jasa</th>
                                <th>Quantity</th>
                                <th>Jumlah Pemakaian</th>
                                <th>Tarif</th>
                                <th>Satuan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hpsHeader->pricelists as $index => $pricelist)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="{{ $pricelist->service->nama ?? 'N/A' }}" readonly>
                                        <input type="hidden" name="pricelists[{{ $index }}][service_id]" value="{{ $pricelist->service_id }}">
                                    </td>
                                    <td>
                                        <input type="number" name="pricelists[{{ $index }}][qty]" class="form-control form-control-sm" value="{{ $pricelist->qty }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="pricelists[{{ $index }}][jml_pemakaian]" class="form-control form-control-sm" value="{{ $pricelist->jml_pemakaian }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="pricelists[{{ $index }}][price]" class="form-control form-control-sm" value="{{ $pricelist->price }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="pricelists[{{ $index }}][satuan]" class="form-control form-control-sm" value="{{ $pricelist->satuan }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="pricelists[{{ $index }}][total]" class="form-control form-control-sm" value="{{ $pricelist->total }}" readonly>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</form>


    <div class="d-flex justify-content-end mt-4">
    <div class="row w-100" style="max-width: 500px;">
        <div class="col-md-6 mb-2">
            <label class="form-label">Total</label>
            <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->total }}" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">PPH</label>
            <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->pph }}" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">Grand Total</label>
            <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->grand_total }}" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">Tarif/TON</label>
            <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->tpton }}" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">Margin 5%</label>
            <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->mgn5 }}" readonly>
        </div>
        <div class="col-md-6 mb-2">
            <label class="form-label">Margin 10%</label>
            <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->mgn10 }}" readonly>
        </div>  
        <div class="col-md-6 mb-2">
            <label class="form-label">Margin 15%</label>
            <input type="text" class="form-control form-control-sm" value="{{ $hpsHeader->mgn15 }}" readonly>
        </div>
    </div>
</div>

        <div class="mt-4">
            <a href="{{ route('hps.overview') }}" class="btn btn-secondary">Kembali ke Daftar HPS</a>
        </div>
    </div>
</div>

@endsection