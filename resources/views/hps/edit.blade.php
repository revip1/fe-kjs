@extends('layouts.master')

@section('content')
<div class="container">
    {{-- CSRF token untuk proteksi keamanan form --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Menampilkan alert jika update berhasil --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Menampilkan daftar error validasi --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form untuk mengedit data HPS --}}
    <form action="{{ route('hps.update', $hpsHeader->id) }}" method="POST" id="mainHpsForm">
        @csrf
        @method('PUT')

        {{-- Section: HPS Header --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h2 class="mb-0">HPS Header</h2></div>
            <div class="card-body row">
                {{-- Nama Cargo --}}
                <div class="col-md-3 mb-3">
                    <label for="cargo_name">Nama Cargo</label>
                    <input type="text" name="cargo_name" id="cargo_name" class="form-control form-control-sm" value="{{ old('cargo_name', $hpsHeader->cargo_name) }}" required>
                </div>
                {{-- Consignee --}}
                <div class="col-md-3 mb-3">
                    <label for="consignee">Consignee</label>
                    <input type="text" name="consignee" id="consignee" class="form-control form-control-sm" value="{{ old('consignee', $hpsHeader->consignee) }}" required>
                </div>
                {{-- Nama Kapal --}}
                <div class="col-md-3 mb-3">
                    <label for="vessel_name">Vessel Name</label>
                    <input type="text" name="vessel_name" id="vessel_name" class="form-control form-control-sm" value="{{ old('vessel_name', $hpsHeader->vessel_name) }}" required>
                </div>
                {{-- Tonase --}}
                <div class="col-md-3 mb-3">
                    <label for="tonase">Tonase</label>
                    <input type="number" name="tonase" id="tonase" class="form-control form-control-sm" value="{{ old('tonase', $hpsHeader->tonase) }}" required>
                </div>
                {{-- TGD (Ton/Gang/Day) --}}
                <div class="col-md-3 mb-3">
                    <label for="tgd" class="form-label">Ton/Gang/Day</label>
                    <input type="number" name="tgd" id="tgd" class="form-control form-control-sm" value="{{ old('tgd', $hpsHeader->tgd) }}" required>
                </div>
                {{-- Jumlah Gang --}}
                <div class="col-md-3 mb-3">
                    <label for="jumlah_gang" class="form-label">Jumlah Gang</label>
                    <input type="number" name="jumlah_gang" id="jumlah_gang" class="form-control form-control-sm" value="{{ old('jumlah_gang', $hpsHeader->jumlah_gang) }}" required>
                </div>
                {{-- L/D Rate (readonly) --}}
                <div class="col-md-3 mb-3">
                    <label for="ldrate" class="form-label">L/D Rate</label>
                    <input type="text" name="ldrate" id="ldrate" class="form-control form-control-sm" value="{{ old('ldrate', $hpsHeader->ldrate) }}" required readonly>
                </div>
                {{-- Hari estimasi kerja --}}
                <div class="col-md-3 mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <input type="text" name="hari" id="hari" class="form-control form-control-sm" value="{{ old('hari', $hpsHeader->hari) }}" required readonly>
                </div>
                {{-- Shift total --}}
                <div class="col-md-3 mb-3">
                    <label for="shift" class="form-label">Shift</label>
                    <input type="text" name="shift" id="shift" class="form-control form-control-sm" value="{{ old('shift', $hpsHeader->shift) }}" required readonly>
                </div>
                {{-- Total jam --}}
                <div class="col-md-3 mb-3">
                    <label for="jam" class="form-label">Jam</label>
                    <input type="text" name="jam" id="jam" class="form-control form-control-sm" value="{{ old('jam', $hpsHeader->jam) }}" required readonly>
                </div>
            </div>
        </div>

        {{-- Section: Pricelist --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h2 class="mb-0">Pricelist</h2></div>
            <div class="card-body" id="pricelistContainer">
                {{-- Loop setiap item pricelist --}}
                @forelse($hpsHeader->pricelists as $index => $pricelist)
                <div class="row align-items-end mb-3 pricelist-item" id="pricelist-item-{{ $index }}">
                    {{-- Hidden input untuk ID Pricelist --}}
                    <input type="hidden" name="pricelists[{{ $index }}][id]" value="{{ $pricelist->id }}">

                    {{-- Select Jasa --}}
                    <div class="col-md-2 mb-3">
                        <label for="service_id_{{ $index }}">Jasa</label>
                        <select name="pricelists[{{ $index }}][service_id]" id="service_id_{{ $index }}" class="form-control form-control-sm service-select" required>
                            <option value="">Pilih Jasa</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-harga="{{ $service->harga }}" {{ $pricelist->service_id == $service->id ? 'selected' : '' }}>{{ $service->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Qty --}}
                    <div class="col-md-1 mb-3">
                        <label for="qty_{{ $index }}">Qty</label>
                        <input type="number" name="pricelists[{{ $index }}][qty]" id="qty_{{ $index }}" class="form-control form-control-sm qty-input" value="{{ old('pricelists.' . $index . '.qty', $pricelist->qty) }}" required min="1">
                    </div>

                    {{-- Jumlah Pemakaian --}}
                    <div class="col-md-2 mb-3">
                        <label for="jml_pemakaian_{{ $index }}">Jumlah</label>
                        <input type="number" name="pricelists[{{ $index }}][jml_pemakaian]" id="jml_pemakaian_{{ $index }}" class="form-control form-control-sm jml-pemakaian-input" value="{{ old('pricelists.' . $index . '.jml_pemakaian', $pricelist->jml_pemakaian) }}" required min="1">
                    </div>

                    {{-- Harga per unit --}}
                    <div class="col-md-2 mb-3">
                        <label for="price_{{ $index }}">Tarif</label>
                        <input type="number" name="pricelists[{{ $index }}][price]" id="price_{{ $index }}" class="form-control form-control-sm price-input" value="{{ old('pricelists.' . $index . '.price', $pricelist->price) }}" readonly>
                    </div>

                    {{-- Pilihan Satuan --}}
                    <div class="col-md-2 mb-3">
                        <label for="satuan_{{ $index }}" class="form-label">Satuan</label>
                        <select name="pricelists[{{ $index }}][satuan]" id="satuan_{{ $index }}" class="form-control form-control-sm" required>
                            <option value="ltr" {{ $pricelist->satuan == 'ltr' ? 'selected' : '' }}>Liter</option>
                            <option value="shift" {{ $pricelist->satuan == 'shift' ? 'selected' : '' }}>Shift</option>
                            <option value="gang" {{ $pricelist->satuan == 'gang' ? 'selected' : '' }}>Gang</option>
                            <option value="paket" {{ $pricelist->satuan == 'paket' ? 'selected' : '' }}>Paket</option>
                            <option value="kapal" {{ $pricelist->satuan == 'kapal' ? 'selected' : '' }}>Kapal</option>
                            <option value="jam" {{ $pricelist->satuan == 'jam' ? 'selected' : '' }}>Jam</option>
                            <option value="ton" {{ $pricelist->satuan == 'ton' ? 'selected' : '' }}>Ton</option>
                            <option value="unit" {{ $pricelist->satuan == 'unit' ? 'selected' : '' }}>Unit</option>
                        </select>
                    </div>

                    {{-- Total harga --}}
                    <div class="col-md-2 mb-3">
                        <label for="total_{{ $index }}">Total</label>
                        <input type="number" name="pricelists[{{ $index }}][total]" id="total_{{ $index }}" class="form-control form-control-sm total-input" value="{{ old('pricelists.' . $index . '.total', $pricelist->total) }}" readonly>
                    </div>

                    {{-- Tombol tambah dan hapus baris pricelist --}}
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-success btn-sm add-pricelist-item me-1">+</button>
                        <button type="button" class="btn btn-danger btn-sm remove-pricelist-item">-</button>
                    </div>
                </div>
                @empty
                {{-- Jika tidak ada data pricelist, tampilkan form kosong pertama --}}
                @endforelse
            </div>
        </div>


        {{-- Summary Fields --}}
        <div class="d-flex justify-content-end mt-4">
            <div class="row w-100" style="max-width: 500px;">
                <div class="col-md-6 mb-2">
                    <label>Total</label>
                    <input type="text" id="total" name="total" class="form-control form-control-sm" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label>PPH (2%)</label>
                    <input type="text" name="pph" id="pph" class="form-control form-control-sm" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Grand Total</label>
                    <input type="text" name="grand_total" id="grand_total" class="form-control form-control-sm" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Tarif/Ton</label>
                    <input type="text" name="tpton" id="tpton" class="form-control form-control-sm" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Margin 5%</label>
                    <input type="text" name="mgn5" id="mgn5" class="form-control form-control-sm" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Margin 10%</label>
                    <input type="text" name="mgn10" id="mgn10" class="form-control form-control-sm" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Margin 15%</label>
                    <input type="text" name="mgn15" id="mgn15" class="form-control form-control-sm" readonly>
                </div>
            </div>
        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pricelistContainer = document.getElementById('pricelistContainer');
    let pricelistItemCount = {{ count($hpsHeader->pricelists) > 0 ? count($hpsHeader->pricelists) - 1 : 0 }};

    function calculateAutoFields() {
        const tonase = parseFloat(document.getElementById('tonase').value) || 0;
        const jumlahGang = parseFloat(document.getElementById('jumlah_gang').value) || 0;
        const tgd = parseFloat(document.getElementById('tgd').value) || 0;

        let ldrate = 0, hari = 0, shift = 0, jam = 0;

        if (tgd !== 0) {
            ldrate = jumlahGang * tgd;
            document.getElementById('ldrate').value = ldrate.toFixed(2);

            hari = tonase / ldrate;
            document.getElementById('hari').value = hari.toFixed(2);

            shift = hari / 3;
            document.getElementById('shift').value = shift.toFixed(2);

            jam = shift * 21; 
            document.getElementById('jam').value = jam.toFixed(2);
        } else {
            document.getElementById('ldrate').value = '';
            document.getElementById('hari').value = '';
            document.getElementById('shift').value = '';
            document.getElementById('jam').value = '';
        }
    }

    // Attach event listeners for header fields
    document.getElementById('tonase').addEventListener('input', calculateAutoFields);
    document.getElementById('jumlah_gang').addEventListener('input', calculateAutoFields);
    document.getElementById('tgd').addEventListener('input', calculateAutoFields);

    function calculatePriceAndTotal(item) {
        const serviceSelect = item.querySelector('.service-select');
        const qty = parseFloat(item.querySelector('.qty-input')?.value || 0);
        const jml = parseFloat(item.querySelector('.jml-pemakaian-input')?.value || 0);
        const harga = parseFloat(serviceSelect.options[serviceSelect.selectedIndex]?.dataset.harga || 0);

        const priceInput = item.querySelector('.price-input');
        const totalInput = item.querySelector('.total-input');

        priceInput.value = harga.toFixed(2);
        totalInput.value = (qty * jml * harga).toFixed(2);

        calculateAllSummary();
    }

    function calculateAllSummary() {
        let total = 0;
        document.querySelectorAll('.total-input').forEach(input => {
            total += parseFloat(input.value || 0);
        });

        const tonase = parseFloat(document.getElementById('tonase')?.value || 1);
        const pph = total * 0.02;
        const grand = total + pph;
        const tpton = tonase !== 0 ? grand / tonase : 0; // Avoid division by zero

        // Get the price of the first pricelist item for margin calculations
        const firstPriceInput = document.querySelector('.pricelist-item .price-input');
        const firstPrice = parseFloat(firstPriceInput?.value || 0);

        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('pph').value = pph.toFixed(2);
        document.getElementById('grand_total').value = grand.toFixed(2);
        document.getElementById('tpton').value = tpton.toFixed(2);
        document.getElementById('mgn5').value = (firstPrice !== 0 ? (firstPrice / 0.95) : 0).toFixed(2);
        document.getElementById('mgn10').value = (firstPrice !== 0 ? (firstPrice / 0.90) : 0).toFixed(2);
        document.getElementById('mgn15').value = (firstPrice !== 0 ? (firstPrice / 0.85) : 0).toFixed(2);
    }

    function attachEvents(item) {
        item.querySelector('.service-select').addEventListener('change', () => calculatePriceAndTotal(item));
        item.querySelector('.qty-input').addEventListener('input', () => calculatePriceAndTotal(item));
        item.querySelector('.jml-pemakaian-input').addEventListener('input', () => calculatePriceAndTotal(item));
        item.querySelector('.remove-pricelist-item').addEventListener('click', () => {
            item.remove();
            updateItemIndexesAndNames();
            updateButtons();
            calculateAllSummary();
        });

        item.querySelector('.add-pricelist-item').addEventListener('click', addPricelistItem);
    }

    function addPricelistItem() {
        pricelistItemCount++;
        const template = `
            <div class="row align-items-end mb-3 pricelist-item" id="pricelist-item-${pricelistItemCount}">
                <div class="col-md-2 mb-3">
                    <label for="service_id_${pricelistItemCount}">Jasa</label>
                    <select name="pricelists[${pricelistItemCount}][service_id]" id="service_id_${pricelistItemCount}" class="form-control form-control-sm service-select" required>
                        <option value="">Pilih Jasa</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" data-harga="{{ $service->harga }}">{{ $service->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="qty_${pricelistItemCount}">Qty</label>
                    <input type="number" name="pricelists[${pricelistItemCount}][qty]" id="qty_${pricelistItemCount}" class="form-control form-control-sm qty-input" required min="1">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="jml_pemakaian_${pricelistItemCount}">Jumlah</label>
                    <input type="number" name="pricelists[${pricelistItemCount}][jml_pemakaian]" id="jml_pemakaian_${pricelistItemCount}" class="form-control form-control-sm jml-pemakaian-input" required min="1">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="price_${pricelistItemCount}">Tarif</label>
                    <input type="number" name="pricelists[${pricelistItemCount}][price]" id="price_${pricelistItemCount}" class="form-control form-control-sm price-input" readonly>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="satuan_${pricelistItemCount}" class="form-label">Satuan</label>
                    <select name="pricelists[${pricelistItemCount}][satuan]" id="satuan_${pricelistItemCount}" class="form-control form-control-sm" required>
                        <option value="ltr">Liter</option>
                        <option value="shift">Shift</option>
                        <option value="gang">Gang</option>
                        <option value="paket">Paket</option>
                        <option value="kapal">Kapal</option>
                        <option value="jam">Jam</option>
                        <option value="ton">Ton</option>
                        <option value="unit">Unit</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="total_${pricelistItemCount}">Total</label>
                    <input type="number" name="pricelists[${pricelistItemCount}][total]" id="total_${pricelistItemCount}" class="form-control form-control-sm total-input" readonly>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-success btn-sm add-pricelist-item me-1">+</button>
                    <button type="button" class="btn btn-danger btn-sm remove-pricelist-item">-</button>
                </div>
            </div>
        `;
        pricelistContainer.insertAdjacentHTML('beforeend', template);
        const newItem = document.getElementById(`pricelist-item-${pricelistItemCount}`);
        attachEvents(newItem);
        updateButtons();
    }

    function updateItemIndexesAndNames() {
        const items = pricelistContainer.querySelectorAll('.pricelist-item');
        items.forEach((item, index) => {
            item.id = `pricelist-item-${index}`;
            item.querySelectorAll('input, select').forEach(el => {
                const oldName = el.getAttribute('name');
                const oldId = el.getAttribute('id');

                if (oldName) {
                    const newName = oldName.replace(/\[\d+\]/, `[${index}]`);
                    el.setAttribute('name', newName);
                }
                if (oldId) {
                    const newId = oldId.replace(/_\d+$/, `_${index}`);
                    el.setAttribute('id', newId);
                }
            });
        });
        pricelistItemCount = items.length - 1; // Update the counter
    }

    function updateButtons() {
        const items = pricelistContainer.querySelectorAll('.pricelist-item');
        items.forEach((item, index) => {
            const addBtn = item.querySelector('.add-pricelist-item');
            const removeBtn = item.querySelector('.remove-pricelist-item');

            addBtn.style.display = index === items.length - 1 ? 'block' : 'none';
            removeBtn.style.display = items.length > 1 ? 'block' : 'none';
        });
    }

    // Initial setup when the page loads
    const initialPricelistItems = document.querySelectorAll('.pricelist-item');
    if (initialPricelistItems.length > 0) {
        initialPricelistItems.forEach(item => attachEvents(item));
    } else {
        // If no pricelists exist (empty array from controller), add a default one
        addPricelistItem(); // This will add the first item with index 0
    }

    calculateAutoFields(); // Calculate header fields on load
    calculateAllSummary(); // Calculate summary totals on load
    updateButtons(); // Ensure button visibility is correct on load

    // Re-calculate all summary fields whenever header inputs change
    document.getElementById('tonase').addEventListener('input', calculateAllSummary);
});
</script>
@endsection