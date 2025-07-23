@extends('layouts.master')

@section('content')
<div class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{ -- Show success alert if available -- }}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    <form action="{{ route('hps.store') }}" method="POST" id="mainHpsForm">
        @csrf

        
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h2 class="mb-0">HPS Header</h2></div>
            <div class="card-body row">
                <div class="col-md-3 mb-3">
                    <label for="cargo_name">Nama Cargo</label>
                    <input type="text" name="cargo_name" id="cargo_name" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="consignee">Consignee</label>
                    <input type="text" name="consignee" id="consignee" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="vessel_name">Vessel Name</label>
                    <input type="text" name="vessel_name" id="vessel_name" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tonase">Tonase</label>
                    <input type="number" name="tonase" id="tonase" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                        <label for="tgd" class="form-label">Ton/Gang/Day</label>
                        <input type="number" name="tgd" id="tgd" class="form-control form-control-sm" value="{{ old('tgd') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="jumlah_gang" class="form-label">Jumlah Gang</label>
                        <input type="number" name="jumlah_gang" id="jumlah_gang" class="form-control form-control-sm" value="{{ old('jumlah_gang') }}" required>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="ldrate" class="form-label">L/D Rate</label>
                        <input type="text" name="ldrate" id="ldrate" class="form-control form-control-sm" value="{{ old('ldrate') }}" required readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <input type="text" name="hari" id="hari" class="form-control form-control-sm" value="{{ old('hari') }}" required readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="shift" class="form-label">Shift</label>
                        <input type="text" name="shift" id="shift" class="form-control form-control-sm" value="{{ old('shift') }}" required readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="text" name="jam" id="jam" class="form-control form-control-sm" value="{{ old('jam') }}" required readonly>
                    </div>
            </div>
        </div>


        <div class="card shadow-sm mb-4">
            <div class="card-header"><h2 class="mb-0">Pricelist</h2></div>
            <div class="card-body" id="pricelistContainer">
                <div class="row align-items-end mb-3 pricelist-item" id="pricelist-item-0">
                    <div class="col-md-2 mb-3">
                        <label for="service_id_0">Jasa</label>
                        <select name="pricelists[0][service_id]" id="service_id_0" class="form-control form-control-sm service-select" required>
                            <option value="">Pilih Jasa</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-harga="{{ $service->harga }}" data-nama="{{ $service->nama }}">{{ $service->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="qty_0">Qty</label>
                        <input type="number" name="pricelists[0][qty]" id="qty_0" class="form-control form-control-sm qty-input" required min="1">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="jml_pemakaian_0">Jumlah</label>
                        <input type="number" name="pricelists[0][jml_pemakaian]" id="jml_pemakaian_0" class="form-control form-control-sm jml-pemakaian-input" required min="1">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="price_0">Tarif</label>
                        <input type="number" name="pricelists[0][price]" id="price_0" class="form-control form-control-sm price-input" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                            <label for="satuan_0" class="form-label">Satuan</label>
                            <select name="pricelists[0][satuan]" id="satuan_0" class="form-control form-control-sm" required>
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
                        <label for="total_0">Total</label>
                        <input type="number" name="pricelists[0][total]" id="total_0" class="form-control form-control-sm total-input" readonly>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-success btn-sm add-pricelist-item me-1">+</button>
                        <button type="button" class="btn btn-danger btn-sm remove-pricelist-item" style="display: none;">-</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Total -->
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
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pricelistContainer = document.getElementById('pricelistContainer');
    let pricelistItemCount = 0;

    function calculateAutoFields() {
        const tonase = parseFloat(document.getElementById('tonase').value) || 0;
        const gang = parseFloat(document.getElementById('jumlah_gang').value) || 0;
        const tgd = parseFloat(document.getElementById('tgd').value) || 0;

        let ldrate = 0, hari = 0, shift = 0, jam = 0;

        if (tgd !== 0) {
            ldrate = gang * tgd;
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
        const tpton = grand / tonase;

        const firstPrice = parseFloat(document.querySelector('.price-input')?.value || 0);
        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('pph').value = pph.toFixed(2);
        document.getElementById('grand_total').value = grand.toFixed(2);
        document.getElementById('tpton').value = tpton.toFixed(2);
        document.getElementById('mgn5').value = (firstPrice / 0.95).toFixed(2);
        document.getElementById('mgn10').value = (firstPrice / 0.90).toFixed(2);
        document.getElementById('mgn15').value = (firstPrice / 0.85).toFixed(2);
    }

        function attachEvents(item) {
        item.querySelector('.service-select').addEventListener('change', () => calculatePriceAndTotal(item));
        item.querySelector('.qty-input').addEventListener('input', () => calculatePriceAndTotal(item));
        item.querySelector('.jml-pemakaian-input').addEventListener('input', () => calculatePriceAndTotal(item));
        item.querySelector('.remove-pricelist-item').addEventListener('click', () => {
            item.remove();
            updateButtons();
            calculateAllSummary();
        });

        // Tambahkan event listener untuk tombol +
        item.querySelector('.add-pricelist-item').addEventListener('click', addPricelistItem);
    }


        function addPricelistItem() {
        pricelistItemCount++;
        const clone = pricelistContainer.querySelector('.pricelist-item').cloneNode(true);
        const newIndex = pricelistItemCount;
        clone.id = `pricelist-item-${newIndex}`;

        clone.querySelectorAll('input, select').forEach(el => {
            const oldName = el.getAttribute('name');
            const oldId = el.getAttribute('id');

            if (oldName) {
                const newName = oldName.replace(/\[\d+\]/, `[${newIndex}]`);
                el.setAttribute('name', newName);
            }

            if (oldId) {
                const newId = oldId.replace(/_\d+$/, `_${newIndex}`);
                el.setAttribute('id', newId);
            }

            if (el.tagName === 'SELECT') {
                el.selectedIndex = 0;
            } else {
                el.value = '';
            }
        });

        pricelistContainer.appendChild(clone);
        attachEvents(clone);
        updateButtons();
    }


    function updateButtons() {
    const items = document.querySelectorAll('.pricelist-item');

    items.forEach((item, index) => {
        const addBtn = item.querySelector('.add-pricelist-item');
        const removeBtn = item.querySelector('.remove-pricelist-item');

        addBtn.style.display = index === items.length - 1 ? 'block' : 'none';

        removeBtn.style.display = items.length > 1 ? 'block' : 'none';
    });
}


    attachEvents(document.getElementById('pricelist-item-0'));
    document.querySelector('.add-pricelist-item').addEventListener('click', addPricelistItem);
    document.getElementById('tonase').addEventListener('input', calculateAllSummary);
});
</script>
@endsection
